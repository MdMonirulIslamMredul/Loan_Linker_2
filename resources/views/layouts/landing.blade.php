<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $logoSettings->site_name . ' - Find the Best Loan Offers in Bangladesh')</title>

    <!-- Favicon -->
    @if ($logoSettings->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $logoSettings->favicon) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @stack('styles')
</head>

<body class="bg-light" style="font-family: 'Inter', sans-serif;">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="/">
                    @if ($logoSettings->header_logo)
                        <img src="{{ asset('storage/' . $logoSettings->header_logo) }}"
                            alt="{{ $logoSettings->site_name }}" style="max-height: 40px;" class="me-2">
                    @else
                        <div class="bg-gradient bg-primary rounded d-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px;">
                            <span class="text-white fw-bold fs-5">LL</span>
                        </div>
                    @endif
                    <span class="fs-4 fw-bold">{{ $logoSettings->site_name }}</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="/">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('about') }}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('services') }}">Services</a>
                        </li>


                        {{-- <li class="nav-item">
                            <a class="nav-link fw-medium" href=  "{{ route('banks.all') }}">Banks</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href= "{{ route('loans.all') }}">Loans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href= "{{ route('contact') }}">Contact Us</a>
                        </li>

                        @auth
                            <li class="nav-item">
                                @php $role = auth()->user()->role; @endphp
                                @if ($role === 'customer')
                                    <a class="nav-link fw-medium" href="{{ url('customer/dashboard') }}">Dashboard</a>
                                @elseif ($role === 'super_admin')
                                    <a class="nav-link fw-medium" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
                                @elseif ($role === 'branch_admin')
                                    <a class="nav-link fw-medium"
                                        href="{{ route('branch-admin.dashboard') }}">Dashboard</a>
                                @elseif ($role === 'bank_admin')
                                    <a class="nav-link fw-medium" href="{{ route('bank-admin.dashboard') }}">Dashboard</a>
                                @else
                                    <a class="nav-link fw-medium" href="{{ url('/') }}">Dashboard</a>
                                @endif
                            </li>
                            <li class="nav-item ms-lg-2">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link fw-medium" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Get Started
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-5">
            <div class="row g-4">
                <!-- About -->
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        @if ($logoSettings->footer_logo)
                            <img src="{{ asset('storage/' . $logoSettings->footer_logo) }}"
                                alt="{{ $logoSettings->site_name }}" style="max-height: 40px;" class="me-2">
                        @else
                            <div class="bg-gradient bg-primary rounded d-flex align-items-center justify-content-center me-2"
                                style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold fs-5">LL</span>
                            </div>
                        @endif
                        <span class="fs-5 fw-bold text-white">{{ $logoSettings->site_name }}</span>
                    </div>
                    <p class="text-white-50">
                        Find and compare the best loan offers from all major banks in Bangladesh. Your trusted partner
                        for financial decisions.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-semibold mb-3 text-white">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/"
                                class="text-white-50 text-decoration-none hover-link">Home</a></li>
                        <li class="mb-2"><a href="{{ route('banks.all') }}"
                                class="text-white-50 text-decoration-none hover-link">All Banks</a></li>
                        <li class="mb-2"><a href="{{ route('loans.all') }}"
                                class="text-white-50 text-decoration-none hover-link">Browse Loans</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}"
                                class="text-white-50 text-decoration-none hover-link">About
                                Us</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q="
                                class="text-white-50 text-decoration-none hover-link">Search Loans</a></li>
                        {{-- <li class="mb-2"><a href="{{ route('login') }}" class="text-white-50 text-decoration-none hover-link">Login</a></li> --}}
                    </ul>
                </div>

                <!-- Loan Types -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-semibold mb-3 text-white">Loan Types</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('search') }}?q=personal"
                                class="text-white-50 text-decoration-none hover-link">Personal Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=home"
                                class="text-white-50 text-decoration-none hover-link">Home Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=car"
                                class="text-white-50 text-decoration-none hover-link">Car Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=business"
                                class="text-white-50 text-decoration-none hover-link">Business Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=education"
                                class="text-white-50 text-decoration-none hover-link">Education Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=sme"
                                class="text-white-50 text-decoration-none hover-link">SME Loans</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-semibold mb-3 text-white">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:{{ $aboutSettings->contact_email }}"
                                class="text-white-50 text-decoration-none hover-link">{{ $aboutSettings->contact_email }}</a>
                        </li>
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:{{ str_replace(' ', '', $aboutSettings->contact_phone) }}"
                                class="text-white-50 text-decoration-none hover-link">{{ $aboutSettings->contact_phone }}</a>
                        </li>
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-whatsapp me-2"></i>
                            <a href="https://wa.me/{{ $aboutSettings->contact_whatsapp }}"
                                class="text-white-50 text-decoration-none hover-link" target="_blank">WhatsApp
                                Support</a>
                        </li>
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-geo-alt me-2"></i>
                            {{ $aboutSettings->contact_address }}
                        </li>
                    </ul>
                    <div class="d-flex gap-3 mt-3">
                        @if ($aboutSettings->facebook_url)
                            <a href="{{ $aboutSettings->facebook_url }}" target="_blank"
                                class="text-white-50 hover-link" title="Facebook">
                                <i class="bi bi-facebook fs-5"></i>
                            </a>
                        @endif
                        @if ($aboutSettings->twitter_url)
                            <a href="{{ $aboutSettings->twitter_url }}" target="_blank"
                                class="text-white-50 hover-link" title="Twitter">
                                <i class="bi bi-twitter-x fs-5"></i>
                            </a>
                        @endif
                        @if ($aboutSettings->linkedin_url)
                            <a href="{{ $aboutSettings->linkedin_url }}" target="_blank"
                                class="text-white-50 hover-link" title="LinkedIn">
                                <i class="bi bi-linkedin fs-5"></i>
                            </a>
                        @endif
                        @if ($aboutSettings->instagram_url)
                            <a href="{{ $aboutSettings->instagram_url }}" target="_blank"
                                class="text-white-50 hover-link" title="Instagram">
                                <i class="bi bi-instagram fs-5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-top border-secondary mt-4 pt-4 text-center">
                <p class="mb-1 text-white-50">Loan Linker &copy; 2025. All Rights Reserved.</p>
                <p class="mb-0 text-white-50">
                    <a href="{{ route('search') }}?q=personal"
                        class="text-white-50 text-decoration-none hover-link">Personal Loan</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('search') }}?q=sme" class="text-white-50 text-decoration-none hover-link">SME
                        Loan</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('search') }}?q=credit-card"
                        class="text-white-50 text-decoration-none hover-link">Credit Card</a>
                    &nbsp;|&nbsp;
                    <a href="#" class="text-white-50 text-decoration-none hover-link">Bank Officer
                        Registration</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('pages.privacy_policy') }}"
                        class="text-white-50 text-decoration-none hover-link">Privacy Policy</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('pages.terms') }}" class="text-white-50 text-decoration-none hover-link">Terms
                        &amp; Conditions</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .hover-link {
            transition: all 0.3s ease;
        }

        .hover-link:hover {
            color: #ffffff !important;
            transform: translateX(3px);
        }

        footer a i:hover {
            color: #ffffff !important;
            transform: scale(1.2);
        }
    </style>

    @stack('scripts')
</body>

</html>
