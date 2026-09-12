@extends('layouts.admin')

@section('title', 'Admin Feature Permissions')
@section('dashboard-title', 'Manage Admin Feature Permissions')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">Admin Feature Permissions</h4>
                <p class="text-muted mb-0">Assign accessible Admin features to other admins.</p>
            </div>
            <div>
                <a href="{{ route('super-admin.permissions.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-repeat me-1"></i>Refresh
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($admins->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <!-- <th>Bank / Branch</th> -->
                            <th>Assigned Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $admin->role)) }}</td>
                            <td>{{ $admin->email }}</td>
                            <!-- <td>
                                            @if ($admin->branch)
                                                <span class="badge bg-info text-dark">{{ $admin->branch->name }}</span>
                                            @elseif ($admin->bank)
                                                <span class="badge bg-warning text-dark">{{ $admin->bank->name }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td> -->
                            <td>
                                <span class="badge bg-secondary text-white">
                                    {{ $admin->permissions->count() }} assigned
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('super-admin.permissions.edit', $admin) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-4 text-center text-muted">
                <p class="mb-2">No admin users are available for permission assignment.</p>
                <p class="mb-0">Create bank or branch admins first to assign feature permissions.</p>
            </div>
            @endif
        </div>
        <div class="card-footer bg-white border-top">
            {{ $admins->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection