@extends('layouts.admin')

@section('title', ' Bank Officers Management')
@section('dashboard-title', ' Bank Officers Management')

@section('content')
    <div class="container-fluid py-4">
       
       <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total Bank Officers</p>
                                <h3 class="mb-0 fw-bold">{{ $stats['total'] ?? $branchAdmins->total() }}</h3>
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
                                <p class="text-muted mb-1 small">Access Granted</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $stats['access_granted'] ?? $branchAdmins->where('is_access', true)->count() }}</h3>
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
                                <p class="text-muted mb-1 small">No Access</p>
                                <h3 class="mb-0 fw-bold text-danger">{{ $stats['no_access'] ?? $branchAdmins->where('is_access', false)->count() }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-x-circle text-danger fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('super-admin.branch-admins.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Access Status</label>
                            <select name="is_access" class="form-select">
                                <option value="" {{ request('is_access') === null ? 'selected' : '' }}>All</option>
                                <option value="1" {{ request('is_access') === '1' ? 'selected' : '' }}>Access Granted</option>
                                <option value="0" {{ request('is_access') === '0' ? 'selected' : '' }}>No Access</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bank</label>
                            <select name="bank_id" class="form-select">
                                <option value="">All Banks</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Area / District</label>
                            <select name="district_id" class="form-select">
                                <option value="">All Districts</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Created From</label>
                            <input type="date" name="created_from" class="form-control" value="{{ request('created_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Created To</label>
                            <input type="date" name="created_to" class="form-control" value="{{ request('created_to') }}">
                        </div>
                        <div class="col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-info w-100">Filter</button>
                            <a href="{{ route('super-admin.branch-admins.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif --}}

      

        <!-- Branch Admins Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-table me-2"></i>Bank Officers List</h5>
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
                                                <i class="bi bi-shop me-1"></i>{{ $admin->bank->name ?? 'N/A' }}
                                            </span>
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

                                            @if ($admin->is_access)
                                                <span class="badge bg-info ms-1">
                                                    <i class="bi bi-unlock me-1"></i>Access Granted
                                                </span>
                                            @else
                                                <span class="badge bg-secondary ms-1">
                                                    <i class="bi bi-lock me-1"></i>No Access
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

                                            <a href="{{ route('super-admin.branch-admins.show', $admin) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>View 
                                            </a> 

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
                                {{ $branchAdmins->total() }} Bank Officers
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
