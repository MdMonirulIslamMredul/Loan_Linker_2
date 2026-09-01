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
                        @if ($customerAverageRating>= $i)
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
                            <th>Bank Officer</th>
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
                            <td>
                                <div class="fw-semibold text-dark">{{ optional($rating->branchAdmin)->name ?? 'Unknown' }}</div>
                                <small class="text-muted">Branch Official</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-medium px-2 py-1">
                                    {{ $rating->newLoanApplication?->id ? 'Req #' . $rating->newLoanApplication->id : 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="text-warning d-inline-flex gap-1" style="font-size: 1rem;">
                                        @php $r = $rating->rating; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($r>= $i)
                                            <i class="bi bi-star-fill"></i>
                                            @elseif ($r > $i - 1)
                                            <i class="bi bi-star-half"></i>
                                            @else
                                            <i class="bi bi-star"></i>
                                            @endif
                                            @endfor
                                    </span>
                                    <span class="fw-bold text-dark small">{{ number_format($rating->rating, 1) }}/5</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2" style="max-width: 380px;">
                                    <div class="bg-light rounded px-2 py-1 border d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                        <span class="text-secondary">Info Accuracy:</span>
                                        <span class="fw-semibold text-dark me-1">{{ $rating->information_accuracy ?? '-' }}/5</span>
                                        <span class="text-warning d-inline-flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= ($rating->information_accuracy ?? 0) ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}" style="font-size: 0.7rem;"></i>
                                                @endfor
                                        </span>
                                    </div>
                                    <div class="bg-light rounded px-2 py-1 border d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                        <span class="text-secondary">Behavior:</span>
                                        <span class="fw-semibold text-dark me-1">{{ $rating->behavior ?? '-' }}/5</span>
                                        <span class="text-warning d-inline-flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= ($rating->behavior ?? 0) ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}" style="font-size: 0.7rem;"></i>
                                                @endfor
                                        </span>
                                    </div>
                                    <div class="bg-light rounded px-2 py-1 border d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                        <span class="text-secondary">Response Time:</span>
                                        <span class="fw-semibold text-dark me-1">{{ $rating->response_time ?? '-' }}/5</span>
                                        <span class="text-warning d-inline-flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= ($rating->response_time ?? 0) ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}" style="font-size: 0.7rem;"></i>
                                                @endfor
                                        </span>
                                    </div>
                                    <div class="bg-light rounded px-2 py-1 border d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                        <span class="text-secondary">Credit Score:</span>
                                        <span class="fw-semibold text-dark me-1">{{ $rating->credit_score ?? '-' }}/5</span>
                                        <span class="text-warning d-inline-flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= ($rating->credit_score ?? 0) ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}" style="font-size: 0.7rem;"></i>
                                                @endfor
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($rating->comment)
                                <span class="text-dark">{{ $rating->comment }}</span>
                                @else
                                <span class="text-muted fst-italic">No comment</span>
                                @endif
                            </td>
                            <td class="text-nowrap text-muted small">{{ $rating->created_at?->format('d M, Y') ?? 'N/A' }}</td>
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