<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: #ffffff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #495057;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu .menu-item:hover {
            background: #f8f9fa;
            color: #0d6efd;
            border-left-color: #0d6efd;
        }

        .sidebar-menu .menu-item.active {
            background: #e7f1ff;
            color: #0d6efd;
            border-left-color: #0d6efd;
            font-weight: 600;
        }

        .sidebar-menu .menu-item i {
            width: 20px;
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .sidebar-menu .submenu .menu-item {
            padding-left: 2.25rem;
            border-left: none;
        }

        .sidebar-menu .menu-item.d-flex .bi-chevron-down {
            margin-left: auto;
            font-size: 0.95rem;
            transform: translateX(6px);
            transition: transform 0.15s ease;
        }

        .sidebar-menu .menu-item>span {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .menu-section-title {
            padding: 1rem 1.5rem 0.5rem;
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .top-navbar {
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: inline-block;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-light">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        @php
            $logoSettings = \App\Models\LogoSetting::settings();
            $headerLogo = $logoSettings->header_logo;
            $siteName = $logoSettings->site_name ?? 'Admin Panel';
        @endphp

        <div class="sidebar-header d-flex align-items-center gap-2">
            @if ($headerLogo)
                <img src="{{ asset('storage/' . $headerLogo) }}" alt="{{ $siteName }}"
                    style="height:44px; width:auto; object-fit:contain; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.06);" />
                <div>
                    <h5 class="mb-0">{{ $siteName }}</h5>
                    <small class="opacity-75">{{ auth()->user()->name }}</small>
                </div>
            @else
                <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>{{ $siteName }}</h5>
                <small class="opacity-75">{{ auth()->user()->name }}</small>
            @endif
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('super-admin.dashboard') }}"
                class="menu-item {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            {{-- <div class="menu-section-title">Banks Management</div> --}}
            @php
                $banksActive =
                    request()->routeIs('super-admin.banks.*') || request()->routeIs('super-admin.bank-admins.*');
            @endphp
            <a href="#banksMenu" class="menu-item d-flex align-items-center {{ $banksActive ? 'active' : '' }}"
                data-bs-toggle="collapse" role="button" aria-expanded="{{ $banksActive ? 'true' : 'false' }}"
                aria-controls="banksMenu">
                <span>
                    <i class="bi bi-building"></i>
                    <span>Banks Management</span>
                </span>
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse submenu {{ $banksActive ? 'show' : '' }}" id="banksMenu">
                <a href="{{ route('super-admin.banks.create') }}"
                    class="menu-item {{ request()->routeIs('super-admin.banks.create') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Create Bank</span>
                </a>
                <a href="{{ route('super-admin.banks.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.banks.index') ? 'active' : '' }}">
                    <i class="bi bi-bank"></i>
                    <span>View All Banks</span>
                </a>
                <a href="{{ route('super-admin.bank-admins.create') }}"
                    class="menu-item {{ request()->routeIs('super-admin.bank-admins.create') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Create Bank Admin</span>
                </a>
                <a href="{{ route('super-admin.bank-admins.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.bank-admins.index') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>View Bank Admins</span>
                </a>
            </div>

            @php
                $branchesActive =
                    request()->routeIs('super-admin.branches.*') || request()->routeIs('super-admin.branch-admins.*');
            @endphp
            {{-- <div class="menu-section-title">Branches Management</div> --}}
            <a href="#branchesMenu" class="menu-item d-flex align-items-center {{ $branchesActive ? 'active' : '' }}"
                data-bs-toggle="collapse" role="button" aria-expanded="{{ $branchesActive ? 'true' : 'false' }}"
                aria-controls="branchesMenu">
                <span>
                    <i class="bi bi-shop"></i>
                    <span>Branches Management</span>
                </span>
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse submenu {{ $branchesActive ? 'show' : '' }}" id="branchesMenu">
                <a href="{{ route('super-admin.branches.create') }}"
                    class="menu-item {{ request()->routeIs('super-admin.branches.create') ? 'active' : '' }}">
                    <i class="bi bi-shop"></i>
                    <span>Create Branch</span>
                </a>
                <a href="{{ route('super-admin.branches.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.branches.index') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i>
                    <span>View All Branches</span>
                </a>
                <a href="{{ route('super-admin.branch-admins.create') }}"
                    class="menu-item {{ request()->routeIs('super-admin.branch-admins.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus"></i>
                    <span>Create Branch Officer</span>
                </a>
                <a href="{{ route('super-admin.branch-admins.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.branch-admins.index') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>View Branch Officers</span>
                </a>
            </div>

            @php
                $loansActive =
                    request()->routeIs('super-admin.loans.*') || request()->routeIs('super-admin.loan-categories.*');
            @endphp
            {{-- <div class="menu-section-title">Loans Management</div> --}}
            <a href="#loansMenu" class="menu-item d-flex align-items-center {{ $loansActive ? 'active' : '' }}"
                data-bs-toggle="collapse" role="button" aria-expanded="{{ $loansActive ? 'true' : 'false' }}"
                aria-controls="loansMenu">
                <span>
                    <i class="bi bi-cash-coin"></i>
                    <span>Loans Management</span>
                </span>
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse submenu {{ $loansActive ? 'show' : '' }}" id="loansMenu">
                <a href="{{ route('super-admin.loans.create') }}"
                    class="menu-item {{ request()->routeIs('super-admin.loans.create') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i>
                    <span>Create Loan</span>
                </a>
                <a href="{{ route('super-admin.loans.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.loans.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>
                    <span>View All Loans</span>
                </a>
                <a href="{{ route('super-admin.loan-categories.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.loan-categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Loan Categories</span>
                </a>
            </div>


            @php
                $packagesActive =
                    request()->routeIs('super-admin.lead-packages.*') ||
                    request()->routeIs('super-admin.package-orders.*');
            @endphp
            {{-- <div class="menu-section-title">Lead Packages</div> --}}
            <a href="#packagesMenu" class="menu-item d-flex align-items-center {{ $packagesActive ? 'active' : '' }}"
                data-bs-toggle="collapse" role="button" aria-expanded="{{ $packagesActive ? 'true' : 'false' }}"
                aria-controls="packagesMenu">
                <span>
                    <i class="bi bi-box-seam"></i>
                    <span>Lead Packages</span>
                </span>
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse submenu {{ $packagesActive ? 'show' : '' }}" id="packagesMenu">
                <a href="{{ route('super-admin.lead-packages.create') }}"
                    class="menu-item {{ request()->routeIs('super-admin.lead-packages.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Create Lead Package</span>
                </a>
                <a href="{{ route('super-admin.lead-packages.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.lead-packages.index') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Lead Packages</span>
                </a>

                <a href="{{ route('super-admin.package-orders.officer-purchases') }}"
                    class="menu-item {{ request()->routeIs('super-admin.package-orders.officer-purchases') ? 'active' : '' }}">
                    <i class="bi bi-cart-check"></i>
                    <span>Officer Purchases</span>
                </a>
            </div>

            @php $pendingOrders = \App\Models\PackageOrder::where('status', 'pending')->count(); @endphp
            <a href="{{ route('super-admin.package-orders.index') }}"
                class="menu-item {{ request()->routeIs('super-admin.package-orders.index') ? 'active' : '' }}">
                <i class="bi bi-card-checklist"></i>
                <span>
                    Package Orders
                    @if ($pendingOrders)
                        <span class="badge bg-danger ms-2">{{ $pendingOrders }}</span>
                    @endif
                </span>
            </a>

            <div class="menu-section-title">Customer Applications</div>

            <a href="{{ route('super-admin.customers.index') }}"
                class="menu-item {{ request()->routeIs('super-admin.customers.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Customer List</span>
            </a>

            <a href="{{ route('super-admin.applications.index') }}"
                class="menu-item {{ request()->routeIs('super-admin.applications.index') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i>
                <span>Loan Applications</span>
            </a>

            @php $unreadMessages = \App\Models\CustomerMessage::where('is_read', 0)->count(); @endphp
            <a href="{{ route('super-admin.customer-messages.index') }}"
                class="menu-item {{ request()->routeIs('super-admin.customer-messages.index') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i>
                <span>
                    Customer Messages
                    @if ($unreadMessages)
                        <span class="badge bg-danger ms-2">{{ $unreadMessages }}</span>
                    @endif
                </span>
            </a>




            <div class="menu-section-title">Site Settings</div>
            <a href="{{ route('super-admin.logo-settings.index') }}"
                class="menu-item {{ request()->routeIs('super-admin.logo-settings.*') ? 'active' : '' }}">
                <i class="bi bi-image"></i>
                <span>Logo Settings</span>
            </a>
            <a href="{{ route('super-admin.about-settings.index') }}"
                class="menu-item {{ request()->routeIs('super-admin.about-settings.*') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i>
                <span>About Settings</span>
            </a>
            <a href="{{ route('super-admin.testimonials.index') }}"
                class="menu-item {{ request()->routeIs('super-admin.testimonials.*') ? 'active' : '' }}">
                <i class="bi bi-chat-quote"></i>
                <span>Testimonials</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar top-navbar">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link sidebar-toggle me-3" id="sidebarToggle">
                        <i class="bi bi-list fs-4 text-dark"></i>
                    </button>
                    <h5 class="mb-0">@yield('dashboard-title', 'Dashboard')</h5>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#"
                            role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ Route::has('super-admin.profile.edit') ? route('super-admin.profile.edit') : '#' }}">My
                                    Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ Route::has('super-admin.profile.password.edit') ? route('super-admin.profile.password.edit') : '#' }}">Change
                                    Password</a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid py-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
