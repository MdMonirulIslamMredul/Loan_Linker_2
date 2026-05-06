@extends('layouts.admin')

@section('title', 'View Message')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Message #{{ $message->id }}</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('super-admin.customer-messages.index') }}" class="btn btn-secondary">Back</a>
                <form action="{{ route('super-admin.customer-messages.markRead', $message->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-{{ $message->is_read ? 'warning' : 'success' }}">
                        {{ $message->is_read ? 'Mark Unread' : 'Mark Read' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">{{ trim(($message->first_name ?? '') . ' ' . ($message->last_name ?? '')) ?: '—' }}
                    </dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $message->email }}</dd>

                    <dt class="col-sm-3">Mobile</dt>
                    <dd class="col-sm-9">{{ $message->mobile }}</dd>

                    <dt class="col-sm-3">Received</dt>
                    <dd class="col-sm-9">{{ $message->created_at->toDayDateTimeString() }}</dd>

                    <dt class="col-sm-3">IP Address</dt>
                    <dd class="col-sm-9">{{ $message->ip_address ?? '—' }}</dd>

                    <dt class="col-sm-3">User Agent</dt>
                    <dd class="col-sm-9">
                        <pre class="small">{{ $message->user_agent }}</pre>
                    </dd>

                    <dt class="col-sm-3">Message</dt>
                    <dd class="col-sm-9">{{ $message->message ?: '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
