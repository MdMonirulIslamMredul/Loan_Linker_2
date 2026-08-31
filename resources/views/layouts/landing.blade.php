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

    <style>
        /* ── Navbar Toggler (hamburger box) ──────────────────── */
        .landing-toggler {
            width: 48px;
            height: 48px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #d1d5db !important;
            border-radius: 10px !important;
            background: #ffffff;
            color: #374151;
            font-size: 1.6rem;
            line-height: 1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .landing-toggler:hover,
        .landing-toggler:focus {
            border-color: #0d6efd !important;
            background: #f0f5ff;
            color: #0d6efd;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
            outline: none;
        }

        .landing-toggler .bi-list {
            font-size: 1.7rem;
            line-height: 1;
        }

        /* ── Mobile Navbar Collapse ─────────────────────────── */
        @media (max-width: 991.98px) {
            #navbarNav {
                background: #ffffff;
                border-top: 1px solid #e5e9f0;
                border-radius: 0 0 1rem 1rem;
                box-shadow: 0 12px 32px rgba(13, 71, 161, 0.10);
                padding: 0 0 1rem 0;
                margin-top: 0.25rem;
                animation: slideDown 0.22s ease;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-8px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .mobile-user-card {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1rem 1.25rem;
                background: linear-gradient(135deg, #0d6efd11 0%, #6366f108 100%);
                border-bottom: 1px solid #e5e9f0;
                margin-bottom: 0.5rem;
            }

            .mobile-user-card .user-meta h6 {
                margin: 0;
                font-size: 0.92rem;
                font-weight: 700;
                color: #1f2937;
                line-height: 1.3;
            }

            .mobile-user-card .user-meta span {
                font-size: 0.75rem;
                color: #6b7280;
            }

            #navbarNav .navbar-nav .nav-link {
                padding: 0.6rem 1.25rem;
                font-weight: 500;
                color: #374151;
                border-radius: 0.5rem;
                margin: 0 0.5rem;
                transition: background 0.18s ease, color 0.18s ease;
                display: flex;
                align-items: center;
                gap: 0.6rem;
                justify-content: center;
            }

            #navbarNav .navbar-nav .nav-link:hover {
                background: #f0f5ff;
                color: #0d6efd;
            }

            #navbarNav .navbar-nav .nav-link.active {
                background: #0d6efd;
                color: #fff;
            }

            .mobile-nav-divider {
                height: 1px;
                background: #e5e9f0;
                margin: 0.4rem 1.25rem;
            }

            .mobile-cta-btn {
                display: block;
                margin: 0.75rem 1rem 0.25rem;
                padding: 0.7rem 1rem;
                background: linear-gradient(135deg, #0d6efd, #6366f1);
                color: #fff !important;
                font-weight: 600;
                border-radius: 0.6rem;
                text-align: center;
                text-decoration: none;
                font-size: 0.92rem;
                transition: opacity 0.2s ease, transform 0.2s ease;
                box-shadow: 0 4px 14px rgba(13, 110, 253, 0.3);
            }

            .mobile-cta-btn:hover {
                opacity: 0.92;
                transform: translateY(-1px);
            }

            #navbarNav .dropdown-menu {
                border: none;
                box-shadow: none;
                background: #f8fafc;
                border-radius: 0.5rem;
                padding: 0.25rem 0;
                margin: 0 0.5rem;
            }

            #navbarNav .dropdown-item {
                padding: 0.55rem 1.25rem;
                font-size: 0.875rem;
                color: #374151;
                border-radius: 0.4rem;
                transition: background 0.15s;
            }

            #navbarNav .dropdown-item:hover {
                background: #e8f0fe;
                color: #0d6efd;
            }
        }
    </style>

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
                @auth
                @php
                    $toggleUser = auth()->user();
                    $toggleAvatar = match ($toggleUser->role) {
                        'customer' => $toggleUser->customerDocument?->picture ?? null,
                        'branch_admin', 'bank_admin' => $toggleUser->officerDocument?->picture ?? null,
                        default => null
                    } ?? $toggleUser->profile_photo ?? $toggleUser->avatar ?? $toggleUser->image ?? null;
                    if ($toggleAvatar && !preg_match('/^(https?:)?\/\//i', $toggleAvatar)) {
                        $toggleAvatar = asset('storage/' . ltrim(preg_replace('#^(public/|storage/)#i', '', $toggleAvatar), '/'));
                    }
                @endphp
                <button class="navbar-toggler landing-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    @if ($toggleAvatar)
                        <img src="{{ $toggleAvatar }}" alt="{{ $toggleUser->name }}"
                            class="rounded-circle"
                            style="width: 34px; height: 34px; object-fit: cover;">
                    @else
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                            style="width: 34px; height: 34px; font-size: 1.1rem;">
                            <i class="bi bi-person-fill"></i>
                        </span>
                    @endif
                </button>
                @else
                <button class="navbar-toggler landing-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>
                @endauth

                <!-- Navigation -->
                <div class="collapse navbar-collapse" id="navbarNav">

                    @auth
                    @php
                    $user = auth()->user();
                    $role = $user->role;
                    $avatar = match ($role) {
                        'customer' => $user->customerDocument?->picture ?? null,
                        'branch_admin', 'bank_admin' => $user->officerDocument?->picture ?? null,
                        default => null
                    } ?? $user->profile_photo ?? $user->avatar ?? $user->image ?? null;
                    $avatarUrl = null;
                    if ($avatar) {
                    if (preg_match('/^(https?:)?\/\//i', $avatar)) {
                    $avatarUrl = $avatar;
                    } else {
                    $avatarUrl = asset('storage/' . ltrim(preg_replace('#^(public/|storage/)#i', '', $avatar), '/'));
                    }
                    }
                    @endphp

                    {{-- Mobile user profile card (hidden on desktop) --}}
                    <!-- <div class="mobile-user-card d-lg-none">
                        @if ($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $user->name }}"
                                class="rounded-circle border border-2 border-primary flex-shrink-0"
                                style="width: 46px; height: 46px; object-fit: cover;">
                        @else
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white flex-shrink-0"
                                style="width: 46px; height: 46px; font-size: 1.3rem;">
                                <i class="bi bi-person-fill"></i>
                            </span>
                        @endif
                        <div class="user-meta">
                            <h6>{{ $user->name }}</h6>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div> -->
                    @endauth

                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->is('/') ? 'active' : '' }}" href="/">
                                <i class="bi bi-house d-lg-none"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('about') }}">
                                <i class="bi bi-info-circle d-lg-none"></i> About Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('services') }}">
                                <i class="bi bi-grid d-lg-none"></i> Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('loan-categories.index') }}">
                                <i class="bi bi-bank d-lg-none"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('contact') }}">
                                <i class="bi bi-envelope d-lg-none"></i> Contact Us
                            </a>
                        </li>

                        @auth
                        {{-- Divider (mobile only) --}}
                        <li class="d-lg-none w-100">
                            <div class="mobile-nav-divider"></div>
                        </li>

                        <li class="nav-item">
                            @if ($role === 'customer')
                            <a class="nav-link fw-medium" href="{{ url('customer/dashboard') }}">
                                <i class="bi bi-speedometer2 d-lg-none"></i> Dashboard
                            </a>
                            @elseif (in_array($role, ['super_admin', 'admin', 'operations_head', 'marketing_head', 'hr_head', 'compliance_officer']))
                            <a class="nav-link fw-medium" href="{{ route('super-admin.dashboard') }}">
                                <i class="bi bi-speedometer2 d-lg-none"></i> Dashboard
                            </a>
                            @elseif ($role === 'branch_admin')
                            <a class="nav-link fw-medium" href="{{ route('branch-admin.dashboard') }}">
                                <i class="bi bi-speedometer2 d-lg-none"></i> Dashboard
                            </a>
                            @elseif ($role === 'bank_admin')
                            <a class="nav-link fw-medium" href="{{ route('bank-admin.dashboard') }}">
                                <i class="bi bi-speedometer2 d-lg-none"></i> Dashboard
                            </a>
                            @else
                            <a class="nav-link fw-medium" href="{{ url('/') }}">
                                <i class="bi bi-speedometer2 d-lg-none"></i> Dashboard
                            </a>
                            @endif
                        </li>

                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link d-flex align-items-center gap-2 dropdown-toggle" href="#"
                                id="customerNavDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}"
                                    class="rounded-circle" style="width: 34px; height: 34px; object-fit: cover;">
                                @else
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white"
                                    style="width: 34px; height: 34px;">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                @endif
                                <span>{{ $user->name ?? 'Account' }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="customerNavDropdown">
                                @if (in_array($role, ['super_admin', 'admin', 'operations_head', 'marketing_head', 'hr_head', 'compliance_officer']))
                                    <li><a class="dropdown-item" href="{{ route('super-admin.profile.password.edit') }}"><i class="bi bi-shield-lock me-2 text-primary"></i>Change Password</a></li>
                                @elseif ($role === 'branch_admin')
                                    <li><a class="dropdown-item" href="{{ route('branch-admin.profile') }}"><i class="bi bi-person me-2 text-primary"></i>My Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('branch-admin.profile.edit') }}"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('branch-admin.profile.password.edit') }}"><i class="bi bi-shield-lock me-2 text-primary"></i>Change Password</a></li>
                                @elseif ($role === 'customer')
                                    <li><a class="dropdown-item" href="{{ route('customer.profile') }}"><i class="bi bi-person me-2 text-primary"></i>My Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('customer.profile.password.edit') }}"><i class="bi bi-shield-lock me-2 text-primary"></i>Change Password</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                        @else
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right d-lg-none"></i> Login
                            </a>
                        </li>
                        @endauth

                        {{-- Apply For Loan CTA (desktop) --}}
                        <li class="nav-item ms-lg-2 d-lg-block d-none">
                            <a href="{{ route('customer.new_application.create') }}" class="btn btn-primary">Apply For Loan</a>
                        </li>
                    </ul>

                    {{-- Mobile CTA full-width button --}}
                    <div class="d-lg-none">
                        <a href="{{ route('customer.new_application.create') }}" class="mobile-cta-btn">
                            <i class="bi bi-file-earmark-plus me-2"></i>Apply For Loan
                        </a>
                    </div>

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
                <div class="col-lg-4 col-md-6">
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
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-semibold mb-3 text-white">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/"
                                class="text-white-50 text-decoration-none hover-link">Home</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}"
                                class="text-white-50 text-decoration-none hover-link">About
                                Us</a></li>
                        <li class="mb-2"><a href="{{ route('register.customer') }}"
                                class="text-white-50 text-decoration-none hover-link">Register as Customer</a></li>
                        <li class="mb-2"><a href="{{ route('register.bank_officer') }}"
                                class="text-white-50 text-decoration-none hover-link">Register as Bank Officer</a></li>
                        <li class="mb-2"><a href="{{ route('pages.privacy_policy') }}"
                                class="text-white-50 text-decoration-none hover-link">Privacy Policy</a></li>
                        <li class="mb-2"><a href="{{ route('pages.customer_rights') }}"
                                class="text-white-50 text-decoration-none hover-link">Customer Rights &amp;
                                Responsibilities</a></li>
                        <li class="mb-2"><a href="{{ route('pages.bank_officer_code') }}"
                                class="text-white-50 text-decoration-none hover-link">Bank Officer Code of Conduct</a>
                        </li>
                        <li class="mb-2"><a href="{{ route('pages.terms') }}"
                                class="text-white-50 text-decoration-none hover-link">Terms & Conditions</a></li>

                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-4 col-md-6">
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
                        @if ($aboutSettings->youtube_url)
                        <a href="{{ $aboutSettings->youtube_url }}" target="_blank"
                            class="text-white-50 hover-link" title="YouTube">
                            <i class="bi bi-youtube fs-5"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-top border-secondary mt-4 pt-4 text-center">
                <p class="mb-1 text-white-50">Loan Linker &copy; 2026. All Rights Reserved.</p>
                <p class="mb-0 text-white-50">

                    <a href="{{ route('contact') }}" class="text-white-50 text-decoration-none hover-link">Contact
                        Us</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('register.bank_officer') }}"
                        class="text-white-50 text-decoration-none hover-link">Bank Officer
                        Registration</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('pages.privacy_policy') }}"
                        class="text-white-50 text-decoration-none hover-link">Privacy Policy</a>
                    {{-- &nbsp;|&nbsp;
                    <a href="{{ route('pages.customer_rights') }}"
                    class="text-white-50 text-decoration-none hover-link">Customer Rights &amp;
                    Responsibilities</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('pages.bank_officer_code') }}"
                        class="text-white-50 text-decoration-none hover-link">Bank Officer Code of Conduct</a> --}}
                    &nbsp;|&nbsp;
                    <a href="{{ route('pages.terms') }}" class="text-white-50 text-decoration-none hover-link">Terms
                        &amp; Conditions</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Floating EMI Calculator Button -->
    <a href="#" id="floatingEmiButton" class="floating-emi-btn" title="EMI Calculator">
        <img src="{{ asset('images/emi-calculator-icon.png') }}" alt="EMI Calculator" class="emi-btn-image">
    </a>

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

        /* Floating EMI Button Styles */
        .floating-emi-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            background: rgba(0, 0, 0, 0.25);
            border: 2.5px solid rgba(255, 215, 0, 0.6);
            backdrop-filter: blur(12px);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            z-index: 999;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .floating-emi-btn:hover {
            transform: scale(1.1);
            background: rgba(0, 0, 0, 0.35);
            border-color: rgba(255, 215, 0, 0.8);
            box-shadow: 0 12px 32px rgba(255, 215, 0, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.15);
            color: white;
        }

        .floating-emi-btn:active {
            transform: scale(0.95);
        }

        /* Tooltip */
        .floating-emi-btn::after {
            content: 'EMI Calculator';
            position: absolute;
            bottom: 85px;
            right: 0;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            font-weight: 500;
        }

        .floating-emi-btn:hover::after {
            opacity: 1;
        }

        /* Mobile View */
        @media (max-width: 768px) {
            .floating-emi-btn {
                bottom: 20px;
                right: 20px;
                width: 65px;
                height: 65px;
                font-size: 24px;
            }

            .floating-emi-btn::after {
                font-size: 11px;
                padding: 6px 10px;
                bottom: 80px;
            }
        }

        /* Hide on very small screens if needed */
        @media (max-width: 480px) {
            .floating-emi-btn {
                bottom: 15px;
                right: 15px;
                width: 60px;
                height: 60px;
                font-size: 20px;
            }
        }

        /* Animation on page load */
        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating-emi-btn {
            animation: slideInFromBottom 0.5s ease-out;
        }

        /* EMI Button Image Styling */
        .emi-btn-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const floatingBtn = document.getElementById('floatingEmiButton');

            if (floatingBtn) {
                floatingBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Check if calculator section exists on current page
                    const calculatorSection = document.getElementById('calculator');

                    if (calculatorSection) {
                        // Smooth scroll to the EMI calculator section
                        calculatorSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                        // Optional: Focus on the first input for better UX
                        setTimeout(() => {
                            const firstInput = calculatorSection.querySelector(
                                'input[type="number"]');
                            if (firstInput) {
                                firstInput.focus();
                            }
                        }, 500);
                    } else {
                        // If not on home page, navigate to home with hash
                        window.location.href = '{{ url(' / ') }}#calculator';
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>