@extends('layouts.landing')

@section('title', $category->name . ' Loans - Loan Linker')

@section('content')
    <!-- Category Header -->
    <section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">{{ $category->name }} Loans</h1>
            <p class="lead mb-0">
                {{ $category->description ?? 'Explore relevant loan options in this category from top banks across Bangladesh.' }}
            </p>
            @if($category->long_description)
                <p class="mt-3 mb-0">{{ $category->long_description }}</p>
            @endif
        </div>
    </section>

    <!-- Category Loans -->
    <section class="py-5 bg-light min-vh-100">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <p class="text-muted mb-1">Showing <span class="fw-semibold text-dark">{{ $loans->total() }}</span> loan(s) in <strong>{{ $category->name }}</strong></p>
                    <p class="text-muted mb-0">Browse the most suitable options and compare features, interest rates, and bank details.</p>
                </div>
                <a href="{{ route('loans.all') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Browse All Loans
                </a>
            </div>

            @if ($loans->count() > 0)
                <div class="row g-4 mb-4">
                    @foreach ($loans as $loan)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-lift">
                                @if ($loan->banner)
                                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                                        <img src="{{ asset($loan->banner) }}" class="card-img-top h-100 object-fit-cover"
                                            alt="{{ $loan->name }}">
                                        <span class="position-absolute top-0 end-0 m-3 badge bg-primary fs-6">{{ $loan->interest_rate }}% APR</span>
                                    </div>
                                @else
                                    <div class="position-relative d-flex align-items-center justify-content-center bg-gradient"
                                        style="height: 200px; background: linear-gradient(135deg, #E0F2FE 0%, #DDD6FE 100%);">
                                        <div class="text-center">
                                            <i class="bi bi-cash-coin display-1 text-primary opacity-25"></i>
                                        </div>
                                        <span class="position-absolute top-0 end-0 m-3 badge bg-primary fs-6">{{ $loan->interest_rate }}% APR</span>
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
                                            <small class="text-muted">{{ $loan->branch->bank->name }} , {{ $loan->branch->name }} Branch</small>
                                        </div>
                                    @endif

                                    <h5 class="card-title fw-bold mb-2" style="min-height: 50px;">{{ $loan->name }}</h5>

                                    <p class="card-text text-muted" style="min-height: 60px;">{{ Str::limit($loan->description, 100) }}</p>

                                    <div class="row g-2 mb-3 small">
                                        @if ($loan->min_amount && $loan->max_amount)
                                            <div class="col-6">
                                                <div class="text-muted">Amount Range</div>
                                                <div class="fw-semibold">৳{{ number_format($loan->min_amount / 1000) }}K - ৳{{ number_format($loan->max_amount / 1000) }}K</div>
                                            </div>
                                        @endif
                                        @if ($loan->min_tenure_months && $loan->max_tenure_months)
                                            <div class="col-6">
                                                <div class="text-muted">Tenure</div>
                                                <div class="fw-semibold">{{ $loan->min_tenure_months }}-{{ $loan->max_tenure_months }} months</div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary flex-fill">View Details</a>
                                        <a href="#" class="btn btn-outline-secondary">
                                            <i class="bi bi-share"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($loans->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $loans->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                    </div>
                    <h3 class="fw-bold mb-3">No loans found in this category</h3>
                    <p class="text-muted mb-4">Try browsing other loan categories or search for an offer that fits your needs.</p>
                    <a href="{{ route('loans.all') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Browse All Loans
                    </a>
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
