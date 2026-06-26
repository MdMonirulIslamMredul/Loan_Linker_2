@extends('layouts.admin')

@section('title', 'Badges')
@section('dashboard-title', 'Super Admin - Badges')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">Badges</h2>
                <a href="{{ route('super-admin.badges.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create Badge
                </a>
            </div>

            @if($badges->isEmpty())
                <p class="text-muted">No badges available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                 <th>Logo</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($badges as $badge)
                                <tr>
                                    <td>{{ $badge->id }}</td>
                                    <td>{{ $badge->name }}</td>
                                    <td>
                                        @if($badge->logo)
                                            <img src="{{ asset($badge->logo) }}" alt="{{ $badge->name }}" class="img-fluid" style="max-height: 50px;">
                                        @else
                                            <span class="text-muted">No logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $badge->type ?? 'N/A' }}</td>
                                    
                                    <td>
                                        <span class="badge {{ $badge->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $badge->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $badge->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('super-admin.badges.edit', $badge) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.badges.destroy', $badge) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this badge?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $badges->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
