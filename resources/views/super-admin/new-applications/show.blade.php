@extends('layouts.admin')

@section('title', 'New Loan Request Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <a href="{{ route('super-admin.new-applications.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to New Loan Requests
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="bi bi-envelope-exclamation me-2"></i>Request #{{ $newApplication->id }}</h4>
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

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-unlock-fill me-2"></i>Officer Unlock Details</h5>
                    </div>
                    <div class="card-body">
                        @if ($newApplication->leadAccesses->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-hover table-sm align-middle mt-2 border-top">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Officer Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Application Status</th>
                                            <th class="text-end pe-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($newApplication->leadAccesses as $access)
                                            @php
                                                $rawStatus = $access->application_status ?? null;
                                                $statusClass = 'text-muted';
                                                if ($rawStatus) {
                                                    switch (strtolower($rawStatus)) {
                                                        case 'pending':
                                                            $statusClass = 'badge bg-warning text-dark';
                                                            break;
                                                        case 'review':
                                                            $statusClass = 'badge bg-info text-dark';
                                                            break;
                                                        case 'approved':
                                                            $statusClass = 'badge bg-success';
                                                            break;
                                                        case 'rejected':
                                                            $statusClass = 'badge bg-danger';
                                                            break;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td class="ps-3 fw-medium">
                                                    {{ optional($access->officer)->name ?? 'Unknown Officer' }}
                                                </td>
                                                <td>{{ optional($access->officer)->email ?? 'N/A' }}</td>
                                                <td>{{ optional($access->officer)->phone ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($rawStatus)
                                                        <span class="{{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $rawStatus)) }}</span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="text-end pe-3">
                                                    @if ($access->officer)
                                                        <a href="{{ route('super-admin.branch-admins.show', ['user' => $access->officer_id]) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                                            <i class="bi bi-eye me-1"></i> View
                                                        </a>
                                                        <a href="{{ route('chat.index', ['user_id' => $access->officer_id, 'user_name' => optional($access->officer)->name, 'user_role' => optional($access->officer)->role]) }}" class="btn btn-sm btn-success rounded-pill px-3 ms-1">
                                                            <i class="bi bi-chat-dots me-1"></i> Chat
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No officer linked</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-3 bg-light rounded text-muted">
                                <i class="bi bi-info-circle me-2"></i> Not unlocked by any officer yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-gear-fill me-2"></i>Manage Request</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('super-admin.new-applications.updateStatus', $newApplication) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ $newApplication->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $newApplication->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    {{-- <option value="pending" {{ $newApplication->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="review" {{ $newApplication->status === 'review' ? 'selected' : '' }}>Review</option>
                                    <option value="approved" {{ $newApplication->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $newApplication->status === 'rejected' ? 'selected' : '' }}>Rejected</option> --}}
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
