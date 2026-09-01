@extends('layouts.customer')

@section('customer-content')
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom gap-3">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-star-fill text-warning me-2"></i>My Officer Ratings</h4>
                    <p class="text-muted mb-0">Track completed officer ratings and pending rating opportunities from officers who unlocked your requests.</p>
                </div>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>

            <div class="row g-4">
                {{-- Completed Ratings --}}
                <div class="col-12 col-xl-7">
                    <div class="card border shadow-none rounded-3 h-100">
                        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i>Completed Ratings</h5>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1 fw-medium">{{ $givenRatings->count() }} Given</span>
                        </div>
                        <div class="card-body p-0">
                            @if ($givenRatings->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light text-secondary border-bottom">
                                            <tr>
                                                <th class="ps-3">Officer</th>
                                                <th>Request</th>
                                                <th>Overall Rating</th>
                                                <th>Rating Breakdown</th>
                                                <th>Comment</th>
                                                <th class="pe-3">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($givenRatings as $rating)
                                                <tr>
                                                    <td class="ps-3">
                                                        @if ($rating->newLoanApplication && $rating->officer)
                                                            <a href="{{ route('customer.application.officer_ratings', ['newApplication' => $rating->newLoanApplication, 'officer' => $rating->officer]) }}" class="btn btn-outline-success btn-sm rounded-3 fw-medium">
                                                                {{ $rating->officer->name }}
                                                            </a>
                                                        @else
                                                            <span class="badge border border-success text-success bg-white px-3 py-2 rounded-3 fw-medium" style="font-size: 0.85rem;">
                                                                {{ optional($rating->officer)->name ?? 'Unknown Officer' }}
                                                            </span>
                                                        @endif
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
                                                                    @if ($r >= $i)
                                                                        <i class="bi bi-star-fill"></i>
                                                                    @elseif ($r > $i - 1)
                                                                        <i class="bi bi-star-half"></i>
                                                                    @else
                                                                        <i class="bi bi-star"></i>
                                                                    @endif
                                                                @endfor
                                                            </span>
                                                            <span class="fw-bold text-dark small">{{ number_format($r, 1) }}/5</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-1.5" style="max-width: 320px;">
                                                            <div class="bg-light rounded px-2.5 py-1.5 border" style="font-size: 0.76rem;">
                                                                <div class="text-secondary fw-medium mb-0.5">Professionalism</div>
                                                                <div>
                                                                    <span class="text-warning d-inline-flex gap-0.5">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i class="bi {{ $i <= ($rating->professionalism ?? 0) ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}" style="font-size: 0.75rem;"></i>
                                                                        @endfor
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="bg-light rounded px-2.5 py-1.5 border" style="font-size: 0.76rem;">
                                                                <div class="text-secondary fw-medium mb-0.5">Behavior</div>
                                                                <div>
                                                                    <span class="text-warning d-inline-flex gap-0.5">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i class="bi {{ $i <= ($rating->behavior ?? 0) ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}" style="font-size: 0.75rem;"></i>
                                                                        @endfor
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="bg-light rounded px-2.5 py-1.5 border" style="font-size: 0.76rem;">
                                                                <div class="text-secondary fw-medium mb-0.5">Response Time</div>
                                                                <div>
                                                                    <span class="text-warning d-inline-flex gap-0.5">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i class="bi {{ $i <= ($rating->response_time ?? 0) ? 'bi-star-fill' : 'bi-star text-muted opacity-25' }}" style="font-size: 0.75rem;"></i>
                                                                        @endfor
                                                                    </span>
                                                                </div>
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
                                                    <td class="pe-3 text-nowrap">
                                                        <div class="text-muted small mb-1.5">{{ optional($rating->created_at)->format('d M, Y') }}</div>
                                                        @if ($rating->newLoanApplication && $rating->officer)
                                                            <a href="{{ route('customer.new_application.officer_details', ['newApplication' => $rating->newLoanApplication, 'officer' => $rating->officer]) }}#rating-section" class="btn btn-sm btn-outline-primary shadow-sm rounded-pill px-2.5 py-0.5" style="font-size: 0.75rem;">
                                                                <i class="bi bi-pencil me-1"></i>Edit Rating
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-4 text-center text-muted">
                                    <i class="bi bi-star text-secondary opacity-50 display-6 d-block mb-2"></i>
                                    You have not rated any bank officers yet.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Pending Ratings --}}
                <div class="col-12 col-xl-5">
                    <div class="card border shadow-none rounded-3 h-100">
                        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Pending Ratings</h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1 fw-medium">{{ $pendingUnlocks->count() }} Pending</span>
                        </div>
                        <div class="card-body p-0">
                            @if ($pendingUnlocks->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light text-secondary border-bottom">
                                            <tr>
                                                <th class="ps-3">Officer</th>
                                                <th>Request</th>
                                                <th>Unlocked</th>
                                                <th class="pe-3 text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendingUnlocks as $unlock)
                                                <tr>
                                                    <td class="ps-3">
                                                        <div class="fw-semibold text-dark">{{ optional($unlock->officer)->name ?? 'Unknown Officer' }}</div>
                                                        <small class="text-muted">Bank Official</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border fw-medium px-2 py-1">
                                                            {{ $unlock->newLoanApplication?->id ? 'Req #' . $unlock->newLoanApplication->id : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-muted small">{{ optional($unlock->created_at)->format('d M, Y') }}</td>
                                                    <td class="pe-3 text-end">
                                                        <a href="{{ route('customer.new_application.officer_details', ['newApplication' => $unlock->newLoanApplication, 'officer' => $unlock->officer]) }}" class="btn btn-sm btn-primary shadow-sm rounded-pill px-3">
                                                            <i class="bi bi-star me-1"></i>Rate Now
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-4 text-center text-muted">
                                    <i class="bi bi-check-circle text-success opacity-50 display-6 d-block mb-2"></i>
                                    No pending officer ratings available at the moment.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
