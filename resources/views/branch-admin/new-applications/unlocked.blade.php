@extends('layouts.branch-admin')

@section('title', 'Unlocked New Loan Requests')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="bi bi-unlock me-2"></i>Unlocked New Loan Requests</h2>
                <p class="text-muted">Review the new loan requests you have unlocked.</p>
            </div>
        </div>

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('branch-admin.new-applications.unlocked') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="review" {{ request('status') == 'review' ? 'selected' : '' }}>Review</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="service_type" class="form-label">Loan Type</label>
                        <select name="service_type" id="service_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="visa_credit_card" {{ request('service_type') == 'visa_credit_card' ? 'selected' : '' }}>Visa Credit Card</option>
                            <option value="personal_loan" {{ request('service_type') == 'personal_loan' ? 'selected' : '' }}>Personal Loan</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('branch-admin.new-applications.unlocked') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if ($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                    <th>Tenure</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Banks</th>
                                    <th>Status</th>
                                    <th>Requested</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                    <tr>
                                        <td><strong>#{{ $application->id }}</strong></td>
                                        <td>{{ optional($application->customer)->name ?? 'Guest' }}</td>
                                        <td>{{ optional($application->customer)->email ?? 'N/A' }}</td>
                                        <td><strong>৳{{ number_format($application->expected_amount, 2) }}</strong></td>
                                        <td>{{ $application->tenure_months }} mo</td>
                                        <td class="text-capitalize">{{ optional($application->serviceCategory)->name ?? 'N/A' }}</td>
                                        <td class="text-capitalize">{{ optional($application->serviceType)->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $bankNames = collect($application->bank_ids)->filter()->map(function ($bankId) use ($banks) {
                                                    return optional($banks->firstWhere('id', $bankId))->name;
                                                })->filter()->join(', ');
                                            @endphp
                                            {{ $bankNames ?: 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($application->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($application->status === 'review')
                                                <span class="badge bg-info">Review</span>
                                            @elseif ($application->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif ($application->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('branch-admin.new-applications.show', $application) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        {{ $applications->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">No unlocked new loan requests found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
