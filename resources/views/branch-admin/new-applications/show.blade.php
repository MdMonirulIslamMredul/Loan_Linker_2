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
                            @php
                                $displayStatus = optional($officerAccess)->application_status ?? $newApplication->status;
                            @endphp
                            @if ($displayStatus === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($displayStatus === 'review')
                                <span class="badge bg-info">Review</span>
                            @elseif ($displayStatus === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($displayStatus === 'rejected')
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
                    @php
                        $customer = $newApplication->customer;
                        $customerDocs = optional($customer)->customerDocument;
                        $customerFin = optional($customer)->customerFinancial;
                        $existingRating = $newApplication->customerRatings->firstWhere('branch_admin_id', $user->id);
                    @endphp

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Loan Request Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Service Category</small>
                                    <strong>{{ optional($newApplication->serviceCategory)->name ?? str_replace('_', ' ', $newApplication->service_category) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Service Type</small>
                                    <strong>{{ optional($newApplication->serviceType)->name ?? str_replace('_', ' ', $newApplication->service_type) }}</strong>
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

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Customer Information</h5>
                            @if ($customerRatingCount)
                                <div class="mt-2 text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $customerAverageStars ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                    <small class="text-muted ms-2">{{ number_format($customerAverageRating, 1) }} average from {{ $customerRatingCount }} rating{{ $customerRatingCount > 1 ? 's' : '' }}</small>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('branch-admin.new-applications.customer-ratings', $newApplication) }}" class="btn btn-outline-secondary btn-sm">View all ratings</a>
                                </div>
                            @else
                                <small class="text-muted d-block mt-2">No customer rating available yet.</small>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Customer Name</small>
                                    <strong>{{ optional($customer)->name ?? 'Guest' }}</strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Email</small>
                                    <strong>{{ optional($customer)->email ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Phone</small>
                                    <strong>{{ optional($customer)->phone ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">NID Number</small>
                                    <strong>{{ optional($customer)->nid_number ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <strong>{{ optional($customer->dob)->format('d M, Y') ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Contact Address</small>
                                    <p class="mb-0">{{ optional($customer->contactDivision)->name ?? '' }}{{ optional($customer->contactDistrict)->name ? ' - ' . $customer->contactDistrict->name : '' }}{{ $customer->contact_address ? ' - ' . $customer->contact_address : '' }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Permanent Address</small>
                                    <p class="mb-0">{{ optional($customer->permanentDivision)->name ?? '' }}{{ optional($customer->permanentDistrict)->name ? ' - ' . $customer->permanentDistrict->name : '' }}{{ $customer->permanent_address ? ' - ' . $customer->permanent_address : '' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Education</small>
                                    <strong>{{ optional($customer)->education ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Profession</small>
                                    <strong>{{ optional($customer)->profession ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Organization</small>
                                    <strong>{{ optional($customer)->organization_name ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Designation</small>
                                    <strong>{{ optional($customer)->designation ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Joining</small>
                                    <strong>{{ optional($customer->date_of_joining)->format('d M, Y') ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Working Experience</small>
                                    <strong>{{ optional($customer)->total_working_experience ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-credit-card-2-front-fill me-2"></i>Financial Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Salary by Bank</small>
                                    <strong>৳{{ number_format(optional($customerFin)->salary_by_bank ?? 0, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Salary by Hand</small>
                                    <strong>৳{{ number_format(optional($customerFin)->salary_by_hand ?? 0, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Monthly Bank Transaction</small>
                                    <strong>৳{{ number_format(optional($customerFin)->monthly_bank_transaction ?? 0, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Existing Loans / Credit Cards</small>
                                    <strong>{{ optional($customerFin)->existing_loans_credit_cards ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-file-earmark-text-fill me-2"></i>Customer Documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach (['picture' => 'Picture', 'nid' => 'NID', 'office_id' => 'Office ID', 'visiting_card' => 'Visiting Card', 'pay_slip' => 'Pay Slip', 'bank_statements' => 'Bank Statements', 'trade_license' => 'Trade License', 'lend_document' => 'Lend Document', 'other_document' => 'Other Document'] as $field => $label)
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted d-block">{{ $label }}</small>
                                        @if ($customerDocs && $customerDocs->{$field})
                                            <a href="{{ asset('storage/' . $customerDocs->{$field}) }}" target="_blank" class="text-decoration-none">View File</a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @php
                        $ratingFormOpen = ! $existingRating || old('rating') !== null || old('comment') !== null || $errors->has('rating') || $errors->has('comment');
                    @endphp
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-star-fill me-2"></i>Customer Rating</h5>
                        </div>
                        <div class="card-body">
                            @if ($existingRating)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <strong>Your rating:</strong>
                                        <span class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $existingRating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </span>
                                    </div>
                                    @if ($existingRating->comment)
                                        <p class="mb-3"><strong>Comment:</strong> {{ $existingRating->comment }}</p>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="toggle-rating-edit">Edit Rating</button>
                            @endif

                            <div id="rating-edit-form" class="{{ $ratingFormOpen ? '' : 'd-none' }} mt-3">
                                <form method="POST" action="{{ route('branch-admin.new-applications.customer-rating.store', $newApplication) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating</label>
                                        <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                            <option value="">Select rating</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ old('rating', optional($existingRating)->rating) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('rating')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea name="comment" id="comment" rows="3" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', optional($existingRating)->comment) }}</textarea>
                                        @error('comment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Rating</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if ($existingRating)
                        @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var toggleButton = document.getElementById('toggle-rating-edit');
                                    var ratingForm = document.getElementById('rating-edit-form');

                                    if (!toggleButton || !ratingForm) {
                                        return;
                                    }

                                    toggleButton.addEventListener('click', function () {
                                        ratingForm.classList.toggle('d-none');
                                        if (!ratingForm.classList.contains('d-none')) {
                                            var ratingField = document.getElementById('rating');
                                            if (ratingField) {
                                                ratingField.focus();
                                            }
                                        }
                                    });
                                });
                            </script>
                        @endpush
                    @endif
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

                                        <option value="pending" {{ old('status', optional($officerAccess)->application_status ?? $newApplication->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="review" {{ old('status', optional($officerAccess)->application_status ?? $newApplication->status) === 'review' ? 'selected' : '' }}>Reviewing</option>
                                        <option value="approved" {{ old('status', optional($officerAccess)->application_status ?? $newApplication->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', optional($officerAccess)->application_status ?? $newApplication->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
