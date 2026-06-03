@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">My New Loan Requests</h4>

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
                                    <p><strong>Service Type:</strong> {{ ucfirst(str_replace('_', ' ', $app->service_type)) }}</p>৳
                                    <p><strong>Expected Amount:</strong> ৳ {{ number_format($app->expected_amount, 2) }}</p>
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
                        </div>
                    </div>
                @endforeach

                {{ $applications->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
@endsection

