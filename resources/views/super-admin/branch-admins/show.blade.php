@extends('layouts.admin')

@section('title', ' Bank Officer Details')
@section('dashboard-title', ' Bank Officer Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <a href="{{ route('super-admin.branch-admins.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Bank Officers
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">{{ $admin->name }}</h4>
                            <p class="mb-0 text-muted">Branch Officer details and linked documents</p>
                        </div>
                        <span class="badge {{ $admin->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $admin->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Officer ID</small>
                                <strong>#{{ $admin->id }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Role</small>
                                <strong>{{ ucfirst(str_replace('_', ' ', $admin->role)) }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $admin->email }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Phone</small>
                                <strong>{{ $admin->phone }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Bank</small>
                                <strong>{{ $admin->bank->name ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Branch</small>
                                <strong>{{ $admin->branch->name ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Access Status</small>
                                <strong>{{ $admin->is_access === true ? 'Allowed' : ($admin->is_access === false ? 'Not Allowed' : 'Pending') }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Bank Official ID</small>
                                <strong>{{ $admin->bank_official_id ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Officer Document ID</small>
                                <strong>{{ $admin->officer_document_id ?? 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Personal & Work Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($admin->nid_number)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">NID Number</small>
                                    <strong>{{ $admin->nid_number }}</strong>
                                </div>
                            @endif
                            @if($admin->dob)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <strong>{{ $admin->dob->format('d M, Y') }}</strong>
                                </div>
                            @endif
                            @if($admin->designation)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Designation</small>
                                    <strong>{{ $admin->designation }}</strong>
                                </div>
                            @endif
                            @if($admin->organization_name)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Organization</small>
                                    <strong>{{ $admin->organization_name }}</strong>
                                </div>
                            @endif
                            @if($admin->date_of_joining)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Joining</small>
                                    <strong>{{ $admin->date_of_joining->format('d M, Y') }}</strong>
                                </div>
                            @endif
                            @if($admin->total_working_experience)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Work Experience</small>
                                    <strong>{{ $admin->total_working_experience }}</strong>
                                </div>
                            @endif
                            @if($admin->contact_address)
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Contact Address</small>
                                    <p class="mb-0">{{ $admin->contact_address }}</p>
                                </div>
                            @endif
                            @if($admin->permanent_address)
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Permanent Address</small>
                                    <p class="mb-0">{{ $admin->permanent_address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-building me-2"></i>Bank Official Information</h5>
                    </div>
                    <div class="card-body">
                        @if($admin->bankOfficial)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Bank</small>
                                    <strong>{{ $admin->bankOfficial->bank_name }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Branch</small>
                                    <strong>{{ $admin->bankOfficial->branch_name }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Official Designation</small>
                                    <strong>{{ $admin->bankOfficial->designation }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Department</small>
                                    <strong>{{ $admin->bankOfficial->department }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Office ID</small>
                                    <strong>{{ $admin->bankOfficial->office_id_number }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Official Email</small>
                                    <strong>{{ $admin->bankOfficial->official_email }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Official Mobile</small>
                                    <strong>{{ $admin->bankOfficial->official_mobile_number }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Working Area</small>
                                    <strong>{{ $admin->bankOfficial->working_area }}</strong>
                                </div>
                                @if($admin->bankOfficial->date_of_joining)
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted d-block">Official Joined</small>
                                        <strong>{{ $admin->bankOfficial->date_of_joining->format('d M, Y') }}</strong>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-muted mb-0">No bank official information available.</p>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Officer Documents</h5>
                    </div>
                    <div class="card-body">
                        @if($admin->officerDocument)
                            <div class="row">
                                @php
                                    $pictureUrl = $admin->officerDocument->picture ? asset('storage/' . $admin->officerDocument->picture) : null;
                                    $nidUrl = $admin->officerDocument->nid ? asset('storage/' . $admin->officerDocument->nid) : null;
                                    $officeIdUrl = $admin->officerDocument->office_id ? asset('storage/' . $admin->officerDocument->office_id) : null;
                                    $visitingCardUrl = $admin->officerDocument->visiting_card ? asset('storage/' . $admin->officerDocument->visiting_card) : null;
                                    $isImage = fn($url) => $url && preg_match('/\.(jpg|jpeg|png)$/i', $url);
                                @endphp

                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Picture</small>
                                    @if($pictureUrl)
                                        <a href="#" class="d-block document-preview-link" data-bs-toggle="modal" data-bs-target="#documentPreviewModal" data-src="{{ $pictureUrl }}" data-title="Officer Picture">
                                            <img src="{{ $pictureUrl }}" alt="Officer Picture" class="img-fluid rounded" style="max-height: 250px;" />
                                        </a>
                                    @else
                                        <span class="text-muted">No picture uploaded.</span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">NID Document</small>
                                    @if($nidUrl)
                                        @if($isImage($nidUrl))
                                            <a href="#" class="d-block document-preview-link" data-bs-toggle="modal" data-bs-target="#documentPreviewModal" data-src="{{ $nidUrl }}" data-title="NID Document">
                                                <img src="{{ $nidUrl }}" alt="NID Document" class="img-fluid rounded" style="max-height: 250px;" />
                                            </a>
                                        @else
                                            <a href="{{ $nidUrl }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">View NID</a>
                                        @endif
                                    @else
                                        <span class="text-muted">Not uploaded.</span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Office ID Document</small>
                                    @if($officeIdUrl)
                                        @if($isImage($officeIdUrl))
                                            <a href="#" class="d-block document-preview-link" data-bs-toggle="modal" data-bs-target="#documentPreviewModal" data-src="{{ $officeIdUrl }}" data-title="Office ID Document">
                                                <img src="{{ $officeIdUrl }}" alt="Office ID Document" class="img-fluid rounded" style="max-height: 250px;" />
                                            </a>
                                        @else
                                            <a href="{{ $officeIdUrl }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">View Office ID</a>
                                        @endif
                                    @else
                                        <span class="text-muted">Not uploaded.</span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Visiting Card</small>
                                    @if($visitingCardUrl)
                                        @if($isImage($visitingCardUrl))
                                            <a href="#" class="d-block document-preview-link" data-bs-toggle="modal" data-bs-target="#documentPreviewModal" data-src="{{ $visitingCardUrl }}" data-title="Visiting Card">
                                                <img src="{{ $visitingCardUrl }}" alt="Visiting Card" class="img-fluid rounded" style="max-height: 250px;" />
                                            </a>
                                        @else
                                            <a href="{{ $visitingCardUrl }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">View Visiting Card</a>
                                        @endif
                                    @else
                                        <span class="text-muted">Not uploaded.</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">No officer document data available.</p>
                        @endif
                    </div>
                </div>

                <div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-labelledby="documentPreviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="documentPreviewModalLabel">Document Preview</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center align-items-center p-0">
                                <img id="documentPreviewModalImage" src="" alt="Document Preview" class="img-fluid" style="max-height: 100vh; max-width: 100%;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Created</small>
                            <strong>{{ $admin->created_at->format('d M, Y h:i A') }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Last Updated</small>
                            <strong>{{ $admin->updated_at->format('d M, Y h:i A') }}</strong>
                        </div>
                        @if($admin->bankOfficial)
                            <div class="mb-3">
                                <small class="text-muted d-block">Bank Official</small>
                                <strong>{{ $admin->bankOfficial->designation ?? 'N/A' }}</strong>
                            </div>
                        @endif
                        @if($admin->officerDocument)
                            <div class="mb-3">
                                <small class="text-muted d-block">Documents</small>
                                <strong>{{ $admin->officerDocument->picture || $admin->officerDocument->nid || $admin->officerDocument->office_id || $admin->officerDocument->visiting_card ? 'Uploaded' : 'None' }}</strong>
                            </div>
                        @endif
                        @if($admin->access_mes)
                            <div class="mb-3">
                                <small class="text-muted d-block">Rejection Note</small>
                                <p class="mb-0 text-danger">{{ $admin->access_mes }}</p>
                            </div>
                        @endif

                        <form action="{{ route('super-admin.branch-admins.update-access', $admin) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <small class="text-muted d-block">Access Permission</small>
                                <select name="is_access" id="is_access" class="form-select">
                                    <option value="" {{ $admin->is_access === null ? 'selected' : '' }}>Select access status</option>
                                    <option value="0" {{ $admin->is_access === false ? 'selected' : '' }}>Not Allowed</option>
                                    <option value="1" {{ $admin->is_access === true ? 'selected' : '' }}>Allowed</option>
                                </select>
                            </div>
                            <div class="mb-3" id="accessMesContainer">
                                <small class="text-muted d-block">Rejection Reason</small>
                                <textarea name="access_mes" class="form-control" rows="4">{{ old('access_mes', $admin->access_mes) }}</textarea>
                                @error('access_mes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Provide a reason when denying access.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Access</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('documentPreviewModal');
                var modalImage = document.getElementById('documentPreviewModalImage');
                var modalTitle = document.getElementById('documentPreviewModalLabel');
                var accessSelect = document.getElementById('is_access');
                var accessMesContainer = document.getElementById('accessMesContainer');

                document.querySelectorAll('.document-preview-link').forEach(function (link) {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        var src = link.getAttribute('data-src');
                        var title = link.getAttribute('data-title') || 'Document Preview';

                        if (modalImage && src) {
                            modalImage.src = src;
                            modalImage.alt = title;
                        }

                        if (modalTitle) {
                            modalTitle.textContent = title;
                        }
                    });
                });

                function toggleAccessMes() {
                    if (!accessSelect || !accessMesContainer) {
                        return;
                    }

                    if (accessSelect.value === '0') {
                        accessMesContainer.style.display = 'block';
                        accessMesContainer.querySelector('textarea').required = true;
                    } else {
                        accessMesContainer.style.display = 'none';
                        accessMesContainer.querySelector('textarea').required = false;
                    }
                }

                if (accessSelect) {
                    accessSelect.addEventListener('change', toggleAccessMes);
                    toggleAccessMes();
                }
            });
        </script>
    @endpush
@endsection
