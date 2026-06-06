<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bank Officer Dashboard')</title>
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

        .sidebar-user-badge {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin-top: 1rem;
        }

        .sidebar-user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.4);
            background: #ffffff;
        }

        .sidebar-user-avatar .bi {
            font-size: 1.2rem;
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

        /* Compact pagination for branch-admin tables */
        .pagination {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            margin-bottom: 0;
            font-size: 0.88rem;
        }

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

        .pagination li,
        .pagination .page-item {
            white-space: nowrap;
        }

        .pagination .page-item:first-child a,
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child a,
        .pagination .page-item:last-child .page-link {
            border-radius: 0.35rem;
        }

        .pagination .page-link svg,
        .pagination .page-link .bi {
            font-size: 1rem;
        }

        .table-responsive + .mt-4 .pagination,
        .mt-4 .pagination {
            justify-content: flex-end;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-light">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5 class="mb-0"><i class="bi bi-shop me-2"></i>Bank Officer</h5>
            <div class="sidebar-user-badge">
                @if(auth()->user()->officerDocument?->picture)
                    <img src="{{ asset('storage/' . auth()->user()->officerDocument->picture) }}" alt="Officer picture" class="sidebar-user-avatar">
                @else
                    <span class="sidebar-user-avatar d-flex align-items-center justify-content-center text-muted">
                        <i class="bi bi-person-fill"></i>
                    </span>
                @endif
                <div>
                    <p class="mb-1 fw-semibold text-white">{{ auth()->user()->name }}</p>
                    <small class="d-block text-white-50">User ID: <span class="fw-semibold">#{{ auth()->user()->id }}</span></small>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">

            <a href="{{ route('branch-admin.dashboard') }}"
                class="menu-item {{ request()->routeIs('branch-admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

         

            <a href="/branch-admin/profile" class="menu-item {{ request()->routeIs('branch-admin.profile') ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>

                

            {{-- <div class="menu-section-title">Loans Management</div>
            <a href="{{ route('branch-admin.loans.index') }}"
                class="menu-item {{ request()->routeIs('branch-admin.loans.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span>Manage Loans</span>
            </a>
            <a href="{{ route('branch-admin.loans.create') }}"
                class="menu-item {{ request()->routeIs('branch-admin.loans.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span>Add New Loan</span>
            </a> --}}

            @if(auth()->user()->is_access)


               <a href="{{ route('chat.index') }}"
                class="menu-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i>
                <span>Chat</span>
                @php
                    $unreadChatCount = \App\Models\Message::where('is_seen', false)
                        ->where('sender_id', '!=', auth()->id())
                        ->whereHas('conversation', function ($query) {
                            $query->where('user_one_id', auth()->id())
                                  ->orWhere('user_two_id', auth()->id());
                        })->count();
                @endphp
                @if($unreadChatCount > 0)
                    <span class="badge bg-danger ms-auto rounded-pill">{{ $unreadChatCount }}</span>
                @endif
            </a>



                <div class="menu-section-title">Applications</div>

                @php
                    $pendingNewRequestsQuery = \App\Models\NewLoanApplication::where('status', 'active')
                        ->whereHas('customer', function ($customerQuery) {
                            $customerQuery->where('is_active', 1);
                        });

                    if (! auth()->user()->isSuperAdmin() && ! auth()->user()->isBankAdmin()) {
                        $unlockedNewLoanIds = \App\Models\LeadAccess::where('officer_id', auth()->id())
                            ->whereNotNull('newloan_id')
                            ->pluck('newloan_id');

                        $pendingNewRequestsQuery->whereNotIn('id', $unlockedNewLoanIds);
                    }

                    $pendingNewRequests = $pendingNewRequestsQuery->count();
                @endphp

                {{-- <a href="{{ route('branch-admin.applications.index') }}"
                    class="menu-item {{ request()->routeIs('branch-admin.applications.index') ? 'active' : '' }}">
                    <i class="bi bi-file-text"></i>
                    <span>All Loan Applications</span>
                </a> --}}
                <a href="{{ route('branch-admin.new-applications.index') }}"
                    class="menu-item {{ request()->routeIs('branch-admin.new-applications.index') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-plus"></i>
                    <span>New Loan Requests</span>
                    @if ($pendingNewRequests)
                        <span class="badge bg-danger ms-2">{{ $pendingNewRequests }}</span>
                    @endif
                </a>
                <a href="{{ route('branch-admin.new-applications.unlocked') }}"
                    class="menu-item {{ request()->routeIs('branch-admin.new-applications.unlocked') ? 'active' : '' }}">
                    <i class="bi bi-unlock"></i>
                    <span>Unlocked Requests</span>
                </a>

                 <a href="{{ route('branch-admin.ratings.history') }}"
                    class="menu-item {{ request()->routeIs('branch-admin.ratings.history') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span>Ratings History</span>
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
            @endif
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
