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
                                        @if ($customerAverageRating >= $i)
                                            <i class="bi bi-star-fill"></i>
                                        @elseif ($customerAverageRating > $i - 1)
                                            <i class="bi bi-star-half"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
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
                                @if($customer->contact_address || $customer->contactDivision || $customer->contactDistrict || $customer->contactUpazila || $customer->contactThana)
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Contact Address</small>
                                        <p class="mb-0">
                                            @if($customer->contactDivision?->name)
                                                <strong>{{ $customer->contactDivision->name }}</strong>
                                            @endif
                                            @if($customer->contactDivision?->name && $customer->contactDistrict?->name)
                                                , 
                                            @endif
                                            @if($customer->contactDistrict?->name)
                                                <strong>{{ $customer->contactDistrict->name }}</strong>
                                                ,
                                            @endif
                                            @if($customer->contactDistrict?->name && $customer->contactUpazila?->name)
                                                , 
                                            @endif
                                            @if($customer->contactUpazila?->name)
                                                <strong>{{ $customer->contactUpazila->name }}</strong>
                                            @endif
                                            @if($customer->contactUpazila?->name && $customer->contactThana?->name)
                                                , 
                                            @endif
                                            @if($customer->contactThana?->name)
                                                <strong>{{ $customer->contactThana->name }}</strong>
                                            @endif
                                            @if($customer->contact_address && ($customer->contactDivision?->name || $customer->contactDistrict?->name || $customer->contactUpazila?->name || $customer->contactThana?->name))
                                                , {{ $customer->contact_address }}
                                            @elseif($customer->contact_address)
                                                {{ $customer->contact_address }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
                                @if($customer->permanent_address || $customer->permanentDivision || $customer->permanentDistrict || $customer->permanentUpazila || $customer->permanentThana)
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Permanent Address</small>
                                        <p class="mb-0">
                                            @if($customer->permanentDivision?->name)
                                                <strong>{{ $customer->permanentDivision->name }}</strong>
                                            @endif
                                            @if($customer->permanentDivision?->name && $customer->permanentDistrict?->name)
                                                , 
                                            @endif
                                            @if($customer->permanentDistrict?->name)
                                                <strong>{{ $customer->permanentDistrict->name }}</strong>
                                                ,
                                            @endif
                                            @if($customer->permanentDistrict?->name && $customer->permanentUpazila?->name)
                                                , 
                                            @endif
                                            @if($customer->permanentUpazila?->name)
                                                <strong>{{ $customer->permanentUpazila->name }}</strong>
                                            @endif
                                            @if($customer->permanentUpazila?->name && $customer->permanentThana?->name)
                                                , 
                                            @endif
                                            @if($customer->permanentThana?->name)
                                                <strong>{{ $customer->permanentThana->name }}</strong>
                                            @endif
                                            @if($customer->permanent_address && ($customer->permanentDivision?->name || $customer->permanentDistrict?->name || $customer->permanentUpazila?->name || $customer->permanentThana?->name))
                                                , {{ $customer->permanent_address }}
                                            @elseif($customer->permanent_address)
                                                {{ $customer->permanent_address }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
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
                                        <small class="text-muted d-block">Salary Bank</small>
                                        <strong>{{ optional($customerFin)->bank ? optional($customerFin->bank)->name : 'N/A' }}</strong>
                                    </div>  
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Salary by Hand</small>
                                    <strong>৳{{ number_format(optional($customerFin)->salary_by_hand ?? 0, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Monthly Bank Transaction</small>
                                    <strong>৳{{ number_format(optional($customerFin)->monthly_bank_transaction ?? 0, 2) }}</strong>
                                </div>
                                
                                @if (! optional($customerFin)->has_loan)
                                    <div class="col-12 mb-3">
                                        <p class="text-muted mb-0">The user has no past loan history.</p>
                                    </div>
                                @endif

                                @if(optional($customerFin)->has_loan && optional($customerFin)->loans && optional($customerFin)->loans->isNotEmpty())
                                    <div class="col-12 mb-3">
                                        <hr />
                                        <h6 class="mb-3">Loan Details</h6>
                                        @foreach(optional($customerFin)->loans as $loan)
                                            <div class="card mb-3">
                                                <div class="card-body p-3">
                                                    <div class="row g-2">
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Loan Bank</small>
                                                            <strong>{{ optional($loan->bank)->name ?? 'N/A' }}</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Loan Category</small>
                                                            <strong>{{ optional($loan->serviceCategory)->name ?? 'N/A' }}</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Loan Type</small>
                                                            <strong>{{ optional($loan->serviceType)->name ?? 'N/A' }}</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Loan Amount</small>
                                                            <strong>৳{{ number_format($loan->loan_amount ?? 0, 2) }}</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Tenure Months</small>
                                                            <strong>{{ $loan->tenure_months !== null ? $loan->tenure_months : 'N/A' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
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
                        $ratingFormOpen = ! $existingRating || old('information_accuracy') !== null || old('behavior') !== null || old('response_time') !== null || old('credit_score') !== null || old('comment') !== null || $errors->has('information_accuracy') || $errors->has('behavior') || $errors->has('response_time') || $errors->has('credit_score') || $errors->has('comment');
                    @endphp
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-star-fill me-2"></i>Customer Rating</h5>
                        </div>
                        <div class="card-body">
                            @if ($existingRating)
                                <div class="p-3 bg-light rounded-3 border mb-3">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-semibold text-secondary">Overall Rating:</span>
                                            <span class="text-warning fs-5 d-inline-flex gap-1">
                                                @php $r = $existingRating->rating; @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($r >= $i)
                                                        <i class="bi bi-star-fill"></i>
                                                    @elseif ($r > $i - 1)
                                                        <i class="bi bi-star-half"></i>
                                                    @else
                                                        <i class="bi bi-star text-muted opacity-25"></i>
                                                    @endif
                                                @endfor
                                            </span>
                                            <span class="fw-bold text-dark fs-6">{{ number_format($existingRating->rating, 1) }} / 5</span>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" id="toggle-rating-edit">
                                            <i class="bi bi-pencil me-1"></i>Edit Rating
                                        </button>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6 col-md-3">
                                            <div class="p-2 bg-white rounded border h-100">
                                                <div class="text-secondary small mb-1">Info Accuracy</div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="fw-bold text-dark">{{ $existingRating->information_accuracy ?? '-' }}/5</span>
                                                    <span class="text-warning small">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="bi {{ $i <= $existingRating->information_accuracy ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="p-2 bg-white rounded border h-100">
                                                <div class="text-secondary small mb-1">Behavior</div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="fw-bold text-dark">{{ $existingRating->behavior ?? '-' }}/5</span>
                                                    <span class="text-warning small">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="bi {{ $i <= $existingRating->behavior ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="p-2 bg-white rounded border h-100">
                                                <div class="text-secondary small mb-1">Response Time</div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="fw-bold text-dark">{{ $existingRating->response_time ?? '-' }}/5</span>
                                                    <span class="text-warning small">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="bi {{ $i <= $existingRating->response_time ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="p-2 bg-white rounded border h-100">
                                                <div class="text-secondary small mb-1">Credit Score</div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="fw-bold text-dark">{{ $existingRating->credit_score ?? '-' }}/5</span>
                                                    <span class="text-warning small">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="bi {{ $i <= $existingRating->credit_score ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($existingRating->comment)
                                        <div class="p-2 bg-white rounded border">
                                            <span class="fw-semibold text-secondary small me-1">Comment:</span>
                                            <span class="text-dark">{{ $existingRating->comment }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div id="rating-edit-form" class="{{ $ratingFormOpen ? '' : 'd-none' }} mt-3">
                                <form method="POST" action="{{ route('branch-admin.new-applications.customer-rating.store', $newApplication) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="information_accuracy" class="form-label">Information Accuracy</label>
                                            <select name="information_accuracy" id="information_accuracy" class="form-select @error('information_accuracy') is-invalid @enderror" required>
                                                <option value="">Select rating</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('information_accuracy', optional($existingRating)->information_accuracy) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('information_accuracy')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="behavior" class="form-label">Behavior</label>
                                            <select name="behavior" id="behavior" class="form-select @error('behavior') is-invalid @enderror" required>
                                                <option value="">Select rating</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('behavior', optional($existingRating)->behavior) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('behavior')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="response_time" class="form-label">Response Time</label>
                                            <select name="response_time" id="response_time" class="form-select @error('response_time') is-invalid @enderror" required>
                                                <option value="">Select rating</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('response_time', optional($existingRating)->response_time) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('response_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="credit_score" class="form-label">Credit Score</label>
                                            <select name="credit_score" id="credit_score" class="form-select @error('credit_score') is-invalid @enderror" required>
                                                <option value="">Select rating</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('credit_score', optional($existingRating)->credit_score) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('credit_score')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                            var ratingField = document.getElementById('information_accuracy');
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
