@extends('layouts.branch-admin')

@section('title', 'Branch Admin Dashboard')
@section('dashboard-title', 'Branch Admin Dashboard')

@section('content')
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-gradient text-white"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                    <i class="bi bi-shop fs-4"></i>
                </div>
                <h4 class="mb-0 fw-bold">Branch Information</h4>
            </div>
        </div>
        <div class="card-body p-4">
            @if ($branch)
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small fw-semibold">Branch Name:</p>
                        <h6 class="mb-0">{{ $branch->name }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small fw-semibold">Branch Code:</p>
                        <h6 class="mb-0"><span class="badge bg-secondary">{{ $branch->code }}</span></h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small fw-semibold">Bank:</p>
                        <h6 class="mb-0">{{ $bank->name }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small fw-semibold">Location:</p>
                        <h6 class="mb-0"><i class="bi bi-geo-alt me-1 text-primary"></i>{{ $branch->city ?? 'N/A' }},
                            {{ $branch->state ?? 'N/A' }}</h6>
                    </div>
                    @if ($branch->phone)
                        <div class="col-md-6">
                            <p class="text-muted mb-1 small fw-semibold">Phone:</p>
                            <h6 class="mb-0"><i class="bi bi-telephone me-1 text-success"></i>{{ $branch->phone }}</h6>
                        </div>
                    @endif
                    @if ($branch->email)
                        <div class="col-md-6">
                            <p class="text-muted mb-1 small fw-semibold">Email:</p>
                            <h6 class="mb-0"><i class="bi bi-envelope me-1 text-info"></i>{{ $branch->email }}</h6>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No branch information available.</p>
                </div>
            @endif
        </div>
    </div>


    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            @php
                $user = auth()->user();
                $leadBalance = $user->lead_balance ?? 0;
                $branchId = $user->branch_id;
                $userId = $user->id;

                $appIds = \App\Models\LoanApplication::whereHas('loan', function ($q) use ($branchId, $userId) {
                    $q->where('branch_id', $branchId)->where('branch_admin_id', $userId);
                })
                    ->pluck('id')
                    ->toArray();

                $totalApplications = count($appIds);
                $unlockedCount = 0;
                if (!empty($appIds)) {
                    $unlockedCount = \App\Models\LeadAccess::where('officer_id', $userId)
                        ->whereIn('application_id', $appIds)
                        ->count();
                }
                $lockedCount = max(0, $totalApplications - $unlockedCount);
            @endphp

            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card h-100 bg-white border-0">
                        <div class="card-body text-center p-3">
                            <div class="text-muted small">Lead Balance</div>
                            <div class="fw-bold fs-5">{{ number_format($leadBalance) }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('branch-admin.applications.index', ['access' => 'unlocked']) }}"
                        class="text-decoration-none">
                        <div class="card h-100 bg-light border-0">
                            <div class="card-body text-center p-3">
                                <div class="text-muted small">Available (Unlocked)</div>
                                <div class="fw-bold fs-5 text-success">{{ $unlockedCount }}</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('branch-admin.applications.index', ['access' => 'locked']) }}"
                        class="text-decoration-none">
                        <div class="card h-100 bg-light border-0">
                            <div class="card-body text-center p-3">
                                <div class="text-muted small">New (Locked)</div>
                                <div class="fw-bold fs-5 text-warning">{{ $lockedCount }}</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('branch-admin.applications.index') }}" class="text-decoration-none">
                        <div class="card h-100 bg-white border-0">
                            <div class="card-body text-center p-3">
                                <div class="text-muted small">Total Applications</div>
                                <div class="fw-bold fs-5">{{ $totalApplications }}</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h4>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('branch-admin.loans.index') }}" class="text-decoration-none d-block">
                        <div class="card bg-primary text-white h-100 hover-lift">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-list-ul fs-1 mb-2"></i>
                                <h5 class="fw-bold mb-0">Manage Loans</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('branch-admin.loans.create') }}" class="text-decoration-none d-block">
                        <div class="card bg-success text-white h-100 hover-lift">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-plus-circle fs-1 mb-2"></i>
                                <h5 class="fw-bold mb-0">Add New Loan</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('branch-admin.applications.index') }}" class="text-decoration-none d-block">
                        <div class="card bg-info text-white h-100 hover-lift">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-file-text fs-1 mb-2"></i>
                                <h5 class="fw-bold mb-0">Loan Applications</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Loan Applications Section -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Recent Loan Applications</h4>
                <a href="{{ route('branch-admin.applications.index') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($applications->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No loan applications yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Applicant</th>
                                <th>Loan</th>
                                <th>Amount</th>
                                <th>Tenure</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td class="fw-semibold">#{{ $application->id }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $application->full_name }}</div>
                                        <small class="text-muted">{{ $application->email }}</small>
                                    </td>
                                    <td>{{ $application->loan->name ?? 'N/A' }}</td>
                                    <td class="fw-semibold text-success">৳{{ number_format($application->loan_amount) }}
                                    </td>
                                    <td>{{ $application->tenure_months }} months</td>
                                    <td>
                                        @if ($application->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($application->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($application->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span
                                                class="badge bg-secondary">{{ ucfirst($application->status ?? 'Unknown') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </td>
                                    {{-- <td>
                                        <a href="{{ route('branch-admin.applications.show', $application) }}"
                                            class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($applications->hasPages())
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-center">
                            {{ $applications->links() }}
                        </div>
                    </div>
                @endif
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
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
            }
        </style>
    @endpush
@endsection
