@extends('layouts.admin')

@section('title', 'Customers')
@section('dashboard-title', 'Customers Management')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-people-fill fs-2 text-success"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1 fw-bold text-dark">Customers</h2>
                                    <p class="mb-0 text-muted">List of registered customers</p>
                                </div>
                            </div>
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

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total Customers</p>
                                <h3 class="mb-0 fw-bold">{{ $customers->total() }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people-fill text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-table me-2"></i>Customers List</h5>
                <span class="badge bg-success rounded-pill">{{ $customers->total() }} Total</span>
            </div>
            <div class="card-body p-0">
                @if ($customers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Phone</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Created Date</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $c)
                                    <tr>
                                        <td class="px-4"><span class="badge bg-secondary">#{{ $c->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person text-success"></i>
                                                </div>
                                                <strong>{{ $c->name }}</strong>
                                            </div>
                                        </td>
                                        <td><small class="text-muted"><i
                                                    class="bi bi-envelope me-1"></i>{{ $c->email }}</small></td>
                                        <td><small class="text-muted"><i
                                                    class="bi bi-telephone me-1"></i>{{ $c->phone }}</small></td>
                                        <td>
                                            @if ($c->is_active)
                                                <span class="badge bg-success"><i
                                                        class="bi bi-check-circle me-1"></i>Active</span>
                                            @else
                                                <span class="badge bg-danger"><i
                                                        class="bi bi-x-circle me-1"></i>Inactive</span>
                                            @endif
                                        </td>
                                        <td><small class="text-muted"><i
                                                    class="bi bi-calendar3 me-1"></i>{{ $c->created_at->format('d M, Y') }}</small>
                                        </td>
                                        <td>
                                            <form action="{{ route('super-admin.customers.reset-password', $c->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Reset password to default for this customer?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-key"></i> Reset Password
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">Showing {{ $customers->firstItem() }} to
                                {{ $customers->lastItem() }} of {{ $customers->total() }} customers</div>
                            <div>{{ $customers->links() }}</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">No Customers Found</h5>
                        <p class="text-muted">There are no customers in the system.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
