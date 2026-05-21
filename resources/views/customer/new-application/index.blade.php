@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">My New Loan Requests</h4>

              <div class="mb-4">
                <a href="{{ route('customer.new_application.create') }}" class="btn btn-primary">Create New Loan Application</a>
            </div>

            @if ($applications->count() === 0)
                <p class="text-muted">You have not submitted any new loan requests yet.</p>
            @else
                @foreach ($applications as $app)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">Request #{{ $app->id }}</h5>
                                    <small class="text-muted">Submitted {{ $app->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <span class="badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong>Service Category:</strong> {{ ucfirst(str_replace('_', ' ', $app->service_category)) }}</p>
                                    <p><strong>Service Type:</strong> {{ ucfirst(str_replace('_', ' ', $app->service_type)) }}</p>
                                    <p><strong>Expected Amount:</strong> ৳{{ number_format($app->expected_amount, 2) }}</p>
                                    <p><strong>Tenure (months):</strong> {{ $app->tenure_months }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Customer Name:</strong> {{ optional($app->customer)->name ?? 'You' }}</p>
                                    <p><strong>Email:</strong> {{ optional($app->customer)->email ?? auth()->user()->email }}</p>
                                    <p><strong>Selected Banks:</strong>
                                        @php
                                            $bankNames = collect($app->bank_ids)->filter()->map(function ($bankId) {
                                                return optional(\App\Models\Bank::find($bankId))->name;
                                            })->filter()->join(', ');
                                        @endphp
                                        {{ $bankNames ?: 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-3">
                                <p><strong>Additional Notes:</strong></p>
                                <p>{{ $app->additional_notes ?: 'No additional notes provided.' }}</p>
                            </div>

                            <div class="mt-4">
                                <h6><i class="bi bi-unlock-fill text-primary me-2"></i>Officer Unlock Details</h6>
                                @if ($app->leadAccesses->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-hover table-sm align-middle mt-2 border-top">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-3">Officer Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th class="text-end pe-3">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($app->leadAccesses as $access)
                                                    <tr>
                                                        <td class="ps-3 fw-medium">
                                                            {{ optional($access->officer)->name ?? 'Unknown Officer' }}
                                                        </td>
                                                        <td>{{ optional($access->officer)->email ?? 'N/A' }}</td>
                                                        <td>{{ optional($access->officer)->phone ?? 'N/A' }}</td>
                                                        <td class="text-end pe-3">
                                                            <a href="{{ route('customer.new_application.officer_details', ['newApplication' => $app, 'officer' => $access->officer_id]) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                                                <i class="bi bi-eye me-1"></i> View
                                                            </a>
                                                            <a href="{{ route('chat.index', ['user_id' => $access->officer_id, 'user_name' => optional($access->officer)->name, 'user_role' => optional($access->officer)->role]) }}" class="btn btn-sm btn-success rounded-pill px-3 ms-1">
                                                                <i class="bi bi-chat-dots me-1"></i> Chat
                                                            </a>
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
                @endforeach

                {{ $applications->links() }}
            @endif
        </div>
    </div>
@endsection
