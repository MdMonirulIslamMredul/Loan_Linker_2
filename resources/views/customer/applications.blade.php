@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">My Loan Applications</h4>

            @if ($applications->count() === 0)
                <p class="text-muted">You have not submitted any loan applications yet.</p>
            @else
                @foreach ($applications as $app)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">Application #{{ $app->id }} &mdash;
                                        {{ optional($app->loan)->name }}</h5>
                                    <small class="text-muted">Submitted {{ $app->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <span class="badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong>Full Name:</strong> {{ $app->full_name }}</p>
                                    <p><strong>Email:</strong> {{ $app->email }}</p>
                                    <p><strong>Phone:</strong> {{ $app->phone }}</p>
                                    <p><strong>NID Number:</strong> {{ $app->nid_number }}</p>
                                    <p><strong>Date of Birth:</strong>
                                        {{ $app->date_of_birth ? $app->date_of_birth->format('M d, Y') : '-' }}</p>
                                    <p><strong>Gender:</strong> {{ ucfirst($app->gender) }}</p>
                                    <p><strong>Occupation:</strong> {{ $app->occupation }}</p>
                                    <p><strong>Monthly Income:</strong> {{ $app->monthly_income }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p><strong>Present Address:</strong> {{ $app->present_address }}</p>
                                    <p><strong>Permanent Address:</strong> {{ $app->permanent_address ?? '-' }}</p>
                                    <p><strong>Company Name:</strong> {{ $app->company_name ?? '-' }}</p>
                                    <p><strong>Employment Type:</strong>
                                        {{ ucfirst(str_replace('_', ' ', $app->employment_type)) }}</p>
                                    <p><strong>Loan Amount:</strong> {{ number_format($app->loan_amount, 2) }}</p>
                                    <p><strong>Tenure (months):</strong> {{ $app->tenure_months }}</p>
                                    <p><strong>Purpose:</strong> {{ $app->purpose_of_loan }}</p>
                                </div>
                            </div>

                            <div class="mt-3">
                                @if (!empty($app->admin_notes))
                                    <p><strong>Admin Notes:</strong></p>
                                    <div class="alert alert-warning text-dark">
                                        {!! nl2br(e($app->admin_notes)) !!}
                                    </div>
                                @else
                                    <p><strong>Admin Notes:</strong> <span class="text-muted">No notes yet</span></p>
                                @endif

                                <p><strong>Documents:</strong>
                                    @if (is_array($app->documents) && count($app->documents))
                                        <ul class="mb-0">
                                            @foreach ($app->documents as $doc)
                                                <li>
                                                    <a href="{{ asset('storage/' . ltrim($doc, '/')) }}" target="_blank"
                                                        rel="noopener">{{ basename($doc) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">No documents uploaded.</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $applications->links() }}
            @endif
        </div>
    </div>
@endsection
