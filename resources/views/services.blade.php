@extends('layouts.landing')

@section('title', 'Our Services - ' . ($logoSettings->site_name ?? 'Loan Linker'))

@section('content')
    <!-- Hero Section -->
    <section class="py-5 text-white text-center position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-10" style="pointer-events: none;"></div>
        <div class="container position-relative" style="padding-top: 60px; padding-bottom: 60px;">
            <h1 class="display-4 fw-bold mb-3">Our Services</h1>
            <p class="lead mb-0 mx-auto" style="max-width: 700px;">Connecting customers with verified banking professionals
                for hassle-free loan processing</p>
        </div>
    </section>

    <!-- Customer Services Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3">
                    <i class="bi bi-people me-2"></i>For Customers
                </span>
                <h2 class="display-5 fw-bold mb-3">Loan Services for Customers</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">We help customers find the best loan options
                    across multiple banks</p>
            </div>

            <div class="row g-4">
                <!-- Personal Loan -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-wallet2 text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Personal Loan</h4>
                            <p class="text-muted mb-0">Quick approval, minimal paperwork.</p>
                        </div>
                    </div>
                </div>

                <!-- SME Loan -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-briefcase text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-3">SME Loan</h4>
                            <p class="text-muted mb-0">Grow your business with flexible financing.</p>
                        </div>
                    </div>
                </div>

                <!-- Credit Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-credit-card text-info" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Credit Card</h4>
                            <p class="text-muted mb-0">Pick the right card based on your lifestyle.</p>
                        </div>
                    </div>
                </div>

                <!-- Auto/Car Loan -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-car-front text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Auto/Car Loan</h4>
                            <p class="text-muted mb-0">Finance your dream car with easy installments.</p>
                        </div>
                    </div>
                </div>

                <!-- Home Loan -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-house-door text-danger" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Home Loan</h4>
                            <p class="text-muted mb-0">Affordable housing finance from trusted banks.</p>
                        </div>
                    </div>
                </div>

                <!-- More Services -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-three-dots text-secondary" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-3">And More</h4>
                            <p class="text-muted mb-0">Explore various loan products tailored to your needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bank Officers Services Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 mb-3">
                    <i class="bi bi-building me-2"></i>For Bank Officers
                </span>
                <h2 class="display-5 fw-bold mb-3">Services for Bank Officers</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">Streamline your loan processing with our
                    comprehensive platform</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold mb-2">Verified Customer Leads</h5>
                                            <p class="text-muted small mb-0">Get access to pre-verified and genuine customer
                                                inquiries</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold mb-2">Pre-screened Loan Requests</h5>
                                            <p class="text-muted small mb-0">Save time with loan requests that are already
                                                filtered and ready</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold mb-2">Direct Contact Access</h5>
                                            <p class="text-muted small mb-0">Connect directly with customers after
                                                accepting
                                                their loan request</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold mb-2">Dashboard for Tracking</h5>
                                            <p class="text-muted small mb-0">Monitor your applications and reporting with
                                                our intuitive dashboard</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold mb-2">Priority Boost Options</h5>
                                            <p class="text-muted small mb-0">Increase your visibility with priority
                                                placement features</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold mb-2">Premium Visibility</h5>
                                            <p class="text-muted small mb-0">Stand out with premium listings and featured
                                                placement</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h2 class="display-6 fw-bold mb-3">Ready to Get Started?</h2>
            <p class="lead mb-4 mx-auto" style="max-width: 600px;">Whether you're looking for a loan or managing customer
                requests, we've got you covered</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('loans.all') }}" class="btn btn-light btn-lg shadow">
                    <i class="bi bi-search me-2"></i>Browse Loans
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Officer Login
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
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }
    </style>
@endpush
