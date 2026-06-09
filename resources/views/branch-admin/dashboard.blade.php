@extends('layouts.branch-admin')

@section('title', 'Bank Officer Dashboard')
@section('dashboard-title', 'Bank Officer Dashboard')

@section('content')
    

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            @php
                $user = auth()->user();
                $leadBalance = $user->lead_balance ?? 0;
            @endphp


 @if(auth()->user()->is_access)
            <div class="row g-2">
                <div class="col-md-3">
                    <a href="{{ route('branch-admin.packages.history') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 rounded-4 hover-lift">
                            <div class="card-body text-center p-2">
                                <div class="mb-2">
                                    <span class="badge bg-primary rounded-pill py-1 px-2 shadow-sm">
                                        <i class="bi bi-wallet2 fs-6"></i>
                                    </span>
                                </div>
                                <div class="text-uppercase text-muted small mb-1">Lead Balance</div>
                                <div class="fs-4 fw-bold">{{ number_format($leadBalance) }}</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('branch-admin.new-applications.unlocked') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 rounded-4 bg-success bg-opacity-10 hover-lift">
                            <div class="card-body text-center p-2">
                                <div class="mb-2">
                                    <span class="badge bg-success rounded-pill py-1 px-2 shadow-sm">
                                        <i class="bi bi-unlock-fill fs-6"></i>
                                    </span>
                                </div>
                                <div class="text-uppercase text-success small mb-1">Available</div>
                                <div class="fs-4 fw-bold text-success">{{ $unlockedCount ?? 0 }}</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('branch-admin.new-applications.locked') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 rounded-4 bg-warning bg-opacity-10 hover-lift">
                            <div class="card-body text-center p-2">
                                <div class="mb-2">
                                    <span class="badge bg-warning rounded-pill py-1 px-2 shadow-sm text-dark">
                                        <i class="bi bi-lock-fill fs-6"></i>
                                    </span>
                                </div>
                                <div class="text-uppercase text-warning small mb-1">New (Locked)</div>
                                <div class="fs-4 fw-bold text-warning">{{ $lockedCount ?? 0 }}</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('branch-admin.new-applications.index') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 rounded-4 bg-info bg-opacity-10 hover-lift">
                            <div class="card-body text-center p-2">
                                <div class="mb-2">
                                    <span class="badge bg-info rounded-pill py-1 px-2 shadow-sm">
                                        <i class="bi bi-file-earmark-text fs-6"></i>
                                    </span>
                                </div>
                                <div class="text-uppercase text-info small mb-1">New Loan Requests (last 7 days)</div>
                                <div class="fs-4 fw-bold text-info">{{ $newRequestsCount }}</div>
                                <div class="small mt-1 text-muted">View new customer requests</div>
                            </div>
                        </div>
                    </a>
                </div>
        
            </div>
        </div>
    </div>

   
       

        <!-- Loan Applications Section -->
        <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Recent Loan Applications (last 7 days)</h4>
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
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Amount</th>
                                <th>Tenure</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>District</th>
                                {{-- <th>Status</th> --}}
                                <th>Requested</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newApplications as $application)
                                @php
                                    $canView = false;
                                    if ($user->isSuperAdmin() || $user->isBankAdmin()) {
                                        $canView = true;
                                    } else {
                                        $canView = \App\Models\LeadAccess::where('officer_id', $user->id)
                                            ->where('newloan_id', $application->id)
                                            ->exists();
                                    }
                                @endphp
                                <tr>
                                    <td><strong>#{{ $application->id }}</strong></td>
                                    <td>{{ optional($application->customer)->name ?? 'Guest' }}</td>
                                    <td>{{ $canView ? (optional($application->customer)->email ?? 'N/A') : 'Locked' }}</td>
                                    <td><strong>৳{{ number_format($application->expected_amount, 2) }}</strong></td>
                                    <td>{{ $application->tenure_months }} months</td>
                                    <td class="text-capitalize">{{ optional($application->serviceCategory)->name ?? 'N/A' }}</td>
                                    <td class="text-capitalize">{{ optional($application->serviceType)->name ?? 'N/A' }}</td>
                                    {{-- <td>
                                        @if ($application->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($application->status === 'review')
                                            <span class="badge bg-info">Review</span>
                                        @elseif($application->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($application->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($application->status ?? 'Unknown') }}</span>
                                        @endif
                                    </td> --}}
                                    <td class="text-capitalize">{{ optional($application->customer->contactDistrict)->name ?? 'N/A' }}</td>
                                    <td>{{ $application->created_at->format('d M, Y') }}</td>
                                    <td>
                                        @if ($canView)
                                            <a href="{{ route('branch-admin.new-applications.show', $application) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                        @else
                                            @if ((int) ($user->lead_balance ?? 0) > 0)
                                                <form action="{{ route('branch-admin.new-applications.unlock', $application) }}" method="POST" class="d-inline unlock-form">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-outline-primary unlock-confirm-btn">
                                                        <i class="bi bi-unlock me-1"></i>Unlock to View (1)
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('branch-admin.packages.gallery') }}" class="btn btn-sm btn-outline-secondary" title="Purchase leads to view">
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

                @if ($newApplications->hasPages())
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-center">
                            {{ $newApplications->links('pagination::bootstrap-5') }}
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

    <div class="modal fade" id="unlockConfirmModal" tabindex="-1" aria-labelledby="unlockConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unlockConfirmModalLabel">Confirm Unlock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to unlock this application?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="unlockConfirmYes">Yes</button>
                </div>
            </div>
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let activeUnlockForm = null;
                const unlockModalElement = document.getElementById('unlockConfirmModal');
                const unlockButtons = document.querySelectorAll('.unlock-confirm-btn');
                const confirmYesButton = document.getElementById('unlockConfirmYes');
                let unlockModal = null;

                if (typeof bootstrap !== 'undefined' && unlockModalElement) {
                    unlockModal = new bootstrap.Modal(unlockModalElement);
                }

                unlockButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        activeUnlockForm = this.closest('form.unlock-form');
                        if (unlockModal) {
                            unlockModal.show();
                        } else if (activeUnlockForm) {
                            activeUnlockForm.submit();
                        }
                    });
                });

                if (confirmYesButton) {
                    confirmYesButton.addEventListener('click', function () {
                        if (activeUnlockForm) {
                            activeUnlockForm.submit();
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
