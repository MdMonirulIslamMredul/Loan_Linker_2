@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="bi bi-file-text me-2"></i>Loan Applications</h2>
                <p class="text-muted">Manage loan applications for your branch</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $user = auth()->user();
            $hasAnyLeads = false;
            if ($user->isSuperAdmin() || $user->isBankAdmin() || $user->isBranchAdmin()) {
                $hasAnyLeads = true;
            } else {
                $hasAnyLeads =
                    (int) ($user->lead_balance ?? 0) > 0 ||
                    \App\Models\LeadAccess::where('officer_id', $user->id)->exists();
            }
        @endphp

        @unless ($hasAnyLeads)
            <div class="alert alert-info">
                You don't have any purchased leads. <a href="{{ route('branch-admin.packages.gallery') }}"
                    class="alert-link">Purchase a package</a> to view applicant contact details.
            </div>
        @endunless

        <!-- Filter Section -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('branch-admin.applications.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under
                                Review</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="loan_id" class="form-label">Loan Name:</label>
                        <select name="loan_id" id="loan_id" class="form-select">
                            <option value="">Any Loan</option>
                            @foreach ($loans as $loan)
                                <option value="{{ $loan->id }}" {{ request('loan_id') == $loan->id ? 'selected' : '' }}>
                                    {{ $loan->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="category_id" class="form-label">Loan Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Any Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="access" class="form-label">Access</label>
                        <select name="access" id="access" class="form-select">
                            <option value="">Any</option>
                            <option value="unlocked" {{ request('access') == 'unlocked' ? 'selected' : '' }}>Unlocked
                            </option>
                            <option value="locked" {{ request('access') == 'locked' ? 'selected' : '' }}>Locked</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('branch-admin.applications.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if ($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Applicant Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Loan Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                    <tr>
                                        <td><strong>#{{ $application->id }}</strong></td>
                                        <td>{{ $application->full_name }}</td>
                                        <td>{{ $application->email }}</td>
                                        <td>{{ $application->phone }}</td>
                                        <td>{{ $application->loan->name ?? 'N/A' }}</td>
                                        <td><strong>৳{{ number_format($application->loan_amount, 2) }}</strong></td>
                                        <td>
                                            @if ($application->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($application->status == 'under_review')
                                                <span class="badge bg-info">Under Review</span>
                                            @elseif($application->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($application->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->format('d M, Y') }}</td>
                                        <td>
                                            @php
                                                $canView = false;
                                                if ($user->isSuperAdmin() || $user->isBankAdmin()) {
                                                    $canView = true;
                                                } else {
                                                    // direct view only if previously unlocked for this officer
                                                    $canView = \App\Models\LeadAccess::where('officer_id', $user->id)
                                                        ->where('application_id', $application->id)
                                                        ->exists();
                                                }
                                            @endphp

                                            @if ($canView)
                                                <a href="{{ route('branch-admin.applications.show', $application) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                            @else
                                                @if ((int) ($user->lead_balance ?? 0) > 0)
                                                    <form
                                                        action="{{ route('branch-admin.applications.unlock', $application) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-unlock me-1"></i>Unlock to View (1)
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('branch-admin.packages.gallery') }}"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        title="Purchase leads to view">
                                                        <i class="bi bi-cart me-1"></i>Buy Leads
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $applications->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">No loan applications found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
