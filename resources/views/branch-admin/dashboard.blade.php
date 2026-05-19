@extends('layouts.branch-admin')

@section('title', 'Branch Admin Dashboard')
@section('dashboard-title', 'Branch Admin Dashboard')

@section('content')
    

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
                $newRequestsCount = \App\Models\NewLoanApplication::count();
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

    @if(auth()->user()->is_access)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <a href="{{ route('branch-admin.new-applications.index') }}" class="text-decoration-none">
                    <div class="card h-100 bg-info text-white border-0">
                        <div class="card-body text-center p-3">
                            <div class="text-muted small">New Loan Requests</div>
                            <div class="fw-bold fs-5">{{ $newRequestsCount }}</div>
                            <div class="small mt-2 text-white-75">View and manage new customer requests</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

       

        <!-- Loan Applications Section -->
        <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Recent Loan Applications</h4>
                <a href="{{ route('branch-admin.new-applications.index') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($newApplications->isEmpty())
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
                            @foreach ($newApplications  as $application)
                                <tr>
                                    <td class="fw-semibold">#{{ $application->id }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ optional($application->customer)->name ?? 'Guest' }}</div>
                                       
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $application->service_category)) }} / {{ ucfirst(str_replace('_', ' ', $application->service_type)) }}</td>
                                    <td class="fw-semibold text-success">৳{{ number_format($application->expected_amount, 2) }}
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

                @if ($newApplications->hasPages())
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-center">
                            {{ $newApplications->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>



    
    @elseif(auth()->user()->is_access === null)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="alert alert-warning mb-0">
                    <h5 class="alert-heading">Approval Pending , Please update your profile with Bank Official Information and upload your genuine Officer Documents </h5>
                    <p>Your account is awaiting approval from the admin. Please wait while your access request is reviewed.</p>
                    <p class="mb-0">If you have already submitted your documents, no further action is required.</p>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="alert alert-danger mb-0">
                    <h5 class="alert-heading">Access Denied</h5>
                    <p>Your access request has been rejected.</p>
                    @if(auth()->user()->access_mes)
                        <p class="mb-0"><strong>Reason:</strong> {{ auth()->user()->access_mes }}</p>
                    @else
                        <p class="mb-0">No rejection note was provided. Contact admin for more details.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

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
