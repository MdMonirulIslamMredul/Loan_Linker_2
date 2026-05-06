@extends('layouts.admin')

@section('title', 'Officer Purchases')
@section('dashboard-title', 'Officer Purchases')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Officer Purchases</h4>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Bank</label>
                    <select id="filter-bank" name="bank_id" class="form-select">
                        <option value="">All Banks</option>
                        @foreach ($banks as $b)
                            <option value="{{ $b->id }}" {{ request('bank_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted">Branch</label>
                    <select id="filter-branch" name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach ($banks as $b)
                            @foreach ($b->branches as $br)
                                <option value="{{ $br->id }}" data-bank="{{ $b->id }}"
                                    {{ request('branch_id') == $br->id ? 'selected' : '' }}>{{ $br->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 text-end align-self-end">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('super-admin.package-orders.officer-purchases') }}"
                        class="btn btn-outline-secondary ms-1">Reset</a>
                </div>

            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive p-3">
            <table class="table table-hover table-borderless align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Officer</th>
                        <th>Bank</th>
                        <th>Branch</th>
                        <th>Orders</th>
                        <th>Total Leads</th>
                        <th>Total Spent</th>
                        <th>Regular</th>
                        <th>Premium</th>
                        <th>Gift</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ optional($user->bank)->name }}</td>
                            <td>{{ optional($user->branch)->name }}</td>
                            <td>{{ $user->orders_count ?? 0 }}</td>
                            <td>{{ $user->total_leads ?? 0 }}</td>
                            <td>৳{{ number_format($user->total_spent ?? 0, 2) }}</td>
                            <td>{{ $user->regular_count ?? 0 }}</td>
                            <td>{{ $user->premium_count ?? 0 }}</td>
                            <td>{{ $user->gift_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('super-admin.package-orders.gift.show', $user) }}"
                                    class="btn btn-sm btn-outline-primary">Gift Packages</a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">No officer purchases found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (method_exists($users, 'links'))
            <div class="card-footer bg-white border-top">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // cascading branch options by bank
            document.addEventListener('DOMContentLoaded', function() {
                const bankSelect = document.getElementById('filter-bank');
                const branchSelect = document.getElementById('filter-branch');

                function filterBranches() {
                    const bankVal = bankSelect.value;
                    Array.from(branchSelect.options).forEach(function(opt) {
                        if (!opt.dataset.bank) return;
                        opt.style.display = (!bankVal || opt.dataset.bank === bankVal) ? '' : 'none';
                    });
                    if (branchSelect.value && branchSelect.selectedOptions[0].style.display === 'none') {
                        branchSelect.value = '';
                    }
                }

                if (bankSelect && branchSelect) {
                    bankSelect.addEventListener('change', filterBranches);
                    filterBranches();
                }
            });
        </script>
    @endpush
@endsection
