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
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            color: #1f2937;
            font-size: 1.35rem;
            transition: background 0.2s ease;
        }

        .sidebar-toggle-btn:hover,
        .sidebar-toggle-btn:focus {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            outline: none;
        }

        /* ── Mobile Navbar Collapse ───────────────────────────── */
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

            /* User profile card */
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

            /* Nav links */
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

            /* Section divider */
            .mobile-nav-divider {
                height: 1px;
                background: #e5e9f0;
                margin: 0.4rem 1.25rem;
            }

            /* CTA button */
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

            /* Dropdown in mobile */
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

        /* Compact pagination for customer pages */
        .pagination {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            margin-bottom: 0;
            font-size: 0.88rem;
        }

        .pagination li,
        .pagination .page-item {
            white-space: nowrap;
        }

        .pagination a,
        .pagination span,
        .pagination .page-link {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: auto !important;
            padding: 0.35rem 0.75rem !important;
            min-width: 2.2rem;
            line-height: 1.2;
        }

        .pagination .page-item:first-child a,
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child a,
        .pagination .page-item:last-child .page-link {
            border-radius: 0.35rem;
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
    @if (isset($logoSettings) && $logoSettings->favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $logoSettings->favicon) }}">
    @endif
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
                {{-- Mobile sidebar toggle: shown only on small screens, left of brand --}}
                <button class="sidebar-toggle-btn d-lg-none me-2" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#customerSidebar"
                    aria-controls="customerSidebar" aria-label="Open customer menu">
                    <i class="bi bi-list"></i>
                </button>
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

                <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    @auth
                    @php
                    $navUser = auth()->user();
                    $navAvatar = match ($navUser->role) {
                        'customer' => $navUser->customerDocument?->picture ?? null,
                        'branch_admin', 'bank_admin' => $navUser->officerDocument?->picture ?? null,
                        default => null
                    } ?? $navUser->profile_photo ?? $navUser->avatar ?? $navUser->image ?? null;
                    if ($navAvatar && !preg_match('/^(https?:)?\/\//i', $navAvatar)) {
                    $navAvatar = asset('storage/' . ltrim(preg_replace('#^(public/|storage/)#i', '', $navAvatar), '/'));
                    }
                    @endphp
                    @if ($navAvatar)
                    <img src="{{ $navAvatar }}" alt="{{ $navUser->name }}"
                        class="rounded-circle border border-2 border-primary"
                        style="width: 36px; height: 36px; object-fit: cover;">
                    @else
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                        style="width: 36px; height: 36px; font-size: 1.1rem;">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    @endif
                    @else
                    <i class="bi bi-list fs-2"></i>
                    @endauth
                </button>

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
                    if ($avatar && !preg_match('/^(https?:)?\/\//i', $avatar)) {
                    $avatar = asset('storage/' . ltrim(preg_replace('#^(public/|storage/)#i', '', $avatar), '/'));
                    }
                    @endphp

                    {{-- Mobile user profile card (hidden on desktop) --}}
                    <!-- <div class="mobile-user-card d-lg-none">
                        @if ($avatar)
                            <img src="{{ $avatar }}" alt="{{ $user->name }}"
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

                        {{-- Main nav links --}}
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
                                <i class="bi bi-bank d-lg-none"></i> Loans
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
                                id="customerNavDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if ($avatar)
                                <img src="{{ $avatar }}" alt="{{ $user->name }}"
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
                                    <button class="dropdown-item text-danger" type="submit" form="logout-form">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </li>
                            </ul>
                        </li>

                        @else
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right d-lg-none"></i> Login
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                        </li>
                        @endauth

                        {{-- Apply For Loan CTA --}}
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

    <!-- Floating EMI Calculator Button -->
    @if(!request()->routeIs('chat.*'))
    <a href="#" id="floatingEmiButton" class="floating-emi-btn" title="EMI Calculator">
        <img src="{{ asset('images/emi-calculator-icon.png') }}" alt="EMI Calculator" class="emi-btn-image">
    </a>
    @endif

    <style>
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
                            const firstInput = calculatorSection.querySelector('input[type="number"]');
                            if (firstInput) {
                                firstInput.focus();
                            }
                        }, 500);
                    } else {
                        // If not on home page, navigate to home with hash
                        window.location.href = '{{ url("/") }}#calculator';
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>