@extends('layouts.landing')

@section('title', 'About Us - ' . $logoSettings->site_name)

@section('content')
    <!-- Hero Section -->
    <section class="position-relative bg-primary text-white overflow-hidden"
        style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25" style="pointer-events: none;"></div>
        <div class="container py-5 text-center position-relative" style="padding-top: 100px; padding-bottom: 100px;">
            <h1 class="display-3 fw-bold mb-4">About Us</h1>
            <p class="lead mb-0 mx-auto" style="max-width: 700px;">Learn more about our mission, vision, and commitment to
                helping you find the best loan offers</p>
        </div>
    </section>

    <!-- Who We Are Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 70px; height: 70px;">
                        <i class="bi bi-building text-primary fs-1"></i>
                    </div>
                    <h2 class="display-5 fw-bold mb-4">Who We Are</h2>
                    <p class="text-muted fs-5" style="line-height: 1.8;">
                        {{ $settings->who_we_are }}
                    </p>
                </div>
                {{-- <div class="col-lg-6">
                    <div class="position-relative">
                        <div class="bg-gradient rounded-4 shadow-lg p-5 text-white"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="row g-4 text-center">
                                <div class="col-6">
                                    <h3 class="display-4 fw-bold mb-2">500+</h3>
                                    <p class="mb-0">Loan Options</p>
                                </div>
                                <div class="col-6">
                                    <h3 class="display-4 fw-bold mb-2">50+</h3>
                                    <p class="mb-0">Partner Banks</p>
                                </div>
                                <div class="col-6">
                                    <h3 class="display-4 fw-bold mb-2">10K+</h3>
                                    <p class="mb-0">Happy Users</p>
                                </div>
                                <div class="col-6">
                                    <h3 class="display-4 fw-bold mb-2">24/7</h3>
                                    <p class="mb-0">Support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                <!-- Vision -->
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body p-4 p-lg-5">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-eye text-success fs-1"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Our Vision</h3>
                            <p class="text-muted fs-5" style="line-height: 1.8;">
                                {{ $settings->our_vision }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body p-4 p-lg-5">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-bullseye text-info fs-1"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Our Mission</h3>
                            <p class="text-muted fs-5" style="line-height: 1.8;">
                                {{ $settings->our_mission }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Believe Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #E0F2FE 0%, #EDE9FE 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 70px; height: 70px;">
                    <i class="bi bi-heart text-warning fs-1"></i>
                </div>
                <h2 class="display-5 fw-bold mb-3">What We Believe</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5 text-center">
                            <p class="text-muted fs-5 mb-0" style="line-height: 1.8;">
                                {{ $settings->what_we_believe }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Get In Touch</h2>
                <p class="lead text-muted">We're here to help you find the perfect loan</p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Email -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm hover-lift">
                        <div class="card-body p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-envelope text-primary fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Email Us</h5>
                            <a href="mailto:{{ $settings->contact_email }}"
                                class="text-muted text-decoration-none">{{ $settings->contact_email }}</a>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm hover-lift">
                        <div class="card-body p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-telephone text-success fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Call Us</h5>
                            <a href="tel:{{ str_replace(' ', '', $settings->contact_phone) }}"
                                class="text-muted text-decoration-none">{{ $settings->contact_phone }}</a>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm hover-lift">
                        <div class="card-body p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-whatsapp text-success fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">WhatsApp</h5>
                            <a href="https://wa.me/{{ $settings->contact_whatsapp }}" target="_blank"
                                class="text-muted text-decoration-none">Chat with us</a>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center border-0 shadow-sm hover-lift">
                        <div class="card-body p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-geo-alt text-warning fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Visit Us</h5>
                            <p class="text-muted mb-0">{{ $settings->contact_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h2 class="display-5 fw-bold mb-3">Ready to Find Your Perfect Loan?</h2>
            <p class="lead mb-4 mx-auto" style="max-width: 600px;">Start comparing loan offers from Bangladesh's top banks
                today</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('loans.all') }}" class="btn btn-light btn-lg shadow">Browse All Loans</a>
                <a href="{{ route('search') }}" class="btn btn-outline-light btn-lg">Search Loans</a>
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

        .rounded-4 {
            border-radius: 1.5rem !important;
        }
    </style>
@endpush
