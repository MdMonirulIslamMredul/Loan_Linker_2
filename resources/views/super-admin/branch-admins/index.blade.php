@extends('layouts.admin')

@section('title', 'Branch Admins')
@section('dashboard-title', 'Branch Admins Management')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-person-plus fs-2 text-info"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1 fw-bold text-dark">Branch Admins / Officers</h2>
                                    <p class="mb-0 text-muted">Manage all branch administrators and officers</p>
                                </div>
                            </div>
                            <a href="{{ route('super-admin.branch-admins.create') }}" class="btn btn-info">
                                <i class="bi bi-plus-circle me-2"></i>Create Branch Admin / Officer
                            </a>
                        </div>
                    </div>
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

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total Branch Admins</p>
                                <h3 class="mb-0 fw-bold">{{ $branchAdmins->total() }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people-fill text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Active</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $branchAdmins->where('is_active', true)->count() }}
                                </h3>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Inactive</p>
                                <h3 class="mb-0 fw-bold text-danger">{{ $branchAdmins->where('is_active', false)->count() }}
                                </h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-x-circle text-danger fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branch Admins Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-table me-2"></i>Branch Admins List</h5>
                    <span class="badge bg-info rounded-pill">{{ $branchAdmins->total() }} Total</span>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($branchAdmins->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Phone</th>
                                    <th class="py-3">Branch</th>
                                    <th class="py-3">Bank</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Created Date</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branchAdmins as $admin)
                                    <tr>
                                        <td class="px-4">
                                            <span class="badge bg-secondary">#{{ $admin->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person-plus text-info"></i>
                                                </div>
                                                <strong>{{ $admin->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-envelope me-1"></i>{{ $admin->email }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>{{ $admin->phone }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-shop me-1"></i>{{ $admin->branch->name ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-building me-1"></i>{{ $admin->branch->bank->name ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if ($admin->is_active)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-calendar3 me-1"></i>{{ $admin->created_at->format('d M, Y') }}
                                            </small>
                                        </td>
                                        <td class="px-4">
                                            <a href="{{ route('super-admin.branch-admins.edit', $admin) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $branchAdmins->firstItem() }} to {{ $branchAdmins->lastItem() }} of
                                {{ $branchAdmins->total() }} admins
                            </div>
                            <div>
                                {{ $branchAdmins->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">No Branch Admins Found</h5>
                        <p class="text-muted">There are no branch administrators in the system.</p>
                        <a href="{{ route('super-admin.branch-admins.create') }}" class="btn btn-info mt-3">
                            <i class="bi bi-plus-circle me-2"></i>Create Branch Admin
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
