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
                @endphp
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Officer: {{ $officer->name ?? 'Unknown Officer' }}</h5>
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
                                        <div class="col-md-6 mb-2"><strong>Office ID:</strong> {{ $official->office_id_number ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Official Email:</strong> {{ $official->official_email ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Official Phone:</strong> {{ $official->official_mobile_number ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Working Area:</strong> {{ $official->working_area ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Joining Date:</strong> {{ optional($official->date_of_joining)->format('M d, Y') ?? 'N/A' }}</div>
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
                                        <div class="col-md-6 mb-2"><strong>NID Number:</strong> {{ $officer->nid_number ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Date of Birth:</strong> {{ optional($officer->dob)->format('M d, Y') ?? 'N/A' }}</div>
                                        <div class="col-md-12 mb-2"><strong>Contact Address:</strong> {{ $officer->contact_address ?? 'N/A' }}</div>
                                        <div class="col-md-12 mb-2"><strong>Permanent Address:</strong> {{ $officer->permanent_address ?? 'N/A' }}</div>
                                    </div>
                                </div>

                                <!-- Background info -->
                                <div>
                                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-mortarboard me-2"></i>Background & Experience</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-2"><strong>Education:</strong> {{ $officer->education ?? 'N/A' }}</div>
                                        <div class="col-md-6 mb-2"><strong>Working Experience:</strong> {{ $officer->total_working_experience ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Documents -->
                            <div class="col-lg-4 border-start ps-lg-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-text me-2"></i>Officer Documents</h6>
                                <div class="row g-3">
                                    @if($docs)
                                        @foreach(['picture' => 'Profile Picture', 'nid' => 'NID Card', 'office_id' => 'Office ID', 'visiting_card' => 'Visiting Card'] as $field => $label)
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
                </div>
            @endforeach

            <a href="{{ route('customer.applications') }}" class="btn btn-secondary">Back to requests</a>
        </div>
    </div>
@endsection
