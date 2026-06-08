@extends('layouts.admin')

@section('title', 'Edit  Bank Officers Details')
@section('dashboard-title', 'Super Admin - Edit  Bank Officers Details')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="bi bi-person-badge fs-2 text-success"></i>
                </div>
                <div>
                    <h2 class="mb-1 fw-bold">Edit Bank Officer </h2>
                    <p class="mb-0 text-muted">Update bank officer details</p>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('super-admin.branch-admins.update', $user) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        <i class="bi bi-person me-1"></i>Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="form-control" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        <i class="bi bi-envelope me-1"></i>Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="form-control" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">
                        <i class="bi bi-telephone me-1"></i>Phone
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                        class="form-control" required>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bank_select" class="form-label fw-semibold">
                        <i class="bi bi-bank me-1"></i>Bank
                    </label>
                    <select id="bank_select" name="bank_id" class="form-select">
                        <option value="">Select a bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ old('bank_id', $user->bank_id) == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="branch_id" value="{{ old('branch_id', $user->branch_id) }}">

                <hr class="my-4">

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Leave password fields empty to keep the current password
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">
                        <i class="bi bi-key me-1"></i>New Password
                    </label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Leave blank to keep current password">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">
                        <i class="bi bi-key me-1"></i>Confirm New Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Confirm new password">
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Officer Documents</h5>

                @php
                    $officerDocument = $user->officerDocument;
                    $documentStatus = [
                        'picture' => optional($officerDocument)->picture,
                        'nid' => optional($officerDocument)->nid,
                        'office_id' => optional($officerDocument)->office_id,
                        'visiting_card' => optional($officerDocument)->visiting_card,
                    ];
                    $isDocumentImage = fn($file) => $file && preg_match('/\.(jpg|jpeg|png|gif|svg)$/i', $file);
                @endphp

                <div class="row mb-4">
                    @foreach ($documentStatus as $field => $file)
                        <div class="col-sm-6 col-lg-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong>{{ ucwords(str_replace('_', ' ', $field)) }}</strong>
                                    <span class="badge {{ $file ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $file ? 'Uploaded' : 'Not uploaded' }}
                                    </span>
                                </div>

                                @if ($file)
                                    @if ($isDocumentImage($file))
                                        <img src="{{ asset('storage/' . $file) }}" alt="{{ $field }} preview" class="img-fluid rounded mb-2" style="max-height: 120px; object-fit: cover; width: 100%;">
                                    @else
                                        <div class="small text-muted mb-2">Uploaded file available.</div>
                                    @endif

                                    <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                        Preview
                                    </a>
                                @else
                                    <div class="small text-muted">No document uploaded yet.</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label for="picture" class="form-label fw-semibold">Picture</label>
                    <input type="file" name="picture" id="picture" class="form-control">
                    @if(optional($officerDocument)->picture)
                        <div class="form-text mt-1">
                            Current file: <a href="{{ asset('storage/' . $officerDocument->picture) }}" target="_blank">View</a>
                        </div>
                    @endif
                    @error('picture')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nid" class="form-label fw-semibold">NID</label>
                    <input type="file" name="nid" id="nid" class="form-control">
                    @if(optional($officerDocument)->nid)
                        <div class="form-text mt-1">
                            Current file: <a href="{{ asset('storage/' . $officerDocument->nid) }}" target="_blank">View</a>
                        </div>
                    @endif
                    @error('nid')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="office_id" class="form-label fw-semibold">Office ID</label>
                    <input type="file" name="office_id" id="office_id" class="form-control">
                    @if(optional($officerDocument)->office_id)
                        <div class="form-text mt-1">
                            Current file: <a href="{{ asset('storage/' . $officerDocument->office_id) }}" target="_blank">View</a>
                        </div>
                    @endif
                    @error('office_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="visiting_card" class="form-label fw-semibold">Visiting Card</label>
                    <input type="file" name="visiting_card" id="visiting_card" class="form-control">
                    @if(optional($officerDocument)->visiting_card)
                        <div class="form-text mt-1">
                            Current file: <a href="{{ asset('storage/' . $officerDocument->visiting_card) }}" target="_blank">View</a>
                        </div>
                    @endif
                    @error('visiting_card')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">
                            <i class="bi bi-toggle-on me-1"></i>Active Status
                        </label>
                    </div>
                    <small class="text-muted">Inactive admins cannot log in to the system</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.branch-admins.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Branch Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

