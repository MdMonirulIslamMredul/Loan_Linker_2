@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="mb-1">Officer Ratings</h4>
                    <p class="text-muted mb-0">Officer: {{ $officer->name ?? 'Unknown Officer' }} | Request #{{ $newApplication->id }}</p>
                </div>
                <a href="{{ route('customer.new_application.officer_details', ['newApplication' => $newApplication, 'officer' => $officer]) }}" class="btn btn-outline-secondary">Back to Officer Details</a>
            </div>

            <div class="mb-4">
                @if ($ratingCount)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $averageStars ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </span>
                        <strong>{{ number_format($averageRating, 1) }} / 5</strong>
                    </div>
                    <p class="text-muted mb-0">Based on {{ $ratingCount }} rating{{ $ratingCount > 1 ? 's' : '' }}.</p>
                @else
                    <div class="alert alert-info mb-0">No ratings are available yet for this officer.</div>
                @endif
            </div>

            @if ($ratingCount)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Customer</th>
                                <th>Request</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($officerRatings as $rating)
                                <tr>
                                    <td>{{ optional($rating->customer)->name ?? 'Customer' }}</td>
                                    <td>{{ $rating->newLoanApplication?->id ? 'Request #' . $rating->newLoanApplication->id : 'N/A' }}</td>
                                    <td>
                                        <span class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $rating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </span>
                                        <span class="ms-2">{{ $rating->rating }}/5</span>
                                    </td>
                                    <td>{{ $rating->comment ?: 'No comment' }}</td>
                                    <td>{{ $rating->created_at?->format('d M, Y') ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
