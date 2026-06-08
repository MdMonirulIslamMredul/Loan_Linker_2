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

                                <div class="badge bg-primary rounded-pill px-3 py-2">
                                    <span class="fw-bold">{{ $customers->total() }}</span> Customers
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('super-admin.customers.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Name, email, or phone" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="c_district_id" class="form-label">District</label>
                        <select name="c_district_id" id="c_district_id" class="form-select">
                            <option value="">All Districts</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ request('c_district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                    </div>
                    <div class="col-12 text-end">
                        <a href="{{ route('super-admin.customers.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-circle me-1"></i>Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
{{-- 
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
        </div> --}}

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
                                                @if(optional($c->customerDocument)->picture)
                                                    <img src="{{ asset('storage/' . optional($c->customerDocument)->picture) }}"
                                                        alt="{{ $c->name }}"
                                                        class="rounded-circle me-2"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="bi bi-person text-success"></i>
                                                    </div>
                                                @endif
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
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('super-admin.customers.show', $c->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye"></i> View and Update Documents
                                                </a>

                                                <form action="{{ route('super-admin.customers.reset-password', $c->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Reset password to default for this customer?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-key"></i> Reset Password
                                                    </button>
                                                </form>
                                            </div>
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
                            <div>{{ $customers->links('pagination::bootstrap-5') }}</div>
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

