<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - Customer' : 'Customer Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
        }

        .customer-layout {
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-width: 260px;
            background: #ffffff;
            position: sticky;
            top: 1rem;
            align-self: flex-start;
            max-height: calc(100vh - 4.5rem);
        }

        .sidebar .nav-link {
            color: #374151;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #ffffff;
            background: #0d6efd;
        }

        .sidebar .section-label {
            letter-spacing: 0.12em;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
        }

        .page-header {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .page-header .page-title {
            margin-bottom: 0.25rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .offcanvas-body {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .ms-lg-260 {
            margin-left: 10px !important;
        }

        .sidebar-toggle-btn {
            position: fixed;
            top: 3rem;
            left: 1rem;
            z-index: 1055;
            width: 44px;
            height: 44px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.16);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
                min-width: auto;
            }

            .ms-lg-260 {
                margin-left: 0 !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    @auth
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
        @csrf
    </form>
    @endauth

    <!-- Landing Header -->
    <header class="bg-white shadow-sm sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
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

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

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
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('loan-categories.index') }}">Loans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('contact') }}">Contact Us</a>
                        </li>

                       

                        @auth
                        <li class="nav-item">
                            @php
                            $role = auth()->user()->role;
                            $avatar = auth()->user()->profile_photo ?? auth()->user()->avatar ?? auth()->user()->image ?? null;
                            @endphp
                            @if ($role === 'customer')
                            <a class="nav-link fw-medium" href="{{ url('customer/dashboard') }}">Dashboard</a>
                            @elseif ($role === 'super_admin')
                            <a class="nav-link fw-medium" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
                            @elseif ($role === 'branch_admin')
                            <a class="nav-link fw-medium" href="{{ route('branch-admin.dashboard') }}">Dashboard</a>
                            @elseif ($role === 'bank_admin')
                            <a class="nav-link fw-medium" href="{{ route('bank-admin.dashboard') }}">Dashboard</a>
                            @else
                            <a class="nav-link fw-medium" href="{{ url('/') }}">Dashboard</a>
                            @endif
                        </li>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link d-flex align-items-center gap-2 dropdown-toggle" href="#" id="customerNavDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if ($avatar)
                                <img src="{{ asset('storage/' . $avatar) }}" alt="{{ auth()->user()->name }}"
                                    class="rounded-circle" style="width: 34px; height: 34px; object-fit: cover;">
                                @else
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white"
                                    style="width: 34px; height: 34px;">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                @endif
                                <span>{{ auth()->user()->name ?? 'Account' }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="customerNavDropdown">
                                <li><a class="dropdown-item" href="{{ route('customer.profile') }}">My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.profile.password.edit') }}">Change Password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <button class="dropdown-item text-danger" type="submit" form="logout-form">Logout</button>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                        </li>
                        @endauth

                            <li class="nav-item ms-lg-2">
                                <a href="{{ route('customer.new_application.create') }}"  class="btn btn-primary"> Apply For Loan </a>
                            </li>
                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="customer-layout d-flex flex-column">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="customerSidebar"
            aria-labelledby="customerSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="customerSidebarLabel">Customer Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <nav class="nav flex-column gap-2">
                    <div>
                        <p class="section-label mb-2">Main</p>
                        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
                            href="{{ route('customer.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('chat.*') ? 'active' : '' }}"
                            href="{{ route('chat.index') }}">
                            <span><i class="bi bi-chat-dots me-2"></i>Chat</span>
                            @php
                            $unreadChatCount = \App\Models\Message::where('is_seen', false)
                            ->where('sender_id', '!=', auth()->id())
                            ->whereHas('conversation', function ($query) {
                            $query->where('user_one_id', auth()->id())
                            ->orWhere('user_two_id', auth()->id());
                            })->count();
                            @endphp
                            @if($unreadChatCount > 0)
                            <span class="badge bg-danger rounded-pill">{{ $unreadChatCount }}</span>
                            @endif
                        </a>
                        <a class="nav-link {{ request()->routeIs('customer.applications') ? 'active' : '' }}"
                            href="{{ route('customer.applications') }}"><i class="bi bi-file-earmark-text me-2"></i>My Applications</a>
                        <a class="nav-link {{ request()->routeIs('customer.documents') ? 'active' : '' }}"
                            href="{{ route('customer.documents') }}"><i class="bi bi-folder2-open me-2"></i>Documents</a>
                        <a class="nav-link {{ request()->routeIs('customer.financial') ? 'active' : '' }}"
                            href="{{ route('customer.financial') }}"><i class="bi bi-currency-dollar me-2"></i>Financial</a>
                        <a class="nav-link {{ request()->routeIs('customer.ratings') ? 'active' : '' }}"
                            href="{{ route('customer.ratings') }}"><i class="bi bi-star me-2"></i>My Ratings</a>
                    </div>
                    <div class="mt-4">
                        <p class="section-label mb-2">Profile</p>
                        <a class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}"
                            href="{{ route('customer.profile') }}"><i class="bi bi-person me-2"></i>View Profile</a>
                        <a class="nav-link {{ request()->routeIs('customer.profile.edit') ? 'active' : '' }}"
                            href="{{ route('customer.profile.edit') }}"><i class="bi bi-pencil-square me-2"></i>Edit Profile</a>
                        <a class="nav-link {{ request()->routeIs('customer.profile.password.edit') ? 'active' : '' }}"
                            href="{{ route('customer.profile.password.edit') }}"><i class="bi bi-shield-lock me-2"></i>Change Password</a>

                        <a class="nav-link" href="{{ route('logout')  }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>


                    </div>
                </nav>
            </div>
        </div>

        <div class="d-lg-flex flex-grow-1">
            <button class="btn btn-primary sidebar-toggle-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#customerSidebar" aria-controls="customerSidebar" aria-label="Open customer menu">
                <i class="bi bi-list"></i>
            </button>
            <aside
                class="sidebar d-none d-lg-flex flex-column border-end p-4 overflow-auto card rounded-3 shadow-sm">


                <nav class="nav flex-column gap-2">
                    <p class="section-label mb-2">Main</p>
                    <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
                        href="{{ route('customer.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('chat.*') ? 'active' : '' }}"
                        href="{{ route('chat.index') }}">
                        <span><i class="bi bi-chat-dots me-2"></i>Chat</span>
                        @php
                        $unreadChatCount = \App\Models\Message::where('is_seen', false)
                        ->where('sender_id', '!=', auth()->id())
                        ->whereHas('conversation', function ($query) {
                        $query->where('user_one_id', auth()->id())
                        ->orWhere('user_two_id', auth()->id());
                        })->count();
                        @endphp
                        @if($unreadChatCount > 0)
                        <span class="badge bg-danger rounded-pill">{{ $unreadChatCount }}</span>
                        @endif
                    </a>
                    <a class="nav-link {{ request()->routeIs('customer.applications') ? 'active' : '' }}"
                        href="{{ route('customer.applications') }}"><i class="bi bi-file-earmark-text me-2"></i>My Applications</a>
                    <a class="nav-link {{ request()->routeIs('customer.documents') ? 'active' : '' }}"
                        href="{{ route('customer.documents') }}"><i class="bi bi-folder2-open me-2"></i>Documents</a>
                    <a class="nav-link {{ request()->routeIs('customer.financial') ? 'active' : '' }}"
                        href="{{ route('customer.financial') }}"><i class="bi bi-currency-dollar me-2"></i>Financial</a>
                    <a class="nav-link {{ request()->routeIs('customer.ratings') ? 'active' : '' }}"
                        href="{{ route('customer.ratings') }}"><i class="bi bi-star me-2"></i>My Ratings</a>

                    <div class="mt-5 pt-4 border-top">
                        <p class="section-label mb-2">Profile</p>
                        <a class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}"
                            href="{{ route('customer.profile') }}"><i class="bi bi-person me-2"></i>Profile</a>
                        <a class="nav-link {{ request()->routeIs('customer.profile.edit') ? 'active' : '' }}"
                            href="{{ route('customer.profile.edit') }}"><i class="bi bi-pencil-square me-2"></i>Edit Profile</a>
                        <a class="nav-link {{ request()->routeIs('customer.profile.password.edit') ? 'active' : '' }}"
                            href="{{ route('customer.profile.password.edit') }}"><i class="bi bi-shield-lock me-2"></i>Change Password</a>
                        <a class="nav-link" href="{{ route('logout')  }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </div>
                </nav>
            </aside>

            <main class="flex-grow-1 ms-lg-10 px-3 px-lg-4 py-4">


                {{-- Main content placeholder: customer view content will be injected here --}}
                @yield('customer-content')
            </main>
        </div>
    </div>

    <!-- Landing Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-5">
            <div class="row g-4">
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

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-semibold mb-3 text-white">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('banks.all') }}"
                                class="text-white-50 text-decoration-none">All Banks</a></li>
                        <li class="mb-2"><a href="{{ route('loans.all') }}"
                                class="text-white-50 text-decoration-none">Browse Loans</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}"
                                class="text-white-50 text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q="
                                class="text-white-50 text-decoration-none">Search Loans</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-semibold mb-3 text-white">Loan Types</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('search') }}?q=personal"
                                class="text-white-50 text-decoration-none">Personal Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=home"
                                class="text-white-50 text-decoration-none">Home Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=car"
                                class="text-white-50 text-decoration-none">Car Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=business"
                                class="text-white-50 text-decoration-none">Business Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=education"
                                class="text-white-50 text-decoration-none">Education Loans</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}?q=sme"
                                class="text-white-50 text-decoration-none">SME Loans</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-semibold mb-3 text-white">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:{{ $aboutSettings->contact_email }}"
                                class="text-white-50 text-decoration-none">{{ $aboutSettings->contact_email }}</a>
                        </li>
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:{{ str_replace(' ', '', $aboutSettings->contact_phone) }}"
                                class="text-white-50 text-decoration-none">{{ $aboutSettings->contact_phone }}</a>
                        </li>
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-whatsapp me-2"></i>
                            <a href="https://wa.me/{{ $aboutSettings->contact_whatsapp }}"
                                class="text-white-50 text-decoration-none" target="_blank">WhatsApp Support</a>
                        </li>
                        <li class="mb-2 text-white-50">
                            <i class="bi bi-geo-alt me-2"></i>
                            {{ $aboutSettings->contact_address }}
                        </li>
                    </ul>
                    <div class="d-flex gap-3 mt-3">
                        @if ($aboutSettings->facebook_url)
                        <a href="{{ $aboutSettings->facebook_url }}" target="_blank"
                            class="text-white-50 text-decoration-none" title="Facebook">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        @endif
                        @if ($aboutSettings->twitter_url)
                        <a href="{{ $aboutSettings->twitter_url }}" target="_blank"
                            class="text-white-50 text-decoration-none" title="Twitter">
                            <i class="bi bi-twitter-x fs-5"></i>
                        </a>
                        @endif
                        @if ($aboutSettings->linkedin_url)
                        <a href="{{ $aboutSettings->linkedin_url }}" target="_blank"
                            class="text-white-50 text-decoration-none" title="LinkedIn">
                            <i class="bi bi-linkedin fs-5"></i>
                        </a>
                        @endif
                        @if ($aboutSettings->instagram_url)
                        <a href="{{ $aboutSettings->instagram_url }}" target="_blank"
                            class="text-white-50 text-decoration-none" title="Instagram">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-top border-secondary mt-4 pt-4 text-center">
                <p class="mb-1 text-white-50">Loan Linker &copy; 2025. All Rights Reserved.</p>
                <p class="mb-0 text-white-50">
                    <a href="{{ route('search') }}?q=personal" class="text-white-50 text-decoration-none">Personal Loan</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('search') }}?q=sme" class="text-white-50 text-decoration-none">SME Loan</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('search') }}?q=credit-card" class="text-white-50 text-decoration-none">Credit Card</a>
                    &nbsp;|&nbsp;
                    <a href="#" class="text-white-50 text-decoration-none">Bank Officer Registration</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('pages.privacy_policy') }}"
                        class="text-white-50 text-decoration-none">Privacy Policy</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('pages.terms') }}" class="text-white-50 text-decoration-none">Terms &amp; Conditions</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>