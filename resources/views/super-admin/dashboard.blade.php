@extends('layouts.admin')

@section('title', 'Super Admin Dashboard')
@section('dashboard-title', 'Super Admin Dashboard')

@section('content')
    {{-- <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.banks.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-building text-primary fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-primary mb-2">Create Bank</h5>
                        <p class="text-muted mb-0 small">Add a new bank to the system</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.bank-admins.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-person-badge text-success fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-success mb-2">Create Bank Admin</h5>
                        <p class="text-muted mb-0 small">Add a new bank administrator</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.branches.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-shop text-warning fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-warning mb-2">Create Branch</h5>
                        <p class="text-muted mb-0 small">Add a new branch</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.branch-admins.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-person-plus text-info fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-info mb-2">Create Branch Admin</h5>
                        <p class="text-muted mb-0 small">Add a new branch administrator</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.banks.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-purple bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-bank text-purple fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-purple mb-2">View All Banks</h5>
                        <p class="text-muted mb-0 small">Manage all banks in the system</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.branches.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-indigo bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-diagram-3 text-indigo fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-indigo mb-2">View All Branches</h5>
                        <p class="text-muted mb-0 small">Manage all branches in the system</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.loans.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-cash-coin text-danger fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-danger mb-2">Create Loan</h5>
                        <p class="text-muted mb-0 small">Add a new loan product</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.loans.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-pink bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-list-ul text-pink fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-pink mb-2">View All Loans</h5>
                        <p class="text-muted mb-0 small">Manage all loans in the system</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.applications.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-cyan bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-file-text text-cyan fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-cyan mb-2">View Loan Applications</h5>
                        <p class="text-muted mb-0 small">Manage customer loan applications</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.testimonials.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-orange bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-chat-quote text-orange fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-orange mb-2">Manage Testimonials</h5>
                        <p class="text-muted mb-0 small">Add and manage customer testimonials</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.logo-settings.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-purple bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-image text-purple fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-purple mb-2">Logo Settings</h5>
                        <p class="text-muted mb-0 small">Upload and manage site logos</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('super-admin.about-settings.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-info-circle text-info fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-info mb-2">About Settings</h5>
                        <p class="text-muted mb-0 small">Manage About Us page content</p>
                    </div>
                </div>
            </a>
        </div>
    </div> --}}

    <div class="row g-3 mb-4">
        @php
            $banksCount = \App\Models\Bank::count();
            $branchesCount = \App\Models\Branch::count();
            $officersCount = \App\Models\User::where('role', 'branch_admin')->count();
            $loansCount = \App\Models\Loan::count();
            $applicationsCount = \App\Models\LoanApplication::count();
            $packagesCount = \App\Models\LeadPackage::count();
            $pendingOrdersCount = \App\Models\PackageOrder::where('status', 'pending')->count();
            $customersCount = \App\Models\User::where('role', 'customer')->count();
        @endphp

        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.banks.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-building text-primary count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $banksCount }}</div>
                    </div>
                    <div class="text-muted small">Banks</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.branches.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-shop text-warning count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $branchesCount }}</div>
                    </div>
                    <div class="text-muted small">Branches</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.branch-admins.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-person-badge text-info count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $officersCount }}</div>
                    </div>
                    <div class="text-muted small">Officers</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.loans.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-cash-coin text-danger count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $loansCount }}</div>
                    </div>
                    <div class="text-muted small">Loans</div>
                </div>
            </a>
        </div>



        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.lead-packages.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-seam text-purple count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $packagesCount }}</div>
                    </div>
                    <div class="text-muted small">Packages</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.package-orders.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-card-checklist text-secondary count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $pendingOrdersCount }}</div>
                    </div>
                    <div class="text-muted small">Orders Pending</div>
                </div>
            </a>
        </div>


        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.customers.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-people-fill text-green count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $customersCount }}</div>
                    </div>
                    <div class="text-muted small">Customers</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('super-admin.applications.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 dashboard-count-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-file-text text-cyan count-icon"></i>
                        <div class="fs-4 fw-bold">{{ $applicationsCount }}</div>
                    </div>
                    <div class="text-muted small">Applications</div>
                </div>
            </a>
        </div>

    </div>



    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0"><i class="bi bi-bank me-2"></i>Banks Overview</h4>
        </div>
        <div class="card-body">
            @if ($banks->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No banks created yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Bank Name</th>
                                <th class="py-3">Code</th>
                                <th class="py-3">Branches</th>
                                <th class="py-3">Users</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $bank)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="bi bi-building text-primary"></i>
                                            </div>
                                            <strong>{{ $bank->name }}</strong>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $bank->code }}</span></td>
                                    <td><span class="text-muted">{{ $bank->branches_count }}</span></td>
                                    <td><span class="text-muted">{{ $bank->users_count }}</span></td>
                                    <td>
                                        @if ($bank->is_active)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Package Orders by Officers Overview -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-people me-2"></i>Top Officers by Purchased Leads</h5>
            <a href="{{ route('super-admin.package-orders.officer-purchases') }}"
                class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-3">
            @php
                $topOfficers = \App\Models\User::where('role', 'branch_admin')
                    ->whereHas('packageOrders', function ($q) {
                        $q->where('status', 'approved');
                    })
                    ->withCount([
                        'packageOrders as orders_count' => function ($q) {
                            $q->where('status', 'approved');
                        },
                    ])
                    ->withSum(
                        [
                            'packageOrders as total_leads' => function ($q) {
                                $q->where('status', 'approved');
                            },
                        ],
                        'number_of_leads',
                    )
                    ->withSum(
                        [
                            'packageOrders as total_spent' => function ($q) {
                                $q->where('status', 'approved');
                            },
                        ],
                        'price',
                    )
                    ->orderByDesc('total_leads')
                    ->take(5)
                    ->get();
            @endphp

            @if ($topOfficers->isEmpty())
                <div class="text-center text-muted py-3">No officer purchases yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Officer</th>
                                <th>Orders</th>
                                <th>Leads</th>
                                <th>Spent</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topOfficers as $off)
                                <tr>
                                    <td>{{ $off->name }}</td>
                                    <td>{{ $off->orders_count ?? 0 }}</td>
                                    <td>{{ $off->total_leads ?? 0 }}</td>
                                    <td>৳{{ number_format($off->total_spent ?? 0, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('super-admin.package-orders.index', ['officer_id' => $off->id]) }}"
                                            class="btn btn-sm btn-outline-secondary">View Orders</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Customer Messages Overview -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            @php $unreadCount = \App\Models\CustomerMessage::where('is_read', 0)->count(); @endphp
            <h5 class="mb-0"><i class="bi bi-chat-dots me-2"></i>Customer Messages
                @if ($unreadCount)
                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                @endif
            </h5>
            <a href="{{ route('super-admin.customer-messages.index') }}" class="btn btn-sm btn-outline-primary">View
                All</a>
        </div>
        <div class="card-body p-3">
            @php
                $recentMessages = \App\Models\CustomerMessage::orderBy('created_at', 'desc')->take(5)->get();
            @endphp

            @if ($recentMessages->isEmpty())
                <div class="text-center text-muted py-3">No messages yet.</div>
            @else
                <div class="list-group list-group-flush">
                    @foreach ($recentMessages as $msg)
                        <a href="{{ route('super-admin.customer-messages.show', $msg->id) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                            <div class="me-3">
                                <div class="fw-semibold">{{ $msg->first_name }} {{ $msg->last_name }}</div>
                                <div class="text-muted small">{{ \Illuminate\Support\Str::limit($msg->message, 80) }}
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="small text-muted">
                                    {{ $msg->created_at ? $msg->created_at->format('d M, Y') : '' }}</div>
                                @if (!$msg->is_read)
                                    <span class="badge bg-danger mt-2">New</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .dashboard-count-card {
                border-radius: 0.75rem;
                background: linear-gradient(135deg, rgba(13, 110, 253, 0.06), rgba(102, 16, 242, 0.04));
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
                min-height: 92px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: .25rem;
            }

            .dashboard-count-card .count-icon {
                font-size: 1.35rem;
                line-height: 1;
                display: inline-block;
                opacity: 0.95;
                text-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            }

            .dashboard-count-card .fs-4 {
                font-size: 1.25rem;
            }

            .dashboard-count-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 0.75rem 1.5rem rgba(13, 110, 253, 0.08);
            }

            .hover-lift {
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            }

            .text-purple {
                color: #6f42c1;
            }

            .bg-purple {
                background-color: #6f42c1;
            }

            .text-indigo {
                color: #6610f2;
            }

            .bg-indigo {
                background-color: #6610f2;
            }

            .text-pink {
                color: #d63384;
            }

            .bg-pink {
                background-color: #d63384;
            }

            .text-cyan {
                color: #0dcaf0;
            }

            .bg-cyan {
                background-color: #0dcaf0;
            }

            .text-orange {
                color: #fd7e14;
            }

            .bg-orange {
                background-color: #fd7e14;
            }
        </style>
    @endpush
@endsection
