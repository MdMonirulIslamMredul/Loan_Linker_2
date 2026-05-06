@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ auth()->user()->role === 'super_admin' ? route('super-admin.applications.index') : route('branch-admin.applications.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Applications
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Application Details -->
        <div class="col-lg-8">
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-file-text me-2"></i>Application #{{ $application->id }}
                        </h4>
                        @if($application->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($application->status == 'under_review')
                            <span class="badge bg-info">Under Review</span>
                        @elseif($application->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($application->status == 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Applied Date</small>
                            <strong>{{ $application->created_at->format('d M, Y h:i A') }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Last Updated</small>
                            <strong>{{ $application->updated_at->format('d M, Y h:i A') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Full Name</small>
                            <strong>{{ $application->full_name }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $application->email }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Phone</small>
                            <strong>{{ $application->phone }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">NID Number</small>
                            <strong>{{ $application->nid_number }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Date of Birth</small>
                            <strong>{{ \Carbon\Carbon::parse($application->date_of_birth)->format('d M, Y') }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Gender</small>
                            <strong class="text-capitalize">{{ $application->gender }}</strong>
                        </div>
                        <div class="col-12 mb-3">
                            <small class="text-muted d-block">Present Address</small>
                            <p class="mb-0">{{ $application->present_address }}</p>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Permanent Address</small>
                            <p class="mb-0">{{ $application->permanent_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-briefcase me-2"></i>Employment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Occupation</small>
                            <strong>{{ $application->occupation }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Monthly Income</small>
                            <strong>৳{{ number_format($application->monthly_income, 2) }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Employment Type</small>
                            <strong class="text-capitalize">{{ str_replace('-', ' ', $application->employment_type) }}</strong>
                        </div>
                        @if($application->company_name)
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Company/Organization</small>
                            <strong>{{ $application->company_name }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Loan Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Loan Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Requested Amount</small>
                            <h4 class="text-success mb-0">৳{{ number_format($application->loan_amount, 2) }}</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Tenure</small>
                            <h4 class="text-info mb-0">{{ $application->tenure_months }} Months</h4>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Purpose of Loan</small>
                            <p class="mb-0">{{ $application->loan_purpose }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            @if($application->documents && count($application->documents) > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-arrow-up me-2"></i>Uploaded Documents</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($application->documents as $index => $document)
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-file-earmark-text fs-2 text-primary"></i>
                                                <p class="mb-0 small mt-2">Document {{ $index + 1 }}</p>
                                            </div>
                                            <a href="{{ asset('storage/' . $document) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download me-1"></i>View/Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Admin Notes -->
            @if($application->admin_notes)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-chat-left-text me-2"></i>Admin Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $application->admin_notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Loan Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Loan Information</h5>
                </div>
                <div class="card-body">
                    @if($application->loan->branch->bank->bank_logo)
                    <div class="text-center mb-3">
                        <img src="{{ asset($application->loan->branch->bank->bank_logo) }}"
                             alt="{{ $application->loan->branch->bank->bank_name }}"
                             class="img-fluid"
                             style="max-height: 60px;">
                    </div>
                    @endif

                    <h6 class="fw-bold mb-1">{{ $application->loan->loan_name }}</h6>
                    <p class="text-muted small mb-3">{{ $application->loan->branch->bank->bank_name }}</p>

                    <div class="mb-2">
                        <small class="text-muted">Branch</small>
                        <p class="mb-0"><strong>{{ $application->loan->branch->branch_name }}</strong></p>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Interest Rate</small>
                        <p class="mb-0"><strong>{{ $application->loan->interest_rate }}% per annum</strong></p>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ auth()->user()->role === 'super_admin' ? route('super-admin.applications.updateStatus', $application) : route('branch-admin.applications.updateStatus', $application) }}"
                          method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="under_review" {{ $application->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes"
                                      class="form-control @error('admin_notes') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Add notes about this application...">{{ $application->admin_notes }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
