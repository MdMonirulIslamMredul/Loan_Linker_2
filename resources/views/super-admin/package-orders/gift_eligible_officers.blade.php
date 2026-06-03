@extends('layouts.admin')

@section('title', 'Gift Eligible Officers')
@section('dashboard-title', 'Gift Eligible Officers')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Gift Eligible Officers</h4>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Bank</label>
                    <select id="filter-bank" name="bank_id" class="form-select">
                        <option value="">All Banks</option>
                        @foreach ($banks as $b)
                            <option value="{{ $b->id }}" {{ request('bank_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
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

                <div class="col-md-4">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, email or phone">
                </div>

                <div class="col-md-2 text-end align-self-end">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('super-admin.package-orders.gift.eligible') }}" class="btn btn-outline-secondary ms-1">Reset</a>
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
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ optional($user->bank)->name }}</td>
                            <td>{{ optional($user->branch)->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                                <span class="badge bg-info ms-1">Access Granted</span>
                            </td>
                            <td>
                                <a href="{{ route('super-admin.package-orders.gift.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                    Gift Packages
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No eligible officers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($users, 'links'))
            <div class="card-footer bg-white border-top">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
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

