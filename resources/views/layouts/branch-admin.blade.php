<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Branch Admin Dashboard')</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
            border-left-color: #667eea;
        }

        .sidebar-menu .menu-item.active {
            background: #e7f1ff;
            color: #667eea;
            border-left-color: #667eea;
            font-weight: 600;
        }

        .sidebar-menu .menu-item i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
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
        <div class="sidebar-header">
            <h5 class="mb-0"><i class="bi bi-shop me-2"></i>Branch Officer</h5>
            <small class="opacity-75">{{ auth()->user()->name }}</small>
        </div>

        <div class="sidebar-menu">

            <a href="{{ route('branch-admin.dashboard') }}"
                class="menu-item {{ request()->routeIs('branch-admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-section-title">Loans Management</div>
            <a href="{{ route('branch-admin.loans.index') }}"
                class="menu-item {{ request()->routeIs('branch-admin.loans.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span>Manage Loans</span>
            </a>
            <a href="{{ route('branch-admin.loans.create') }}"
                class="menu-item {{ request()->routeIs('branch-admin.loans.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span>Add New Loan</span>
            </a>

            <div class="menu-section-title">Applications</div>

            <a href="{{ route('branch-admin.applications.index') }}"
                class="menu-item {{ request()->routeIs('branch-admin.applications.index') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i>
                <span>All Loan Applications</span>
            </a>


            <div class="menu-section-title">Packages</div>
            <a href="{{ route('branch-admin.packages.gallery') }}"
                class="menu-item {{ request()->routeIs('branch-admin.packages.gallery') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Lead Packages</span>
            </a>
            <a href="{{ route('branch-admin.packages.history') }}"
                class="menu-item {{ request()->routeIs('branch-admin.packages.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Purchase History</span>
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
                        <a href="#" class="d-flex align-items-center text-decoration-none" id="userMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4 me-2"></i>
                            <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down ms-2 d-none d-sm-inline"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuLink">
                            <li><a class="dropdown-item" href="{{ route('branch-admin.profile') }}"><i
                                        class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('branch-admin.profile.password.edit') }}"><i
                                        class="bi bi-shield-lock me-2"></i>Change Password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i
                                            class="bi bi-box-arrow-right me-2"></i>Logout</button>
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
