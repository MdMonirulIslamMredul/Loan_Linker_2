@extends('layouts.bank-admin')

@section('title', 'Bank Admin Dashboard')
@section('dashboard-title', 'Bank Admin Dashboard')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('bank-admin.branches.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-shop text-primary fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-primary mb-2">Create Branch</h5>
                        <p class="text-muted mb-0 small">Add a new branch</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('bank-admin.branch-admins.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-person-plus text-success fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-success mb-2">Create Branch Admin</h5>
                        <p class="text-muted mb-0 small">Add a new branch administrator</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('bank-admin.branches.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-purple bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-diagram-3 text-purple fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-purple mb-2">View All Branches</h5>
                        <p class="text-muted mb-0 small">Manage all branches</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0"><i class="bi bi-shop me-2"></i>Branches Overview</h4>
        </div>
        <div class="card-body">
            @if ($branches->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No branches created yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Branch Name</th>
                                <th class="py-3">Code</th>
                                <th class="py-3">City</th>
                                <th class="py-3">Users</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="bi bi-shop text-primary"></i>
                                            </div>
                                            <strong>{{ $branch->name }}</strong>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $branch->code }}</span></td>
                                    <td><span class="text-muted">{{ $branch->city ?? 'N/A' }}</span></td>
                                    <td><span class="text-muted">{{ $branch->users_count }}</span></td>
                                    <td>
                                        @if ($branch->is_active)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .hover-lift {
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            }

            .text-purple {
                color: #6f42c1;
            }

            .bg-purple {
                background-color: #6f42c1;
            }
        </style>
    @endpush
@endsection
