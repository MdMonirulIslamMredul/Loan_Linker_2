@extends('layouts.landing')

@section('title', 'Loan Linker - Find the Best Loan Offers in Bangladesh')

@section('content')
    <!-- Hero Section with Banner Slider -->
    <section class="position-relative bg-primary text-white overflow-hidden"
        style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25" style="pointer-events: none;"></div>

        @if ($bannerLoans->count() > 0)
            <!-- Banner Slider -->
            <div class="position-relative">
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" style="height: 550px;">
                    <div class="carousel-inner h-100">
                        @foreach ($bannerLoans as $index => $loan)
                            <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}"
                                style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)), url('{{ asset($loan->banner) }}'); background-size: cover; background-position: center;">
                                <div class="container h-100">
                                    <div class="row h-100 align-items-center">
                                        <div class="col-lg-8">
                                            <span class="badge bg-info mb-3">{{ $loan->branch->bank->name }}</span>
                                            <small class="text-white-50 d-block mb-2">{{ $loan->branch->name }}
                                                Branch</small>
                                            <h1 class="display-3 fw-bold mb-4">{{ $loan->name }}</h1>
                                            <p class="lead mb-4">{{ Str::limit($loan->description, 100) }}</p>
                                            <div class="d-flex flex-wrap gap-3 mb-4">
                                                <div class="bg-white bg-opacity-25 backdrop-blur p-3 rounded">
                                                    <small class="d-block text-white-50">Interest Rate</small>
                                                    <h4 class="fw-bold mb-0">{{ $loan->interest_rate }}%</h4>
                                                </div>
                                                @if ($loan->min_amount && $loan->max_amount)
                                                    <div class="bg-white bg-opacity-25 backdrop-blur p-3 rounded">
                                                        <small class="d-block text-white-50">Amount Range</small>
                                                        <h6 class="fw-bold mb-0">৳{{ number_format($loan->min_amount) }} -
                                                            ৳{{ number_format($loan->max_amount) }}</h6>
                                                    </div>
                                                @endif
                                            </div>
                                            <a href="{{ route('loans.show', $loan) }}"
                                                class="btn btn-light btn-lg shadow position-relative"
                                                style="z-index: 10;">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($bannerLoans->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($bannerLoans as $index => $loan)
                                <button type="button" data-bs-target="#heroCarousel"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Default Hero -->
            <div class="container py-5 text-center" style="padding-top: 100px; padding-bottom: 100px;">
                <h1 class="display-2 fw-bold mb-4">Find Your Perfect Loan in Bangladesh</h1>
                <p class="lead mb-4 mx-auto" style="max-width: 700px;">Compare loan offers from all major banks and make
                    informed financial decisions</p>
            </div>
        @endif
    </section>

    <!-- Search Section -->
    <section class="bg-white py-4 shadow position-relative" style="margin-top: -50px; z-index: 100;">
        <div class="container">
            <form action="{{ route('search') }}" method="GET" class="mx-auto" style="max-width: 800px;">
                <div class="row g-3">
                    <div class="col-lg-9">
                        <input type="text" name="q" class="form-control form-control-lg"
                            placeholder="Search for loans by name..." required>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-2"></i>Search Loans
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mx-auto" style="max-width: 900px;">
                <h2 class="display-6 fw-bold mb-3" style="color: #4F46E5;">Loan Linker – Smart connection between customer
                    and bank</h2>
                <p class="lead text-muted">Get matched with verified bank officers for <span
                        class="fw-semibold text-dark">Credit Card</span>, <span class="fw-semibold text-dark">Personal
                        Loan</span>, <span class="fw-semibold text-dark">SME Loan</span>, <span
                        class="fw-semibold text-dark">Auto Loan</span>, <span class="fw-semibold text-dark">Home
                        Loan</span>, and more — fast, secure, commission-free.</p>
            </div>
        </div>
    </section>


    <!-- CTA Buttons -->
    <div class="container text-center my-4">
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('register.customer') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus-fill me-2"></i>Register as a Customer
            </a>
        </div>
    </div>





    <!-- Featured Loans Section -->
    @if ($featuredLoans->count() > 0)
        <section id="loans" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold mb-3">Featured Loan Offers</h2>
                    <p class="lead text-muted">Explore the latest and most popular loan options from top banks</p>
                </div>

                <!-- Desktop Carousel (3 cards per slide) -->
                <div id="loanCarouselDesktop" class="carousel slide d-none d-lg-block" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($featuredLoans->chunk(3) as $chunkIndex => $loanChunk)
                            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                <div class="row g-4">
                                    @foreach ($loanChunk as $loan)
                                        <div class="col-lg-4">
                                            <div class="card h-100 shadow-sm border-0 hover-lift">
                                                @if ($loan->banner)
                                                    <div class="position-relative"
                                                        style="height: 200px; overflow: hidden;">
                                                        <img src="{{ asset($loan->banner) }}"
                                                            class="card-img-top h-100 object-fit-cover"
                                                            alt="{{ $loan->name }}">
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
                                                                    style="width: 40px; height: 40px; object-fit: contain;"
                                                                    class="me-2">
                                                            @endif
                                                            <small
                                                                class="text-muted">{{ $loan->branch->bank->name }}</small>
                                                            <small class="text-muted">, {{ $loan->branch->name }}
                                                                Branch</small>
                                                        </div>
                                                    @endif

                                                    <h5 class="card-title fw-bold mb-2" style="min-height: 50px;">
                                                        {{ $loan->name }}</h5>
                                                    <p class="card-text text-muted" style="min-height: 60px;">
                                                        {{ Str::limit($loan->description, 100) }}</p>

                                                    <div class="row g-2 mb-3 small">
                                                        @if ($loan->min_amount && $loan->max_amount)
                                                            <div class="col-6">
                                                                <div class="text-muted">Amount Range</div>
                                                                <div class="fw-semibold">
                                                                    ৳{{ number_format($loan->min_amount / 1000) }}K -
                                                                    ৳{{ number_format($loan->max_amount / 1000) }}K</div>
                                                            </div>
                                                        @endif
                                                        @if ($loan->min_tenure_months && $loan->max_tenure_months)
                                                            <div class="col-6">
                                                                <div class="text-muted">Tenure</div>
                                                                <div class="fw-semibold">
                                                                    {{ $loan->min_tenure_months }}-{{ $loan->max_tenure_months }}
                                                                    months</div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <a href="{{ route('loans.show', $loan) }}"
                                                        class="btn btn-primary w-100">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($featuredLoans->count() > 3)
                        <button class="carousel-control-prev" type="button" data-bs-target="#loanCarouselDesktop"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#loanCarouselDesktop"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($featuredLoans->chunk(3) as $index => $chunk)
                                <button type="button" data-bs-target="#loanCarouselDesktop"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Mobile Carousel (1 card per slide) -->
                <div id="loanCarouselMobile" class="carousel slide d-lg-none" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($featuredLoans as $index => $loan)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="card shadow-sm border-0 hover-lift mx-auto" style="max-width: 500px;">
                                    @if ($loan->banner)
                                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                                            <img src="{{ asset($loan->banner) }}"
                                                class="card-img-top h-100 object-fit-cover" alt="{{ $loan->name }}">
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
                                                        style="width: 40px; height: 40px; object-fit: contain;"
                                                        class="me-2">
                                                @endif
                                                <small class="text-muted">{{ $loan->branch->bank->name }}</small>
                                            </div>
                                        @endif

                                        <h5 class="card-title fw-bold mb-2">{{ $loan->name }}</h5>

                                        @if ($loan->category)
                                            <div class="mb-2">
                                                <span class="badge bg-info text-dark"><i
                                                        class="bi bi-tag-fill me-1"></i>{{ $loan->category->name }}</span>
                                            </div>
                                        @endif

                                        <p class="card-text text-muted">{{ Str::limit($loan->description, 100) }}</p>

                                        <div class="row g-2 mb-3 small">
                                            @if ($loan->min_amount && $loan->max_amount)
                                                <div class="col-6">
                                                    <div class="text-muted">Amount Range</div>
                                                    <div class="fw-semibold">
                                                        ৳{{ number_format($loan->min_amount / 1000) }}K -
                                                        ৳{{ number_format($loan->max_amount / 1000) }}K</div>
                                                </div>
                                            @endif
                                            @if ($loan->min_tenure_months && $loan->max_tenure_months)
                                                <div class="col-6">
                                                    <div class="text-muted">Tenure</div>
                                                    <div class="fw-semibold">
                                                        {{ $loan->min_tenure_months }}-{{ $loan->max_tenure_months }}
                                                        months</div>
                                                </div>
                                            @endif
                                        </div>

                                        <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary w-100">View
                                            Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($featuredLoans->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#loanCarouselMobile"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#loanCarouselMobile"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($featuredLoans as $index => $loan)
                                <button type="button" data-bs-target="#loanCarouselMobile"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- View All Button -->
                <div class="text-center mt-5">
                    <a href="{{ route('loans.all') }}" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-grid-3x3-gap me-2"></i>View All Available Loans
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- All Banks Slider Section -->
    @if ($banks->count() > 0)
        <section id="banks" class="py-5 bg-white">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold mb-3">Partner Banks</h2>
                    <p class="lead text-muted">Browse loan offers from Bangladesh's leading financial institutions</p>
                </div>

                <!-- Desktop Carousel (3 cards per slide) -->
                <div id="bankCarouselDesktop" class="carousel slide d-none d-lg-block" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($banks->chunk(3) as $chunkIndex => $bankChunk)
                            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                <div class="row g-4 justify-content-center">
                                    @foreach ($bankChunk as $bank)
                                        <div class="col-lg-4">
                                            <div class="card h-100 border shadow-sm hover-lift">
                                                @if ($bank->banner)
                                                    <div class="position-relative bg-gradient"
                                                        style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                        <img src="{{ asset($bank->banner) }}"
                                                            class="card-img-top h-100 object-fit-cover"
                                                            alt="{{ $bank->name }}">
                                                    </div>
                                                @endif

                                                <div class="card-body text-center">
                                                    @if ($bank->logo)
                                                        <div class="mb-3" style="margin-top: -60px;">
                                                            <img src="{{ asset($bank->logo) }}"
                                                                alt="{{ $bank->name }}"
                                                                class="rounded-circle bg-white p-2 shadow"
                                                                style="width: 100px; height: 100px; object-fit: contain; border: 4px solid white;">
                                                        </div>
                                                    @endif

                                                    <h5 class="card-title fw-bold mb-2">{{ $bank->name }}</h5>
                                                    <p class="card-text text-muted small" style="min-height: 40px;">
                                                        {{ Str::limit($bank->description, 80) }}</p>

                                                    @php
                                                        $loanCount = $bank->branches->sum(function ($branch) {
                                                            return $branch->loans->where('is_active', true)->count();
                                                        });
                                                    @endphp

                                                    <div class="d-flex justify-content-center gap-4 mb-3 small">
                                                        <div>
                                                            <div class="fs-4 fw-bold text-primary">
                                                                {{ $bank->branches->count() }}</div>
                                                            <div class="text-muted">Branches</div>
                                                        </div>
                                                        <div>
                                                            <div class="fs-4 fw-bold text-primary">{{ $loanCount }}
                                                            </div>
                                                            <div class="text-muted">Loan Offers</div>
                                                        </div>
                                                    </div>

                                                    <a href="{{ route('search') }}?q={{ urlencode($bank->name) }}"
                                                        class="btn btn-primary">View Loans</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($banks->count() > 3)
                        <button class="carousel-control-prev" type="button" data-bs-target="#bankCarouselDesktop"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#bankCarouselDesktop"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($banks->chunk(3) as $index => $chunk)
                                <button type="button" data-bs-target="#bankCarouselDesktop"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Mobile Carousel (1 card per slide) -->
                <div id="bankCarouselMobile" class="carousel slide d-lg-none" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($banks as $index => $bank)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="card border shadow-sm hover-lift mx-auto" style="max-width: 500px;">
                                    @if ($bank->banner)
                                        <div class="position-relative bg-gradient"
                                            style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <img src="{{ asset($bank->banner) }}"
                                                class="card-img-top h-100 object-fit-cover" alt="{{ $bank->name }}">
                                        </div>
                                    @endif

                                    <div class="card-body text-center">
                                        @if ($bank->logo)
                                            <div class="mb-3" style="margin-top: -60px;">
                                                <img src="{{ asset($bank->logo) }}" alt="{{ $bank->name }}"
                                                    class="rounded-circle bg-white p-2 shadow"
                                                    style="width: 100px; height: 100px; object-fit: contain; border: 4px solid white;">
                                            </div>
                                        @endif

                                        <h5 class="card-title fw-bold mb-2">{{ $bank->name }}</h5>
                                        <p class="card-text text-muted small" style="min-height: 40px;">
                                            {{ Str::limit($bank->description, 80) }}</p>

                                        @php
                                            $loanCount = $bank->branches->sum(function ($branch) {
                                                return $branch->loans->where('is_active', true)->count();
                                            });
                                        @endphp

                                        <div class="d-flex justify-content-center gap-4 mb-3 small">
                                            <div>
                                                <div class="fs-4 fw-bold text-primary">{{ $bank->branches->count() }}
                                                </div>
                                                <div class="text-muted">Branches</div>
                                            </div>
                                            <div>
                                                <div class="fs-4 fw-bold text-primary">{{ $loanCount }}</div>
                                                <div class="text-muted">Loan Offers</div>
                                            </div>
                                        </div>

                                        <a href="{{ route('search') }}?q={{ urlencode($bank->name) }}"
                                            class="btn btn-primary">View Loans</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($banks->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#bankCarouselMobile"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#bankCarouselMobile"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($banks as $index => $bank)
                                <button type="button" data-bs-target="#bankCarouselMobile"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- View All Banks Button -->
                <div class="text-center mt-5">
                    <a href="{{ route('banks.all') }}" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-building me-2"></i>All Bank List
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Why Choose Us Section -->
    <section id="about" class="py-5" style="background: linear-gradient(135deg, #E0F2FE 0%, #EDE9FE 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Why Choose Loan Linker?</h2>
                <p class="lead text-muted mx-auto" style="max-width: 800px;">Loan Linker connects customers with verified
                    banking professionals to ensure safe, transparent, and hassle-free loan processing.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-check-circle-fill text-success fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-2">100% Commission Free</h5>
                            <p class="text-muted small">No brokers. No middlemen.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-rocket-takeoff text-primary fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Faster Loan Approval</h5>
                            <p class="text-muted small">Get matched with authorized officers.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-buildings text-info fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Multiple Banks. One Platform.</h5>
                            <p class="text-muted small">Compare offers and choose the best deal.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-shield-check text-warning fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Secure Data Protection</h5>
                            <p class="text-muted small">Your personal information stays hidden until a verified officer
                                accepts your request.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @if ($testimonials->count() > 0)
        <section class="py-5 position-relative overflow-hidden"
            style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <!-- Background Decorations -->
            <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.05;">
                <div class="position-absolute"
                    style="top: 10%; left: 5%; width: 300px; height: 300px; background: radial-gradient(circle, #0d6efd 0%, transparent 70%);">
                </div>
                <div class="position-absolute"
                    style="bottom: 10%; right: 5%; width: 400px; height: 400px; background: radial-gradient(circle, #7C3AED 0%, transparent 70%);">
                </div>
            </div>

            <div class="container position-relative">
                <div class="text-center mb-5">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3">
                        <i class="bi bi-chat-heart me-2"></i>Testimonials
                    </span>
                    <h2 class="display-5 fw-bold mb-3">What Our Customers Say</h2>
                    <p class="lead text-muted mx-auto" style="max-width: 600px;">Real experiences from people who found
                        their perfect loan through our platform</p>
                </div>

                <!-- Desktop Carousel (3 cards per slide, sliding 1 by 1) -->
                <div id="testimonialCarouselDesktop" class="carousel slide d-none d-lg-block" data-bs-ride="carousel"
                    data-bs-interval="3000" data-bs-wrap="true">
                    <div class="carousel-inner">
                        @foreach ($testimonials as $index => $testimonial)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row g-4">
                                    @for ($i = 0; $i < 3; $i++)
                                        @php
                                            $currentIndex = ($index + $i) % $testimonials->count();
                                            $currentTestimonial = $testimonials[$currentIndex];
                                        @endphp
                                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                                            <div class="testimonial-card h-100 position-relative">
                                                <!-- Gradient Border -->
                                                <div class="gradient-border"></div>

                                                <!-- Card Content -->
                                                <div class="card-content bg-white h-100 p-4 rounded-4 position-relative">
                                                    <!-- Quote Icon -->
                                                    <div class="position-absolute" style="top: -15px; right: 20px;">
                                                        <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="bi bi-quote text-white fs-4"></i>
                                                        </div>
                                                    </div>

                                                    <!-- Rating Stars -->
                                                    <div class="mb-3">
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    </div>

                                                    <!-- Message -->
                                                    <p class="mb-4 text-secondary fst-italic"
                                                        style="font-size: 1.05rem; line-height: 1.7;">
                                                        "{{ $currentTestimonial->message }}"
                                                    </p>

                                                    <!-- Author Info -->
                                                    <div class="d-flex align-items-center mt-auto pt-3 border-top">
                                                        <div class="avatar-gradient me-3">
                                                            <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center"
                                                                style="width: 55px; height: 55px;">
                                                                <span
                                                                    class="text-white fw-bold fs-5">{{ substr($currentTestimonial->name, 0, 1) }}</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold text-dark">
                                                                {{ $currentTestimonial->name }}</h6>
                                                            <small class="text-muted d-flex align-items-center">
                                                                @if ($currentTestimonial->role)
                                                                    <i class="bi bi-briefcase me-1"
                                                                        style="font-size: 0.75rem;"></i>
                                                                    <span>{{ $currentTestimonial->role }}</span>
                                                                @endif
                                                                @if ($currentTestimonial->location && $currentTestimonial->role)
                                                                    <span class="mx-1">•</span>
                                                                @endif
                                                                @if ($currentTestimonial->location)
                                                                    <i class="bi bi-geo-alt me-1"
                                                                        style="font-size: 0.75rem;"></i>
                                                                    <span>{{ $currentTestimonial->location }}</span>
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($testimonials->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarouselDesktop"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarouselDesktop"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($testimonials as $index => $testimonial)
                                <button type="button" data-bs-target="#testimonialCarouselDesktop"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Mobile Carousel (1 card per slide) -->
                <div id="testimonialCarouselMobile" class="carousel slide d-lg-none" data-bs-ride="carousel"
                    data-bs-interval="3000" data-bs-wrap="true">
                    <div class="carousel-inner">
                        @foreach ($testimonials as $index => $testimonial)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="testimonial-card h-100 position-relative mx-auto" style="max-width: 500px;">
                                    <!-- Gradient Border -->
                                    <div class="gradient-border"></div>

                                    <!-- Card Content -->
                                    <div class="card-content bg-white h-100 p-4 rounded-4 position-relative">
                                        <!-- Quote Icon -->
                                        <div class="position-absolute" style="top: -15px; right: 20px;">
                                            <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-quote text-white fs-4"></i>
                                            </div>
                                        </div>

                                        <!-- Rating Stars -->
                                        <div class="mb-3">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </div>

                                        <!-- Message -->
                                        <p class="mb-4 text-secondary fst-italic"
                                            style="font-size: 1.05rem; line-height: 1.7;">
                                            "{{ $testimonial->message }}"
                                        </p>

                                        <!-- Author Info -->
                                        <div class="d-flex align-items-center mt-auto pt-3 border-top">
                                            <div class="avatar-gradient me-3">
                                                <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 55px; height: 55px;">
                                                    <span
                                                        class="text-white fw-bold fs-5">{{ substr($testimonial->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $testimonial->name }}</h6>
                                                <small class="text-muted d-flex align-items-center">
                                                    @if ($testimonial->role)
                                                        <i class="bi bi-briefcase me-1" style="font-size: 0.75rem;"></i>
                                                        <span>{{ $testimonial->role }}</span>
                                                    @endif
                                                    @if ($testimonial->location && $testimonial->role)
                                                        <span class="mx-1">•</span>
                                                    @endif
                                                    @if ($testimonial->location)
                                                        <i class="bi bi-geo-alt me-1" style="font-size: 0.75rem;"></i>
                                                        <span>{{ $testimonial->location }}</span>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($testimonials->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarouselMobile"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarouselMobile"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($testimonials as $index => $testimonial)
                                <button type="button" data-bs-target="#testimonialCarouselMobile"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Add more testimonials hint if there are many -->
                @if ($testimonials->count() >= 6)
                    <div class="text-center mt-5">
                        <p class="text-muted mb-0">
                            <i class="bi bi-people-fill me-2"></i>Join thousands of satisfied customers
                        </p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h2 class="display-5 fw-bold mb-3">Ready to Find Your Perfect Loan?</h2>
            <p class="lead mb-4 mx-auto" style="max-width: 600px;">Start comparing loan offers from Bangladesh's top banks
                today</p>
            <a href="{{ route('loans.all') }}" class="btn btn-light btn-lg shadow">Browse All Loans</a>
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

        .backdrop-blur {
            backdrop-filter: blur(10px);
        }

        /* Modern Testimonial Styles */
        .testimonial-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
        }

        .testimonial-card .gradient-border {
            position: absolute;
            inset: 0;
            border-radius: 1.5rem;
            padding: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .testimonial-card:hover .gradient-border {
            opacity: 1;
        }

        .testimonial-card .card-content {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .testimonial-card:hover .card-content {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .avatar-gradient .bg-gradient-primary {
            position: relative;
            overflow: hidden;
        }

        .avatar-gradient .bg-gradient-primary::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .rounded-4 {
            border-radius: 1.5rem !important;
        }

        /* Fade up animation */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        [data-aos="fade-up"] {
            animation: fadeUp 0.8s ease-out forwards;
        }

        [data-aos-delay="100"] {
            animation-delay: 0.1s;
        }

        [data-aos-delay="200"] {
            animation-delay: 0.2s;
        }

        [data-aos-delay="300"] {
            animation-delay: 0.3s;
        }

        /* Smooth Carousel Transitions */
        #testimonialCarouselDesktop .carousel-item,
        #testimonialCarouselMobile .carousel-item {
            transition: transform 0.8s ease-in-out;
        }

        #testimonialCarouselDesktop .carousel-inner,
        #testimonialCarouselMobile .carousel-inner {
            overflow: visible;
        }

        /* Pause auto-slide on hover */
        #testimonialCarouselDesktop:hover,
        #testimonialCarouselMobile:hover {
            animation-play-state: paused;
        }
    </style>
@endpush
