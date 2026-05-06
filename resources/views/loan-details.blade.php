@extends('layouts.landing')

@section('title', $loan->name . ' - Loan Details')

@section('content')
    <!-- Loan Banner -->
    @if ($loan->banner)
        <section class="position-relative text-white"
            style="height: 400px; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('{{ asset($loan->banner) }}'); background-size: cover; background-position: center;">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-lg-8">
                        @if ($loan->branch && $loan->branch->bank)
                            <div class="d-flex align-items-center mb-3">
                                @if ($loan->branch->bank->logo)
                                    <img src="{{ asset($loan->branch->bank->logo) }}" alt="{{ $loan->branch->bank->name }}"
                                        style="width: 60px; height: 60px; object-fit: contain;"
                                        class="bg-white rounded p-2 me-3">
                                @endif
                                <div>
                                    <span class="badge bg-info mb-1">{{ $loan->branch->bank->name }}</span>
                                    <div class="text-white-50 small">{{ $loan->branch->name }}</div>
                                </div>
                            </div>
                        @endif
                        <h1 class="display-4 fw-bold mb-3">{{ $loan->name }}</h1>
                        @if ($loan->category)
                            <div class="mb-3">
                                <span class="badge bg-warning text-dark fs-6"><i
                                        class="bi bi-tag-fill me-1"></i>{{ $loan->category->name }}</span>
                            </div>
                        @endif
                        <p class="lead">{{ $loan->description }}</p>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
            <div class="container py-5">
                @if ($loan->branch && $loan->branch->bank)
                    <div class="d-flex align-items-center mb-3">
                        @if ($loan->branch->bank->logo)
                            <img src="{{ asset($loan->branch->bank->logo) }}" alt="{{ $loan->branch->bank->name }}"
                                style="width: 60px; height: 60px; object-fit: contain;" class="bg-white rounded p-2 me-3">
                        @endif
                        <div>
                            <span class="badge bg-info mb-1">{{ $loan->branch->bank->name }}</span>
                            <div class="text-white-50 small">{{ $loan->branch->name }}</div>
                        </div>
                    </div>
                @endif
                <h1 class="display-4 fw-bold mb-3">{{ $loan->name }}</h1>
                @if ($loan->category)
                    <div class="mb-3">
                        <span class="badge bg-warning text-dark fs-6"><i
                                class="bi bi-tag-fill me-1"></i>{{ $loan->category->name }}</span>
                    </div>
                @endif
                <p class="lead">{{ $loan->description }}</p>
            </div>
        </section>
    @endif

    <!-- Key Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Interest Rate -->
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-percent text-primary fs-1"></i>
                            </div>
                            <h6 class="text-muted mb-2">Interest Rate</h6>
                            <h3 class="fw-bold text-primary">{{ $loan->interest_rate }}%</h3>
                            <small class="text-muted">Per Annum</small>
                        </div>
                    </div>
                </div>

                <!-- Loan Amount -->
                @if ($loan->min_amount && $loan->max_amount)
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="bi bi-currency-dollar text-success fs-1"></i>
                                </div>
                                <h6 class="text-muted mb-2">Loan Amount</h6>
                                <h5 class="fw-bold text-success">৳{{ number_format($loan->min_amount) }}</h5>
                                <small class="text-muted">to</small>
                                <h5 class="fw-bold text-success">৳{{ number_format($loan->max_amount) }}</h5>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tenure -->
                @if ($loan->min_tenure_months && $loan->max_tenure_months)
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="bi bi-calendar-range text-info fs-1"></i>
                                </div>
                                <h6 class="text-muted mb-2">Loan Tenure</h6>
                                <h5 class="fw-bold text-info">{{ $loan->min_tenure_months }} -
                                    {{ $loan->max_tenure_months }}</h5>
                                <small class="text-muted">Months</small>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Processing Fee -->
                @if ($loan->processing_fee)
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="bi bi-receipt text-warning fs-1"></i>
                                </div>
                                <h6 class="text-muted mb-2">Processing Fee</h6>
                                <h3 class="fw-bold text-warning">{{ $loan->processing_fee }}%</h3>
                                <small class="text-muted">Of Loan Amount</small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Detailed Information -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Main Details -->
                <div class="col-lg-8">
                    <!-- Features -->
                    @if ($loan->features)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h4 class="fw-bold mb-4">
                                    <i class="bi bi-star text-primary me-2"></i>Key Features
                                </h4>
                                <div class="text-muted" style="white-space: pre-line;">{{ $loan->features }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Details Sections -->
                    @if ($loan->details1)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-info-circle text-primary me-2"></i>Details
                                </h5>
                                <div class="text-muted" style="white-space: pre-line;">{{ $loan->details1 }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($loan->details2)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-file-text text-primary me-2"></i>Additional Information
                                </h5>
                                <div class="text-muted" style="white-space: pre-line;">{{ $loan->details2 }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($loan->details3)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="text-muted" style="white-space: pre-line;">{{ $loan->details3 }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($loan->details4)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="text-muted" style="white-space: pre-line;">{{ $loan->details4 }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Eligibility -->
                    @if ($loan->eligibility)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-person-check text-success me-2"></i>Eligibility Criteria
                                </h5>
                                <div class="text-muted" style="white-space: pre-line;">{{ $loan->eligibility }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Documents Required -->
                    @if ($loan->documents_required)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-file-earmark-text text-info me-2"></i>Documents Required
                                </h5>
                                <div class="text-muted" style="white-space: pre-line;">{{ $loan->documents_required }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>



                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Bank Information -->
                    @if ($loan->branch && $loan->branch->bank)
                        <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-4">Bank Information</h5>

                                @if ($loan->branch->bank->logo)
                                    <div class="text-center mb-4">
                                        <img src="{{ asset($loan->branch->bank->logo) }}"
                                            alt="{{ $loan->branch->bank->name }}" class="img-fluid"
                                            style="max-height: 80px; object-fit: contain;">
                                    </div>
                                @endif

                                <h6 class="fw-bold">{{ $loan->branch->bank->name }}</h6>
                                @if ($loan->branch->bank->description)
                                    <p class="text-muted small mb-3">{{ $loan->branch->bank->description }}</p>
                                @endif

                                <hr>

                                <h6 class="fw-bold mb-2">Branch</h6>
                                <p class="text-muted mb-1">{{ $loan->branch->name }}</p>
                                @if ($loan->branch->address)
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $loan->branch->address }}
                                    </p>
                                @endif
                                @if ($loan->branch->phone)
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-telephone me-1"></i>{{ $loan->branch->phone }}
                                    </p>
                                @endif
                                @if ($loan->branch->email)
                                    <p class="text-muted small">
                                        <i class="bi bi-envelope me-1"></i>{{ $loan->branch->email }}
                                    </p>
                                @endif

                                <hr>

                                <div class="d-grid gap-2">
                                    <a href="{{ route('loans.apply', $loan) }}" class="btn btn-success btn-lg mb-3">
                                        <i class="bi bi-file-text me-2"></i>Apply for This Loan
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Home
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>




    <!-- Related Loans (Optional - can be implemented later) -->
    <!-- CTA Section -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h2 class="display-6 fw-bold mb-3">Looking for More Options?</h2>
            <p class="lead mb-4">Explore other loan offers from Bangladesh's top banks</p>
            <a href="{{ route('home') }}" class="btn btn-light btn-lg shadow">Browse All Loans</a>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .object-fit-cover {
            object-fit: cover;
        }

        @media (min-width: 992px) {
            .sticky-top {
                position: sticky !important;
            }
        }
    </style>
@endpush
