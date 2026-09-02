@extends('layouts.admin')

@section('title', 'Admin Users')
@section('dashboard-title', 'Admin Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Admin Users</h2>
            <p class="text-muted mb-0">Manage super-admin created admin users.</p>
        </div>
@php
        $canCreateAdmin = auth()->user()->isSuperAdmin() || auth()->user()->hasPermissionTo('admins.create', 'web');
        $canViewAdmin = auth()->user()->isSuperAdmin() || auth()->user()->hasPermissionTo('admins.view', 'web');
    @endphp
    @if ($canCreateAdmin)
        <a href="{{ route('super-admin.admins.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Create Admin
        </a>
    @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive shadow-sm border rounded">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->phone ?? '-' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $admin->role)) }}</td>
                        <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                        <td class="text-end">
                            @if ($canCreateAdmin)
                            <a href="{{ route('super-admin.admins.edit', $admin) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            @else
                            <span class="text-muted small"><i class="bi bi-eye"></i> View Only</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No admin users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        {{ $admins->links() }}
    </div>
@endsection
