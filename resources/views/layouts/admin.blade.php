<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ucwords(str_replace('_', ' ', auth()->user()->role ?? 'Admin')) . ' Dashboard')</title>
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

        /* Compact pagination for admin tables */
        .pagination {
            margin-bottom: 0;
            font-size: 0.88rem;
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

        .table-responsive+.mt-4 .pagination,
        .mt-4 .pagination {
            justify-content: flex-end;
        }
    </style>
    @stack('styles')
    @if (isset($logoSettings) && $logoSettings->favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $logoSettings->favicon) }}">
    @endif
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
            @php
                $currentUser = auth()->user();
                $definedPermissionNames = \Spatie\Permission\Models\Permission::query()
                    ->where('guard_name', 'web')
                    ->pluck('name')
                    ->flip();
                $hasPermission = function (string $permission) use ($currentUser, $definedPermissionNames): bool {
                    if ($currentUser->isSuperAdmin()) {
                        return true;
                    }

                    if (!$definedPermissionNames->has($permission)) {
                        return false;
                    }

                    return $currentUser->hasPermissionTo($permission, 'web');
                };
                $hasAnyPermission = function (array $permissions) use ($hasPermission): bool {
                    foreach ($permissions as $permission) {
                        if ($hasPermission($permission)) {
                            return true;
                        }
                    }

                    return false;
                };
            @endphp

            <a href="{{ route('super-admin.dashboard') }}"
                class="menu-item {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('chat.index') }}" class="menu-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i>
                <span>Chat</span>
                @php
                    $unreadChatCount = \App\Models\Message::where('is_seen', false)
                        ->where('sender_id', '!=', auth()->id())
                        ->whereHas('conversation', function ($query) {
                            $query->where('user_one_id', auth()->id())->orWhere('user_two_id', auth()->id());
                        })
                        ->count();
                @endphp
                @if ($unreadChatCount > 0)
                    <span class="badge bg-danger ms-auto rounded-pill">{{ $unreadChatCount }}</span>
                @endif
            </a>

            {{-- <div class="menu-section-title">Banks Management</div> --}}
            @php
                $banksActive =
                    request()->routeIs('super-admin.banks.*') ||
                    request()->routeIs('super-admin.bank-admins.*') ||
                    request()->routeIs('super-admin.branches.*') ||
                    request()->routeIs('super-admin.thanas.*');
                $showBanksMenu = $hasAnyPermission([
                    'banks.view',
                    'banks.create',
                    'branches.view',
                    'branches.create',
                    'branch-admins.view',
                    'branch-admins.create',
                ]);
            @endphp

            @if ($showBanksMenu)
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
                    @if ($hasPermission('banks.create'))
                        <a href="{{ route('super-admin.banks.create') }}"
                            class="menu-item {{ request()->routeIs('super-admin.banks.create') ? 'active' : '' }}">
                            <i class="bi bi-building"></i>
                            <span>Create Bank</span>
                        </a>
                    @endif
                    @if ($hasPermission('banks.view'))
                        <a href="{{ route('super-admin.banks.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.banks.index') ? 'active' : '' }}">
                            <i class="bi bi-bank"></i>
                            <span>View All Banks</span>
                        </a>
                    @endif
                    @if ($hasPermission('branches.view'))
                        <a href="{{ route('super-admin.branches.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.branches.index') ? 'active' : '' }}">
                            <i class="bi bi-diagram-3-fill"></i>
                            <span>View Bank Branches</span>
                        </a>
                    @endif
                    @if ($hasPermission('branches.create'))
                        <a href="{{ route('super-admin.thanas.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.thanas.*') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Manage Thanas</span>
                        </a>
                    @endif
                </div>

            @endif



            @php
                $branchesActive =
                    request()->routeIs('super-admin.branches.*') || request()->routeIs('super-admin.branch-admins.*');
            @endphp
            {{-- <div class="menu-section-title">Branches Management</div> --}}


            {{-- <a href="#branchesMenu" class="menu-item d-flex align-items-center {{ $branchesActive ? 'active' : '' }}"
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
            </div> --}}

            @php
                $loansActive =
                    request()->routeIs('super-admin.loans.*') ||
                    request()->routeIs('super-admin.loan-categories.*') ||
                    request()->routeIs('super-admin.service-categories.*') ||
                    request()->routeIs('super-admin.service-types.*');
                $showLoansMenu = $hasAnyPermission([
                    'loans.view',
                    'loans.manage',
                    'loan-categories.view',
                    'loan-categories.manage',
                    'service-categories.view',
                    'service-categories.manage',
                    'service-types.view',
                    'service-types.manage',
                ]);
            @endphp
            @if ($showLoansMenu)
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
                    @if ($hasPermission('loan-categories.view') || $hasPermission('loan-categories.manage'))
                        <a href="{{ route('super-admin.loan-categories.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.loan-categories.*') ? 'active' : '' }}">
                            <i class="bi bi-tags"></i>
                            <span>Loan Categories</span>
                        </a>
                    @endif
                    @if ($hasPermission('service-categories.view') || $hasPermission('service-categories.manage'))
                        <a href="{{ route('super-admin.service-categories.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.service-categories.*') ? 'active' : '' }}">
                            <i class="bi bi-grid-3x3-gap"></i>
                            <span>Service Categories</span>
                        </a>
                    @endif
                    @if ($hasPermission('service-types.view') || $hasPermission('service-types.manage'))
                        <a href="{{ route('super-admin.service-types.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.service-types.*') ? 'active' : '' }}">
                            <i class="bi bi-diagram-3"></i>
                            <span>Service Types</span>
                        </a>
                    @endif
                </div>
            @endif

            @php
                $packagesActive =
                    request()->routeIs('super-admin.lead-packages.*') ||
                    request()->routeIs('super-admin.payment-methods.*') ||
                    request()->routeIs('super-admin.package-orders.*') ||
                    request()->routeIs('super-admin.package-orders.gift.*') ||
                    request()->routeIs('super-admin.badges.*');
                $showPackagesMenu = $hasAnyPermission([
                    'lead-packages.view',
                    'lead-packages.manage',
                    'payment-methods.view',
                    'payment-methods.manage',
                    'package-orders.view',
                    'package-orders.manage',
                    'badges.view',
                    'badges.create',
                    'badges.manage',
                ]);
            @endphp
            @if ($showPackagesMenu)
                {{-- <div class="menu-section-title">Lead Packages</div> --}}
                <a href="#packagesMenu"
                    class="menu-item d-flex align-items-center {{ $packagesActive ? 'active' : '' }}"
                    data-bs-toggle="collapse" role="button" aria-expanded="{{ $packagesActive ? 'true' : 'false' }}"
                    aria-controls="packagesMenu">
                    <span>
                        <i class="bi bi-box-seam"></i>
                        <span>Lead Packages</span>
                    </span>
                    <i class="bi bi-chevron-down"></i>
                </a>

                <div class="collapse submenu {{ $packagesActive ? 'show' : '' }}" id="packagesMenu">
                    @if ($hasPermission('lead-packages.create') || $hasPermission('lead-packages.manage'))
                        <a href="{{ route('super-admin.lead-packages.create') }}"
                            class="menu-item {{ request()->routeIs('super-admin.lead-packages.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle"></i>
                            <span>Create Lead Package</span>
                        </a>
                    @endif
                    @if ($hasPermission('lead-packages.view') || $hasPermission('lead-packages.manage'))
                        <a href="{{ route('super-admin.lead-packages.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.lead-packages.index') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i>
                            <span>Lead Packages</span>
                        </a>
                    @endif

                    @if ($hasPermission('payment-methods.view') || $hasPermission('payment-methods.manage'))
                        <a href="{{ route('super-admin.payment-methods.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.payment-methods.*') ? 'active' : '' }}">
                            <i class="bi bi-credit-card"></i>
                            <span>Payment Methods</span>
                        </a>
                    @endif

                    @if ($hasPermission('package-orders.manage') || $hasPermission('package-orders.view'))
                        <a href="{{ route('super-admin.package-orders.officer-purchases') }}"
                            class="menu-item {{ request()->routeIs('super-admin.package-orders.officer-purchases') ? 'active' : '' }}">
                            <i class="bi bi-cart-check"></i>
                            <span>Officer Purchases</span>
                        </a>

                        <a href="{{ route('super-admin.package-orders.gift.eligible') }}"
                            class="menu-item {{ request()->routeIs('super-admin.package-orders.gift.eligible') ? 'active' : '' }}">
                            <i class="bi bi-gift"></i>
                            <span>Gift Eligible Officers</span>
                        </a>
                    @endif

                    @if ($hasPermission('badges.view') || $hasPermission('badges.create') || $hasPermission('badges.manage'))
                        <a href="{{ route('super-admin.badges.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.badges.index') ? 'active' : '' }}">
                            <i class="bi bi-award"></i>
                            <span>Officer Badges</span>
                        </a>
                    @endif

                </div>
            @endif

            @php
                $pendingBranchAdmins = \App\Models\User::where('role', 'branch_admin')->where('view', 0)->count();
                $showBankOfficersLink = $hasAnyPermission(['branch-admins.view', 'branch-admins.manage']);
            @endphp

            @if ($showBankOfficersLink)
                <a href="{{ route('super-admin.branch-admins.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.branch-admins.index') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>
                        View Bank Officers
                        @if ($pendingBranchAdmins)
                            <span class="badge bg-danger ms-2">{{ $pendingBranchAdmins }}</span>
                        @endif
                    </span>
                </a>
            @endif






            @php
                $pendingOrders = \App\Models\PackageOrder::where('status', 'pending')->count();
                $pendingNewRequests = \App\Models\NewLoanApplication::whereIn('status', ['pending', 'active'])
                    ->whereHas('customer', function ($customerQuery) {
                        $customerQuery->where('is_active', 1);
                    })
                    ->where('admin_view', 0)
                    ->count();
                $showPackageOrdersLink = $hasAnyPermission(['package-orders.view', 'package-orders.manage']);
            @endphp
            @if ($showPackageOrdersLink)
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
            @endif



            @php
                $showCustomerApplications = $hasAnyPermission([
                    'customers.view',
                    'customers.manage',
                    'applications.view',
                    'applications.manage',
                    'customer-messages.view',
                    'customer-messages.manage',
                ]);
            @endphp

            @if ($showCustomerApplications)
                <div class="menu-section-title">Customer Applications</div>

                @if ($hasPermission('customers.view') || $hasPermission('customers.manage'))
                    <a href="{{ route('super-admin.customers.index') }}"
                        class="menu-item {{ request()->routeIs('super-admin.customers.index') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Customer List</span>
                    </a>
                @endif

                {{-- <a href="{{ route('super-admin.applications.index') }}"
                    class="menu-item {{ request()->routeIs('super-admin.applications.index') ? 'active' : '' }}">
                    <i class="bi bi-file-text"></i>
                    <span>Loan Applications</span>
                </a> --}}

                @if ($hasPermission('applications.view') || $hasPermission('applications.manage'))
                    <a href="{{ route('super-admin.new-applications.index') }}"
                        class="menu-item {{ request()->routeIs('super-admin.new-applications.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope-exclamation"></i>
                        <span>
                            New Loan Requests
                            @if ($pendingNewRequests)
                                <span class="badge bg-danger ms-2">{{ $pendingNewRequests }}</span>
                            @endif
                        </span>
                    </a>
                @endif

                @if ($hasPermission('customer-messages.view') || $hasPermission('customer-messages.manage'))
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
                @endif
            @endif

            @php
                $ratingsActive =
                    request()->routeIs('super-admin.ratings.*') ||
                    request()->routeIs('super-admin.ratings.bank-officer');
                $showRatingsMenu = $hasAnyPermission(['ratings.view', 'ratings.manage']);
            @endphp
            @if ($showRatingsMenu)
                <a href="#ratingsMenu"
                    class="menu-item d-flex align-items-center {{ $ratingsActive ? 'active' : '' }}"
                    data-bs-toggle="collapse" role="button" aria-expanded="{{ $ratingsActive ? 'true' : 'false' }}"
                    aria-controls="ratingsMenu">
                    <span>
                        <i class="bi bi-star-fill"></i>
                        <span>Ratings</span>
                    </span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse submenu {{ $ratingsActive ? 'show' : '' }}" id="ratingsMenu">
                    <a href="{{ route('super-admin.ratings.index') }}"
                        class="menu-item {{ request()->routeIs('super-admin.ratings.index') ? 'active' : '' }}">
                        <i class="bi bi-star"></i>
                        <span>Customer Ratings</span>
                    </a>
                    <a href="{{ route('super-admin.ratings.bank-officer') }}"
                        class="menu-item {{ request()->routeIs('super-admin.ratings.bank-officer') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Bank Officer Ratings</span>
                    </a>
                </div>
            @endif


            @php
                $staffActive =
                    request()->routeIs('super-admin.admins.*') || request()->routeIs('super-admin.permissions.*');
                $showStaffMenu = $hasAnyPermission(['admins.view', 'admins.create', 'permissions.manage']);
            @endphp

            @if ($showStaffMenu)
                <a href="#staffMenu" class="menu-item d-flex align-items-center {{ $staffActive ? 'active' : '' }}"
                    data-bs-toggle="collapse" role="button" aria-expanded="{{ $staffActive ? 'true' : 'false' }}"
                    aria-controls="staffMenu">
                    <span>
                        <i class="bi bi-people-fill"></i>
                        <span>Staff Management</span>
                    </span>
                    <i class="bi bi-chevron-down"></i>
                </a>

                <div class="collapse submenu {{ $staffActive ? 'show' : '' }}" id="staffMenu">
                    @if ($hasPermission('admins.view'))
                        <a href="{{ route('super-admin.admins.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.admins.index') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i>
                            <span>Manage Admins</span>
                        </a>
                    @endif
                    @if ($hasPermission('admins.create'))
                        <a href="{{ route('super-admin.admins.create') }}"
                            class="menu-item {{ request()->routeIs('super-admin.admins.create') ? 'active' : '' }}">
                            <i class="bi bi-person-plus-fill"></i>
                            <span>Create Admin</span>
                        </a>
                    @endif
                    @if ($hasPermission('permissions.manage'))
                        <a href="{{ route('super-admin.permissions.index') }}"
                            class="menu-item {{ request()->routeIs('super-admin.permissions.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock"></i>
                            <span>Manage Permissions</span>
                        </a>
                    @endif
                </div>
            @endif






            @php
                $showSiteSettings = $hasAnyPermission(['sitesettings.view', 'sitesettings.manage']);
            @endphp

            @if ($showSiteSettings)
                <div class="menu-section-title">Site Settings</div>
                @if ($hasPermission('sitesettings.view') || $hasPermission('sitesettings.manage'))
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
                    <a href="{{ route('super-admin.terms-conditions.index') }}"
                        class="menu-item {{ request()->routeIs('super-admin.terms-conditions.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Terms & Conditions</span>
                    </a>
                    <a href="{{ route('super-admin.homepage-carousels.index') }}"
                        class="menu-item {{ request()->routeIs('super-admin.homepage-carousels.*') ? 'active' : '' }}">
                        <i class="bi bi-images"></i>
                        <span>Homepage Carousel</span>
                    </a>
                    <a href="{{ route('super-admin.image-advertisements.index') }}"
                        class="menu-item {{ request()->routeIs('super-admin.image-advertisements.*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i>
                        <span>Image Advertisements</span>
                    </a>
                    <a href="{{ route('super-admin.testimonials.index') }}"
                        class="menu-item {{ request()->routeIs('super-admin.testimonials.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-quote"></i>
                        <span>Testimonials</span>
                    </a>
                @endif
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
