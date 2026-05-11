@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <a href="{{ route('branch-admin.new-applications.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to New Loan Requests
            </a>
        </div>

        <div class="row g-4">
            @php
                $user = auth()->user();
            @endphp

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="bi bi-file-earmark-plus me-2"></i>Request #{{ $newApplication->id }}</h4>
                            @if ($newApplication->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($newApplication->status === 'review')
                                <span class="badge bg-info">Review</span>
                            @elseif ($newApplication->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($newApplication->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Requested Date</small>
                                <strong>{{ $newApplication->created_at->format('d M, Y h:i A') }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Last Updated</small>
                                <strong>{{ $newApplication->updated_at->format('d M, Y h:i A') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($hasAccess)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Customer Name</small>
                                    <strong>{{ optional($newApplication->customer)->name ?? 'Guest' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Email</small>
                                    <strong>{{ optional($newApplication->customer)->email ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Service Category</small>
                                    <strong class="text-capitalize">{{ str_replace('_', ' ', $newApplication->service_category) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Service Type</small>
                                    <strong class="text-capitalize">{{ str_replace('_', ' ', $newApplication->service_type) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Expected Amount</small>
                                    <strong>৳{{ number_format($newApplication->expected_amount, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Tenure</small>
                                    <strong>{{ $newApplication->tenure_months }} Months</strong>
                                </div>
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Selected Banks</small>
                                    @php
                                        $bankNames = collect($newApplication->bank_ids)->filter()->map(function ($bankId) use ($banks) {
                                            return optional($banks->firstWhere('id', $bankId))->name;
                                        })->filter()->join(', ');
                                    @endphp
                                    <p class="mb-0">{{ $bankNames ?: 'N/A' }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Additional Notes</small>
                                    <p class="mb-0">{{ $newApplication->additional_notes ?: 'No additional notes provided.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-lock-fill display-4 text-muted"></i>
                            <h5 class="mt-3">This request is locked</h5>
                            <p class="text-muted mb-4">Unlock this request with 1 lead to view full applicant and request details.</p>
                            @if ((int) ($user->lead_balance ?? 0) > 0)
                                <form action="{{ route('branch-admin.new-applications.unlock', $newApplication) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Unlock to View (1)</button>
                                </form>
                            @else
                                <a href="{{ route('branch-admin.packages.gallery') }}" class="btn btn-secondary">
                                    Purchase Lead Package
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                @if ($hasAccess)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-gear-fill me-2"></i>Manage Request</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('branch-admin.new-applications.updateStatus', $newApplication) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="pending" {{ $newApplication->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="review" {{ $newApplication->status === 'review' ? 'selected' : '' }}>Review</option>
                                        <option value="approved" {{ $newApplication->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $newApplication->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Update Status</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-unlock me-2"></i>Unlock Request</h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted mb-4">Unlock this request with 1 lead to access full request details.</p>
                            @if ((int) ($user->lead_balance ?? 0) > 0)
                                <form action="{{ route('branch-admin.new-applications.unlock', $newApplication) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Unlock to View (1)</button>
                                </form>
                            @else
                                <a href="{{ route('branch-admin.packages.gallery') }}" class="btn btn-secondary w-100">
                                    Purchase Lead Package
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
