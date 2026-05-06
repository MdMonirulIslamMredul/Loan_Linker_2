@extends('layouts.admin')

@section('title', 'Package Orders')
@section('dashboard-title', 'Package Orders')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Package Orders</h4>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-white shadow-sm rounded-bottom-0">
                <form method="GET" class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Bank</label>
                        <select id="filter-bank" name="bank_id" class="form-select">
                            <option value="">All Banks</option>
                            @foreach ($banks ?? [] as $b)
                                <option value="{{ $b->id }}" {{ request('bank_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Branch</label>
                        <select id="filter-branch" name="branch_id" class="form-select">
                            <option value="">All Branches</option>
                            @foreach ($banks ?? [] as $b)
                                @foreach ($b->branches as $br)
                                    <option value="{{ $br->id }}" data-bank="{{ $b->id }}"
                                        {{ request('branch_id') == $br->id ? 'selected' : '' }}>{{ $br->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Officer</label>
                        <select id="filter-officer" name="officer_id" class="form-select">
                            <option value="">All Officers</option>
                            @foreach ($users ?? [] as $u)
                                <option value="{{ $u->id }}" data-branch="{{ $u->branch_id }}"
                                    data-bank="{{ $u->bank_id }}"
                                    {{ request('officer_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Package</label>
                        <select name="package_id" class="form-select">
                            <option value="">All Packages</option>
                            @foreach ($packages ?? [] as $pkg)
                                <option value="{{ $pkg->id }}"
                                    {{ request('package_id') == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small text-muted">From</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small text-muted">To</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-12 text-end mt-2">
                        <button class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('super-admin.package-orders.index') }}"
                            class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
                    </div>
                </form>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Officer</th>
                            <th>Package</th>
                            <th>Leads</th>
                            <th>Price</th>
                            <th>Order Date</th>
                            <th>Approved Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr
                                class="{{ $order->status === 'pending' ? 'table-warning' : ($order->status === 'approved' ? 'table-secondary' : '') }}">
                                <td>
                                    <a href="#" class="user-info" data-name="{{ e($order->user->name) }}"
                                        data-email="{{ e($order->user->email) }}"
                                        data-phone="{{ e($order->user->phone) }}" data-role="{{ e($order->user->role) }}"
                                        data-bank="{{ e(optional($order->user->bank)->name) }}"
                                        data-branch="{{ e(optional($order->user->branch)->name) }}"
                                        data-lead_balance="{{ $order->user->lead_balance ?? 0 }}">{{ $order->user->name }}</a>
                                </td>
                                <td>{{ $order->leadPackage->name }}</td>
                                <td>{{ $order->number_of_leads }}</td>
                                <td class="fw-semibold">৳{{ number_format($order->price, 2) }}</td>
                                <td>{{ $order->created_at ? $order->created_at->format('d M, Y') : '-' }}</td>
                                <td>{{ $order->approved_at ? \Carbon\Carbon::parse($order->approved_at)->format('d M, Y') : 'Not approved' }}
                                </td>
                                <td>
                                    @if ($order->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($order->status === 'approved')
                                        <span class="badge bg-secondary text-white">Approved</span>
                                    @elseif($order->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->payment_method)
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 view-payment"
                                            data-payment_method="{{ e($order->payment_method) }}"
                                            data-txn_number="{{ e($order->txn_number) }}"
                                            data-bank_name="{{ e($order->bank_name) }}"
                                            data-account_no="{{ e($order->account_no) }}"
                                            data-phone="{{ e($order->phone) }}"
                                            data-screenshot-url="{{ $order->screenshot ? asset('storage/' . $order->screenshot) : '' }}">View
                                            Payment</button>
                                    @endif

                                    @if ($order->status === 'pending')
                                        <form action="{{ route('super-admin.package-orders.approve', $order) }}"
                                            method="POST" class="d-inline me-1">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>

                                        <form action="{{ route('super-admin.package-orders.reject', $order) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Reject this order?');">Reject</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>

    @push('styles')
        <style>
            /* Modernize filters and table */
            .form-label.small.text-muted {
                font-size: 0.75rem;
            }

            .table thead th {
                font-weight: 600;
                border-bottom: 0;
            }

            .table tbody tr.table-warning td {
                background-color: #fff4e5;
            }

            /* make approved rows light grey */
            .table tbody tr.table-secondary td {
                background-color: #e9ecef;
                color: #495057;
            }

            .badge {
                font-size: 0.85rem;
                padding: 0.45em 0.6em;
            }

            .card.border-0.shadow-sm {
                border-radius: 0.6rem;
            }

            .payment-screenshot {
                max-width: 100%;
                height: auto;
                border: 1px solid #e9ecef;
                border-radius: 6px;
            }
        </style>
    @endpush

    <!-- User Info Modal -->
    <div class="modal fade" id="userInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Officer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><strong>Name:</strong> <span id="ui-name"></span></div>
                    <div class="mb-2"><strong>Role:</strong> <span id="ui-role"></span></div>
                    <div class="mb-2"><strong>Email:</strong> <span id="ui-email"></span></div>
                    <div class="mb-2"><strong>Phone:</strong> <span id="ui-phone"></span></div>
                    <div class="mb-2"><strong>Bank:</strong> <span id="ui-bank"></span></div>
                    <div class="mb-2"><strong>Branch:</strong> <span id="ui-branch"></span></div>
                    <div class="mb-2"><strong>Lead Balance:</strong> <span id="ui-lead-balance"></span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Info Modal -->
    <div class="modal fade" id="paymentInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><strong>Method:</strong> <span id="pi-method">-</span></div>
                    <div class="mb-2"><strong>Transaction #:</strong> <span id="pi-txn">-</span></div>
                    <div class="mb-2"><strong>Phone:</strong> <span id="pi-phone">-</span></div>
                    <div class="mb-2"><strong>Bank:</strong> <span id="pi-bank">-</span></div>
                    <div class="mb-2"><strong>Account #:</strong> <span id="pi-account">-</span></div>
                    <div class="mb-3"><strong>Screenshot:</strong>
                        <div id="pi-screenshot-container" class="mt-2">
                            <a id="pi-screenshot-link" href="#" target="_blank"><img id="pi-screenshot"
                                    class="payment-screenshot" src="" alt="Screenshot" /></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Modal handler
                const modalEl = document.getElementById('userInfoModal');
                if (modalEl) {
                    const userModal = new bootstrap.Modal(modalEl);
                    document.querySelectorAll('.user-info').forEach(function(el) {
                        el.addEventListener('click', function(e) {
                            e.preventDefault();
                            document.getElementById('ui-name').textContent = el.dataset.name || '-';
                            document.getElementById('ui-email').textContent = el.dataset.email || '-';
                            document.getElementById('ui-phone').textContent = el.dataset.phone || '-';
                            document.getElementById('ui-role').textContent = el.dataset.role || '-';
                            document.getElementById('ui-bank').textContent = el.dataset.bank || '-';
                            document.getElementById('ui-branch').textContent = el.dataset.branch || '-';
                            document.getElementById('ui-lead-balance').textContent = el.dataset
                                .lead_balance ?? '0';
                            userModal.show();
                        });
                    });
                }

                // Cascading filters: bank -> branch -> officer
                const bankSelect = document.getElementById('filter-bank');
                const branchSelect = document.getElementById('filter-branch');
                const officerSelect = document.getElementById('filter-officer');

                function filterBranches() {
                    const bankVal = bankSelect.value;
                    // show only branches matching bank (or all if empty)
                    Array.from(branchSelect.options).forEach(function(opt) {
                        if (!opt.dataset.bank) return; // keep the All option
                        opt.style.display = (!bankVal || opt.dataset.bank === bankVal) ? '' : 'none';
                    });
                    // if selected branch doesn't belong to bank, reset
                    if (branchSelect.value && branchSelect.selectedOptions[0].dataset.bank !== bankVal) {
                        branchSelect.value = '';
                    }
                    filterOfficers();
                }

                function filterOfficers() {
                    const branchVal = branchSelect.value;
                    const bankVal = bankSelect.value;
                    Array.from(officerSelect.options).forEach(function(opt) {
                        if (!opt.value) return; // keep All
                        const optBranch = opt.dataset.branch || '';
                        const optBank = opt.dataset.bank || '';
                        let show = true;
                        if (bankVal && optBank !== bankVal) show = false;
                        if (branchVal && optBranch !== branchVal) show = false;
                        opt.style.display = show ? '' : 'none';
                    });
                    if (officerSelect.value) {
                        const current = officerSelect.selectedOptions[0];
                        if (current && current.style.display === 'none') officerSelect.value = '';
                    }
                }

                if (bankSelect && branchSelect && officerSelect) {
                    bankSelect.addEventListener('change', filterBranches);
                    branchSelect.addEventListener('change', filterOfficers);
                    // run once on load to apply current filters
                    filterBranches();
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pModalEl = document.getElementById('paymentInfoModal');
                if (pModalEl) {
                    const paymentModal = new bootstrap.Modal(pModalEl);
                    document.querySelectorAll('.view-payment').forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const method = btn.dataset.payment_method || '-';
                            const txn = btn.dataset.txn_number || '-';
                            const phone = btn.dataset.phone || '-';
                            const bank = btn.dataset.bank_name || '-';
                            const account = btn.dataset.account_no || '-';
                            const screenshotUrl = btn.dataset.screenshotUrl || '';

                            document.getElementById('pi-method').textContent = method;
                            document.getElementById('pi-txn').textContent = txn;
                            document.getElementById('pi-phone').textContent = phone;
                            document.getElementById('pi-bank').textContent = bank;
                            document.getElementById('pi-account').textContent = account;

                            const img = document.getElementById('pi-screenshot');
                            const link = document.getElementById('pi-screenshot-link');
                            if (screenshotUrl) {
                                img.src = screenshotUrl;
                                link.href = screenshotUrl;
                                img.style.display = '';
                            } else {
                                img.src = '';
                                link.href = '#';
                                img.style.display = 'none';
                            }

                            paymentModal.show();
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection
