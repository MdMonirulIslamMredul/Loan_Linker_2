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
                    <div class="card-header bg-primary text-white py-3">
                        <div class="row align-items-center gx-3 gy-3">
                            <div class="col-12 col-xl-5">
                                <h5 class="mb-2 mb-xl-0"><i class="bi bi-person-badge-fill me-2"></i>Officer: {{ $officer->name ?? 'Unknown Officer' }}</h5>
                                @if ($officerStats)
                                    @php $avg = $officerStats['avg']; @endphp
                                    <small class="text-warning d-block mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($avg >= $i)
                                                <i class="bi bi-star-fill"></i>
                                            @elseif ($avg > $i - 1)
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                        <span class="text-white-50 ms-2">{{ number_format($avg, 1) }} average from {{ $officerStats['count'] }} rating{{ $officerStats['count'] > 1 ? 's' : '' }}</span>
                                    </small>
                                @else
                                    <small class="text-white-50 d-block mb-1">No rating available for this officer</small>
                                @endif
                                <a href="{{ route('customer.application.officer_ratings', ['newApplication' => $newApplication, 'officer' => $officer]) }}" class="btn btn-sm btn-outline-light mt-2 mt-xl-0">View all ratings for this officer</a>
                            </div>

                            <div class="col-12 col-xl-4">
                                @if($officer->badges->isNotEmpty())
                                    <div class="badge-officer d-flex justify-content-center align-items-center gap-3 bg-white rounded-pill shadow-sm px-3 py-2 mx-auto" style="max-width: 100%;">
                                        @foreach($officer->badges->take(3) as $badge)
                                            @if($badge->logo)
                                                <img src="{{ asset($badge->logo) }}" alt="{{ $badge->name }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: contain;" />
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="col-12 col-xl-3 text-xl-end">
                                <span class="badge bg-white text-primary py-2 px-3 d-inline-block">Unlocked: {{ $access->purchased_at ? $access->purchased_at->format('M d, Y') : $access->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
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
                        $ratingFormOpen = ! $existingOfficerRating || old('professionalism') !== null || old('comment') !== null || $errors->has('professionalism') || $errors->has('behavior') || $errors->has('response_time') || $errors->has('comment');
                    @endphp
                    <div class="card border-0 shadow-sm mb-4" id="rating-section">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-star-fill me-2"></i>Rate this Officer</h5>
                        </div>
                        <div class="card-body">
                            @if ($existingOfficerRating)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <strong>Overall Rating:</strong>
                                        <span class="text-warning">
                                            @php $r = $existingOfficerRating->rating; @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($r >= $i)
                                                    <i class="bi bi-star-fill"></i>
                                                @elseif ($r > $i - 1)
                                                    <i class="bi bi-star-half"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="ms-1">{{ number_format($r, 1) }}/5</span>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <span class="text-muted small">Professionalism:</span>
                                            <span class="text-warning ms-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $existingOfficerRating->professionalism ? 'bi-star-fill' : 'bi-star' }}" style="font-size: 0.8rem;"></i>
                                                @endfor
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted small">Behavior:</span>
                                            <span class="text-warning ms-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $existingOfficerRating->behavior ? 'bi-star-fill' : 'bi-star' }}" style="font-size: 0.8rem;"></i>
                                                @endfor
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted small">Response Time:</span>
                                            <span class="text-warning ms-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $existingOfficerRating->response_time ? 'bi-star-fill' : 'bi-star' }}" style="font-size: 0.8rem;"></i>
                                                @endfor
                                            </span>
                                        </div>
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
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="professionalism_{{ $officer->id }}" class="form-label">Professionalism <span class="text-danger">*</span></label>
                                            <select name="professionalism" id="professionalism_{{ $officer->id }}" class="form-select @error('professionalism') is-invalid @enderror" required>
                                                <option value="">Select</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('professionalism', optional($existingOfficerRating)->professionalism) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('professionalism')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="behavior_{{ $officer->id }}" class="form-label">Behavior <span class="text-danger">*</span></label>
                                            <select name="behavior" id="behavior_{{ $officer->id }}" class="form-select @error('behavior') is-invalid @enderror" required>
                                                <option value="">Select</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('behavior', optional($existingOfficerRating)->behavior) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('behavior')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="response_time_{{ $officer->id }}" class="form-label">Response Time <span class="text-danger">*</span></label>
                                            <select name="response_time" id="response_time_{{ $officer->id }}" class="form-select @error('response_time') is-invalid @enderror" required>
                                                <option value="">Select</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('response_time', optional($existingOfficerRating)->response_time) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('response_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
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
                                            var ratingField = document.getElementById('professionalism_{{ $officer->id }}');
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
