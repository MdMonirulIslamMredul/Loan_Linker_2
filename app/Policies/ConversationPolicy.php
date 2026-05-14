<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use App\Services\ChatAccessService;

class ConversationPolicy
{
    protected $chatService;

    public function __construct(ChatAccessService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // We'll filter the query in the controller
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Conversation $conversation): bool
    {
        return $user->id === $conversation->user_one_id || $user->id === $conversation->user_two_id;
    }

    /**
     * Determine whether the user can create a conversation with another user.
     */
    public function create(User $user, User $otherUser): bool
    {
        return $this->chatService->canChat($user, $otherUser);
    }
}
