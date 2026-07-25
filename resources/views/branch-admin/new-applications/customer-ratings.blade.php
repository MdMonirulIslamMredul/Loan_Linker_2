@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <a href="{{ route('branch-admin.new-applications.show', $newApplication) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Request
            </a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h5 class="mb-1"><i class="bi bi-star-fill me-2"></i>Customer Ratings for {{ optional($customer)->name ?? 'Customer' }}</h5>
                    <p class="mb-0 text-muted">Request #{{ $newApplication->id }}</p>
                </div>
                <div class="text-end">
                    @if ($customerRatingCount)
                        <div class="text-warning mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($customerAverageRating >= $i)
                                    <i class="bi bi-star-fill"></i>
                                @elseif ($customerAverageRating > $i - 1)
                                    <i class="bi bi-star-half"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="small text-muted">{{ number_format($customerAverageRating, 1) }} average from {{ $customerRatingCount }} rating{{ $customerRatingCount > 1 ? 's' : '' }}</div>
                    @else
                        <div class="small text-muted">No ratings available for this customer yet.</div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if ($customerRatingCount)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Branch Admin</th>
                                    <th>Request</th>
                                    <th>Overall Rating</th>
                                    <th>Details</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customerRatings as $rating)
                                    <tr>
                                        <td>{{ optional($rating->branchAdmin)->name ?? 'Unknown' }}</td>
                                        <td>{{ $rating->newLoanApplication?->id ? 'Request #' . $rating->newLoanApplication->id : 'N/A' }}</td>
                                        <td>
                                            <span class="text-warning d-block">
                                                @php $r = $rating->rating; @endphp
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
                                            <span class="small text-muted">{{ $rating->rating }}/5</span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <div><span class="text-muted">Info Accuracy:</span>
                                                    <span class="text-warning ms-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="bi {{ $i <= $rating->information_accuracy ? 'bi-star-fill' : 'bi-star' }}" style="font-size: 0.8rem;"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                                <div><span class="text-muted">Behavior:</span>
                                                    <span class="text-warning ms-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="bi {{ $i <= $rating->behavior ? 'bi-star-fill' : 'bi-star' }}" style="font-size: 0.8rem;"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                                <div><span class="text-muted">Response Time:</span>
                                                    <span class="text-warning ms-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="bi {{ $i <= $rating->response_time ? 'bi-star-fill' : 'bi-star' }}" style="font-size: 0.8rem;"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $rating->comment ?: 'No comment' }}</td>
                                        <td>{{ $rating->created_at?->format('d M, Y') ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        No customer ratings have been submitted yet for this customer.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
