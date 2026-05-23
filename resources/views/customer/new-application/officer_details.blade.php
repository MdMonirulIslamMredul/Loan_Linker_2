@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">
                @if(isset($officer))
                    Officer Details: {{ $officer->name }}
                @else
                    Officer Details
                @endif
            </h4>

            <div class="mb-4">
                <h5>Request #{{ $newApplication->id }}</h5>
                <p><strong>Service Category:</strong> {{ ucfirst(str_replace('_', ' ', $newApplication->service_category)) }}</p>
                <p><strong>Service Type:</strong> {{ ucfirst(str_replace('_', ' ', $newApplication->service_type)) }}</p>
                <p><strong>Expected Amount:</strong> ৳{{ number_format($newApplication->expected_amount, 2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($newApplication->status) }}</p>
            </div>

            @foreach ($unlocks as $access)
                @php
                    $officer = $access->officer;
                    $official = optional($officer)->bankOfficial;
                    $docs = optional($officer)->officerDocument;
                    $existingOfficerRating = $newApplication->bankOfficerRatings->firstWhere('officer_id', $officer->id);
                    $officerStats = $officerRatingStats[$officer->id] ?? null;
                @endphp
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Officer: {{ $officer->name ?? 'Unknown Officer' }}</h5>
                            @if ($officerStats)
                                <small class="text-warning d-block mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $officerStats['stars'] ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                    <span class="text-white-50 ms-2">{{ number_format($officerStats['avg'], 1) }} average from {{ $officerStats['count'] }} rating{{ $officerStats['count'] > 1 ? 's' : '' }}</span>
                                </small>
                            @else
                                <small class="text-white-50 d-block mb-1">No rating available for this officer</small>
                            @endif
                            <a href="{{ route('customer.application.officer_ratings', ['newApplication' => $newApplication, 'officer' => $officer]) }}" class="btn btn-sm btn-outline-light">View all ratings for this officer</a>
                        </div>
                        <span class="badge bg-white text-primary">Unlocked: {{ $access->purchased_at ? $access->purchased_at->format('M d, Y') : $access->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Left Column: Personal & Professional -->
                            <div class="col-lg-8">
                                <!-- Professional Info (Bank Official) -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-bank me-2"></i>Official Information</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-2"><strong>Bank:</strong> {{ $official->bank_name ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Branch:</strong> {{ $official->branch_name ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Designation:</strong> {{ $official->designation ?? $officer->designation ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Department:</strong> {{ $official->department ?? 'N/A' }}</div>
                                        {{-- <div class="col-md-6 mb-2"><strong>Office ID:</strong> {{ $official->office_id_number ?? 'N/A' }}</div> --}}
                                        <div class="col-md-6 mb-2"><strong>Official Email:</strong> {{ $official->official_email ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Official Phone:</strong> {{ $official->official_mobile_number ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Working Area:</strong> {{ $official->working_area ?? 'N/A' }}</div>
                                        {{-- <div class="col-md-6 mb-2"><strong>Joining Date:</strong> {{ optional($official->date_of_joining)->format('M d, Y') ?? 'N/A' }}</div> --}}
                                    </div>
                                </div>

                                <!-- Personal Info (User) -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-person-vcard me-2"></i>Personal Information</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $officer->email ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Phone:</strong> {{ $officer->phone ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Profession:</strong> {{ $officer->profession ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Organization:</strong> {{ $officer->organization_name ?? 'N/A' }}</div>
                                        {{-- <div class="col-md-6 mb-2"><strong>NID Number:</strong> {{ $officer->nid_number ?? 'N/A' }}</div> --}}
                                        {{-- <div class="col-md-12 mb-2"><strong>Contact Address:</strong> {{ $officer->contact_address ?? 'N/A' }}</div> --}}
                                        {{-- <div class="col-md-12 mb-2"><strong>Permanent Address:</strong> {{ $officer->permanent_address ?? 'N/A' }}</div> --}}
                                    </div>
                                </div>

                               
                               
                            </div>

                            <!-- Right Column: Documents -->
                            <div class="col-lg-4 border-start ps-lg-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-text me-2"></i>Officer Documents</h6>
                                <div class="row g-3">
                                    @if($docs)
                                        @foreach(['picture' => 'Profile Picture',  'visiting_card' => 'Visiting Card'] as $field => $label)
                                            <div class="col-6 col-lg-12">
                                                <div class="p-2 border rounded text-center bg-light">
                                                    <small class="d-block text-muted mb-1">{{ $label }}</small>
                                                    @if($docs->$field)
                                                        @php
                                                            $ext = pathinfo($docs->$field, PATHINFO_EXTENSION);
                                                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                                                        @endphp
                                                        @if($isImage)
                                                            <a href="{{ asset('storage/' . $docs->$field) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $docs->$field) }}" class="img-fluid rounded mb-2" style="max-height: 80px;" alt="{{ $label }}">
                                                            </a>
                                                        @endif
                                                        <a href="{{ asset('storage/' . $docs->$field) }}" target="_blank" class="btn btn-sm btn-outline-primary d-block">
                                                            <i class="bi bi-box-arrow-up-right me-1"></i> View
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">Not uploaded</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-muted italic">No documents available.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $ratingFormOpen = ! $existingOfficerRating || old('rating') !== null || old('comment') !== null || $errors->has('rating') || $errors->has('comment');
                    @endphp
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-star-fill me-2"></i>Rate this Officer</h5>
                        </div>
                        <div class="card-body">
                            @if ($existingOfficerRating)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <strong>Your rating:</strong>
                                        <span class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $existingOfficerRating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </span>
                                    </div>
                                    @if ($existingOfficerRating->comment)
                                        <p class="mb-3"><strong>Comment:</strong> {{ $existingOfficerRating->comment }}</p>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="toggle-officer-rating-edit-{{ $officer->id }}">Edit Rating</button>
                            @endif

                            <div id="officer-rating-edit-form-{{ $officer->id }}" class="{{ $ratingFormOpen ? '' : 'd-none' }} mt-3">
                                <form method="POST" action="{{ route('customer.application.bank_officer_rating.store', ['newApplication' => $newApplication, 'officer' => $officer]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rating_{{ $officer->id }}" class="form-label">Rating</label>
                                        <select name="rating" id="rating_{{ $officer->id }}" class="form-select @error('rating') is-invalid @enderror" required>
                                            <option value="">Select rating</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ old('rating', optional($existingOfficerRating)->rating) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('rating')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment_{{ $officer->id }}" class="form-label">Comment</label>
                                        <textarea name="comment" id="comment_{{ $officer->id }}" rows="3" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', optional($existingOfficerRating)->comment) }}</textarea>
                                        @error('comment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Officer Rating</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if ($existingOfficerRating)
                        @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var toggleButton = document.getElementById('toggle-officer-rating-edit-{{ $officer->id }}');
                                    var ratingForm = document.getElementById('officer-rating-edit-form-{{ $officer->id }}');

                                    if (!toggleButton || !ratingForm) {
                                        return;
                                    }

                                    toggleButton.addEventListener('click', function () {
                                        ratingForm.classList.toggle('d-none');
                                        if (!ratingForm.classList.contains('d-none')) {
                                            var ratingField = document.getElementById('rating_{{ $officer->id }}');
                                            if (ratingField) {
                                                ratingField.focus();
                                            }
                                        }
                                    });
                                });
                            </script>
                        @endpush
                    @endif
                </div>
            @endforeach

            <a href="{{ route('customer.applications') }}" class="btn btn-secondary">Back to requests</a>
        </div>
    </div>
@endsection
