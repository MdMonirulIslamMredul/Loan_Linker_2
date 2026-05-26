@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="mb-1">My Ratings</h4>
                    <p class="text-muted mb-0">See all completed officer ratings and pending rating opportunities from unlocked officers.</p>
                </div>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Completed Ratings</h5>
                        </div>
                        <div class="card-body">
                            @if ($givenRatings->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Officer</th>
                                                <th>Request</th>
                                                <th>Rating</th>
                                                <th>Comment</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($givenRatings as $rating)
                                                <tr>
                                                    <td>
                                                        @if ($rating->newLoanApplication && $rating->officer)
                                                            <a href="{{ route('customer.application.officer_ratings', ['newApplication' => $rating->newLoanApplication, 'officer' => $rating->officer]) }}" class="btn btn-outline-success">
                                                                {{ $rating->officer->name }}
                                                            </a>
                                                        @else
                                                            {{ optional($rating->officer)->name ?? 'Unknown Officer' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $rating->newLoanApplication?->id ? 'Request #' . $rating->newLoanApplication->id : 'N/A' }}</td>
                                                    <td>
                                                        <span class="text-warning">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="bi {{ $i <= $rating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                            @endfor
                                                        </span>
                                                        <span class="ms-1">{{ $rating->rating }}/5</span>
                                                    </td>
                                                    <td>{{ $rating->comment ?: 'No comment' }}</td>
                                                    <td>{{ optional($rating->created_at)->format('d M, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mb-0">You have not rated any officers yet.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Pending Ratings</h5>
                        </div>
                        <div class="card-body">
                            @if ($pendingUnlocks->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Officer</th>
                                                <th>Request</th>
                                                <th>Unlocked</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendingUnlocks as $unlock)
                                                <tr>
                                                    <td>{{ optional($unlock->officer)->name ?? 'Unknown Officer' }}</td>
                                                    <td>{{ $unlock->newLoanApplication?->id ? 'Request #' . $unlock->newLoanApplication->id : 'N/A' }}</td>
                                                    <td>{{ optional($unlock->created_at)->format('d M, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('customer.new_application.officer_details', ['newApplication' => $unlock->newLoanApplication, 'officer' => $unlock->officer]) }}" class="btn btn-sm btn-outline-primary">Rate Now</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-success mb-0">No pending officer ratings available at the moment.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
