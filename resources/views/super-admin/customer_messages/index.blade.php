@extends('layouts.admin')

@section('title', 'Customer Messages')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Customer Messages</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Message</th>
                                <th>Read</th>
                                <th>Received</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $msg)
                                <tr class="{{ $msg->is_read ? '' : 'table-info' }}">
                                    <td>{{ $msg->id }}</td>
                                    <td>{{ trim(($msg->first_name ?? '') . ' ' . ($msg->last_name ?? '')) ?: '—' }}</td>
                                    <td>{{ $msg->email }}</td>
                                    <td>{{ $msg->mobile }}</td>
                                    <td>{{ Str::limit($msg->message, 80) }}</td>
                                    <td>{{ $msg->is_read ? 'Yes' : 'No' }}</td>
                                    <td>{{ $msg->created_at->diffForHumans() }}</td>
                                    <td style="white-space:nowrap">
                                        <a href="{{ route('super-admin.customer-messages.show', $msg->id) }}"
                                            class="btn btn-sm btn-primary">View</a>

                                        <form action="{{ route('super-admin.customer-messages.markRead', $msg->id) }}"
                                            method="POST" style="display:inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm btn-{{ $msg->is_read ? 'warning' : 'success' }}">
                                                {{ $msg->is_read ? 'Mark Unread' : 'Mark Read' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No messages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
