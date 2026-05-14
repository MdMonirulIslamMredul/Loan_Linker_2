<?php

namespace App\Http\Controllers;

use App\Events\MessageSeen;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\User;
use App\Services\ChatAccessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatAccessService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        return view('chat.index');
    }

    public function getConversations()
    {
        $userId = Auth::id();

        $conversations = Conversation::with(['userOne:id,name,role', 'userTwo:id,name,role'])
            ->where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->get()
            ->map(function ($conversation) use ($userId) {
                // Determine the other user
                $otherUser = $conversation->user_one_id === $userId ? $conversation->userTwo : $conversation->userOne;
                
                // Get last message
                $lastMessage = $conversation->messages()->latest()->first();

                // Get unread count
                $unreadCount = $conversation->messages()
                    ->where('sender_id', '!=', $userId)
                    ->where('is_seen', false)
                    ->count();

                return [
                    'id' => $conversation->id,
                    'user' => $otherUser,
                    'last_message' => $lastMessage ? $lastMessage->message : null,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : null,
                    'last_message_raw_time' => $lastMessage ? $lastMessage->created_at : $conversation->created_at,
                    'unread_count' => $unreadCount,
                ];
            })->sortByDesc('last_message_raw_time')->values();

        return response()->json($conversations);
    }

    public function getMessages($conversationId)
    {
        $userId = Auth::id();
        $conversation = Conversation::findOrFail($conversationId);

        // Ensure user belongs to conversation
        if ($conversation->user_one_id !== $userId && $conversation->user_two_id !== $userId) {
            abort(403, 'Unauthorized access to conversation.');
        }

        $messages = Message::with(['sender:id,name,role', 'attachments'])
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'nullable|exists:conversations,id',
            'receiver_id' => 'required_without:conversation_id|exists:users,id',
            'message' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120',
        ]);

        if (!$request->message && !$request->hasFile('attachments')) {
            return response()->json(['error' => 'Message or attachment is required'], 422);
        }

        $userId = Auth::id();
        $conversationId = $request->conversation_id;

        // If no conversation_id is provided, find or create one based on receiver_id
        if (!$conversationId) {
            $receiver = User::findOrFail($request->receiver_id);

            if (!$this->chatService->canChat(Auth::user(), $receiver)) {
                return response()->json(['error' => 'You are not authorized to chat with this user.'], 403);
            }

            $conversation = Conversation::where(function ($q) use ($userId, $request) {
                $q->where('user_one_id', $userId)->where('user_two_id', $request->receiver_id);
            })->orWhere(function ($q) use ($userId, $request) {
                $q->where('user_one_id', $request->receiver_id)->where('user_two_id', $userId);
            })->first();

            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_one_id' => $userId,
                    'user_two_id' => $request->receiver_id,
                ]);
            }
            $conversationId = $conversation->id;
        } else {
            $conversation = Conversation::findOrFail($conversationId);
            if ($conversation->user_one_id !== $userId && $conversation->user_two_id !== $userId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        // Create the message
        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $userId,
            'message' => $request->message,
            'is_seen' => false,
        ]);

        // Handle Attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('chat_attachments', 'public');
                $extension = $file->getClientOriginalExtension();
                $type = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : 'document';
                
                MessageAttachment::create([
                    'message_id' => $message->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $type,
                ]);
            }
        }

        $receiverId = $conversation->user_one_id === $userId ? $conversation->user_two_id : $conversation->user_one_id;

        // Broadcast Event
        broadcast(new MessageSent($message, $receiverId))->toOthers();

        return response()->json($message->load(['sender:id,name,role', 'attachments']));
    }

    public function markAsSeen($conversationId)
    {
        $userId = Auth::id();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $userId && $conversation->user_two_id !== $userId) {
            abort(403);
        }

        $updated = Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $userId)
            ->where('is_seen', false)
            ->update([
                'is_seen' => true,
                'seen_at' => now(),
            ]);

        if ($updated) {
            $receiverId = $conversation->user_one_id === $userId ? $conversation->user_two_id : $conversation->user_one_id;
            broadcast(new MessageSeen($conversationId, $receiverId))->toOthers();
        }

        return response()->json(['success' => true]);
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('q');
        $currentUser = Auth::user();

        // Base query for users
        $query = User::where('id', '!=', $currentUser->id)
            ->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });

        // Get all potential users
        $potentialUsers = $query->limit(50)->get();

        // Filter using the ChatAccessService
        $allowedUsers = $potentialUsers->filter(function ($user) use ($currentUser) {
            return $this->chatService->canChat($currentUser, $user);
        })->values()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ];
        });

        return response()->json($allowedUsers);
    }
}
