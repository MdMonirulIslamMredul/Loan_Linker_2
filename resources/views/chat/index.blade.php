@php
    $layout = 'layouts.app';
    if (auth()->user()->isSuperAdmin()) {
        $layout = 'layouts.admin';
    } elseif (auth()->user()->isBankAdmin()) {
        $layout = 'layouts.bank-admin';
    } elseif (auth()->user()->isBranchAdmin()) {
        $layout = 'layouts.branch-admin';
    } elseif (auth()->user()->isCustomer()) {
        $layout = 'layouts.customer';
    }

    $sectionName = auth()->user()->isCustomer() ? 'customer-content' : 'content';
    $title = 'Chat | '.config('app.name');
@endphp

@extends($layout)

@section('title', 'Chat | '.config('app.name'))
@section('dashboard-title', 'Chat')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-id" content="{{ auth()->id() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endpush

@section($sectionName)
<div class="chat-interface">
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="chat-user-profile d-flex align-items-center">
                    <div class="chat-avatar bg-primary text-white me-2">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="mb-0 text-white">{{ auth()->user()->name }}</h6>
                        <small class="text-white-50">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</small>
                    </div>
                </div>
                <a href="{{ url('/') }}" class="text-white text-decoration-none ms-3" title="Back to Dashboard">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
            <div class="chat-search-box mt-3">
                <input type="text" id="user-search" class="form-control" placeholder="Search users...">
                <div id="search-results" class="chat-search-results shadow-sm d-none"></div>
            </div>
        </div>

        <div class="chat-conversation-list" id="conversation-list">
            <div class="text-center text-muted p-4" id="conversations-loading">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        </div>
    </div>

    <div class="chat-main">
        <div class="chat-empty-state d-flex flex-column align-items-center justify-content-center h-100" id="chat-empty">
            <div class="empty-icon text-muted mb-3">
                <i class="far fa-comments fa-4x"></i>
            </div>
            <h4 class="text-muted">Select a conversation to start messaging</h4>
        </div>

        <div class="chat-active-state d-none d-flex flex-column h-100" id="chat-active">
            <div class="chat-header border-bottom p-3 d-flex align-items-center bg-white">
                <div class="chat-avatar bg-secondary text-white me-3" id="active-user-avatar">?</div>
                <div class="flex-grow-1">
                    <h5 class="mb-0" id="active-user-name">User Name</h5>
                    <small class="text-muted" id="active-user-role">Role</small>
                </div>
            </div>

            <div class="chat-body flex-grow-1 p-3 overflow-auto" id="chat-body"></div>

            <div class="typing-indicator px-3 py-1 d-none text-muted small" id="typing-indicator">
                User is typing...
            </div>

            <div class="chat-footer p-3 bg-white border-top">
                <form id="chat-form" enctype="multipart/form-data">
                    <div class="d-flex align-items-center gap-2">
                        <label for="attachment-input" class="btn btn-light rounded-circle btn-icon mb-0" title="Attach File">
                            <i class="fas fa-paperclip"></i>
                        </label>
                        <input type="file" id="attachment-input" name="attachments[]" multiple class="d-none" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                        <input type="text" class="form-control rounded-pill px-4 py-2" id="message-input" placeholder="Type a message..." autocomplete="off">
                        <button type="submit" class="btn btn-primary rounded-circle btn-icon" id="send-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <div id="attachment-preview" class="mt-2 d-flex gap-2 flex-wrap"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@vite(['resources/js/app.js'])
<script src="{{ asset('js/chat.js') }}"></script>
@endpush
