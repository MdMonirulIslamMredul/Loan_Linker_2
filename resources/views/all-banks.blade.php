@extends('layouts.landing')

@section('title', 'All Banks - Loan Maker')

@section('content')
<!-- Header -->
<section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">All Partner Banks</h1>
        <p class="lead">Browse loan offers from Bangladesh's leading financial institutions</p>
    </div>
</section>

<!-- Banks Grid -->
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        @if($banks->count() > 0)
        <!-- Results Count -->
        <div class="mb-4">
            <p class="text-muted">
                Showing <span class="fw-semibold text-dark">{{ $banks->total() }}</span> bank(s)
            </p>
        </div>

        <!-- Banks Grid -->
        <div class="row g-4 mb-4">
            @foreach($banks as $bank)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border shadow-sm hover-lift">
                    @if($bank->banner)
                    <div class="position-relative bg-gradient" style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <img src="{{ asset($bank->banner) }}" class="card-img-top h-100 object-fit-cover" alt="{{ $bank->name }}">
                    </div>
                    @else
                    <div class="position-relative bg-gradient d-flex align-items-center justify-content-center" style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="bi bi-building display-1 text-white opacity-25"></i>
                    </div>
                    @endif

                    <div class="card-body text-center">
                        @if($bank->logo)
                        <div class="mb-3" style="margin-top: -60px;">
                            <img src="{{ asset($bank->logo) }}" alt="{{ $bank->name }}" class="rounded-circle bg-white p-2 shadow" style="width: 100px; height: 100px; object-fit: contain; border: 4px solid white;">
                        </div>
                        @endif

                        <h5 class="card-title fw-bold mb-2">{{ $bank->name }}</h5>
                        @if($bank->description)
                        <p class="card-text text-muted small" style="min-height: 60px;">{{ Str::limit($bank->description, 100) }}</p>
                        @else
                        <p class="card-text text-muted small" style="min-height: 60px;">-</p>
                        @endif

                        @php
                            $loanCount = $bank->branches->sum(function($branch) {
                                return $branch->loans->where('is_active', true)->count();
                            });
                        @endphp

                        <div class="d-flex justify-content-center gap-4 mb-3 small">
                            <div>
                                <div class="fs-4 fw-bold text-primary">{{ $bank->branches_count }}</div>
                                <div class="text-muted">Branches</div>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-primary">{{ $loanCount }}</div>
                                <div class="text-muted">Loan Offers</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('loans.all') }}?bank={{ $bank->id }}" class="btn btn-primary flex-fill">
                                <i class="bi bi-cash-stack me-1"></i>View Loans
                            </a>
                            @if($bank->website)
                            <a href="{{ $bank->website }}" target="_blank" class="btn btn-outline-secondary" title="Visit Website">
                                <i class="bi bi-globe"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($banks->hasPages())
        <div class="d-flex justify-content-center">
            {{ $banks->links() }}
        </div>
        @endif

        @else
        <!-- No Results -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-building display-1 text-muted"></i>
            </div>
            <h3 class="fw-bold mb-3">No Banks Found</h3>
            <p class="text-muted mb-4">We couldn't find any active banks at the moment.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-house me-2"></i>Back to Home
            </a>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
    <div class="container">
        <h2 class="display-6 fw-bold mb-3">Looking for Specific Loans?</h2>
        <p class="lead mb-4">Browse all available loan offers or search for what you need</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('loans.all') }}" class="btn btn-light btn-lg shadow">
                <i class="bi bi-grid-3x3-gap me-2"></i>View All Loans
            </a>
            <a href="{{ route('search') }}" class="btn btn-outline-light btn-lg">
                <i class="bi bi-search me-2"></i>Search Loans
            </a>
        </div>
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
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endpush
