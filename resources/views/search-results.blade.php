@extends('layouts.landing')

@section('title', 'Search Results - ' . $query . ' - Loan Maker')

@section('content')
    <!-- Search Header -->
    <section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Search Results</h1>
            <p class="lead">Showing results for: <span class="fw-semibold">"{{ $query }}"</span></p>
        </div>
    </section>

    <!-- Search Bar -->
    <section class="bg-white py-3 shadow-sm sticky-top" style="top: 80px; z-index: 40;">
        <div class="container">
            <form action="{{ route('search') }}" method="GET" class="mx-auto" style="max-width: 800px;">
                <div class="row g-3">
                    <div class="col-lg-9">
                        <input type="text" name="q" value="{{ $query }}"
                            class="form-control form-control-lg" placeholder="Search for loans by name..." required>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Search Results -->
    <section class="py-5 bg-light min-vh-100">
        <div class="container">
            @if ($loans->count() > 0)
                <div class="mb-4">
                    <p class="text-muted">Found <span class="fw-semibold text-dark">{{ $loans->total() }}</span> loan(s)
                        matching your search</p>
                </div>

                <div class="row g-4 mb-4">
                    @foreach ($loans as $loan)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-lift">
                                @if ($loan->banner)
                                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                                        <img src="{{ asset($loan->banner) }}" class="card-img-top h-100 object-fit-cover"
                                            alt="{{ $loan->name }}">
                                        <span
                                            class="position-absolute top-0 end-0 m-3 badge bg-primary fs-6">{{ $loan->interest_rate }}%
                                            APR</span>
                                    </div>
                                @else
                                    <div class="position-relative d-flex align-items-center justify-content-center bg-gradient"
                                        style="height: 200px; background: linear-gradient(135deg, #E0F2FE 0%, #DDD6FE 100%);">
                                        <i class="bi bi-cash-coin text-primary" style="font-size: 4rem; opacity: 0.3;"></i>
                                        <span
                                            class="position-absolute top-0 end-0 m-3 badge bg-primary fs-6">{{ $loan->interest_rate }}%
                                            APR</span>
                                    </div>
                                @endif

                                <div class="card-body">
                                    @if ($loan->branch && $loan->branch->bank)
                                        <div class="d-flex align-items-center mb-3">
                                            @if ($loan->branch->bank->logo)
                                                <img src="{{ asset($loan->branch->bank->logo) }}"
                                                    alt="{{ $loan->branch->bank->name }}"
                                                    style="width: 40px; height: 40px; object-fit: contain;" class="me-2">
                                            @endif
                                            <div>
                                                <small class="text-muted d-block">{{ $loan->branch->bank->name }}</small>
                                                <small class="text-muted"
                                                    style="font-size: 0.75rem;">{{ $loan->branch->name }}</small>
                                            </div>
                                        </div>
                                    @endif

                                    <h5 class="card-title fw-bold mb-2" style="min-height: 50px;">{{ $loan->name }}</h5>

                                    @if ($loan->category)
                                        <div class="mb-2">
                                            <span class="badge bg-info text-dark"><i
                                                    class="bi bi-tag-fill me-1"></i>{{ $loan->category->name }}</span>
                                        </div>
                                    @endif

                                    <p class="card-text text-muted" style="min-height: 60px;">
                                        {{ Str::limit($loan->description, 100) }}</p>

                                    <div class="row g-2 mb-3 small">
                                        @if ($loan->min_amount && $loan->max_amount)
                                            <div class="col-6">
                                                <div class="text-muted">Amount Range</div>
                                                <div class="fw-semibold">৳{{ number_format($loan->min_amount / 1000) }}K -
                                                    ৳{{ number_format($loan->max_amount / 1000) }}K</div>
                                            </div>
                                        @endif
                                        @if ($loan->min_tenure_months && $loan->max_tenure_months)
                                            <div class="col-6">
                                                <div class="text-muted">Tenure</div>
                                                <div class="fw-semibold">
                                                    {{ $loan->min_tenure_months }}-{{ $loan->max_tenure_months }} months
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary flex-fill">View
                                            Details</a>
                                        <a href="#" class="btn btn-outline-secondary">
                                            <i class="bi bi-share"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $loans->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown text-muted" style="font-size: 6rem;"></i>
                    <h2 class="display-6 fw-bold mt-4 mb-3">No Results Found</h2>
                    <p class="lead text-muted mb-4 mx-auto" style="max-width: 500px;">
                        We couldn't find any loans matching "{{ $query }}". Try different keywords or browse all
                        loans.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="/" class="btn btn-primary btn-lg">
                            <i class="bi bi-house-door me-2"></i>Back to Home
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-list me-2"></i>Browse All Loans
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>
@endpush
