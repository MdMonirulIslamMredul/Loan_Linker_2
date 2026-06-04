@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="bi bi-file-earmark-plus me-2"></i>New Loan Requests</h2>
                <p class="text-muted">Manage, filter and review incoming customer loan requests.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $user = auth()->user();
            $hasAnyLeads = false;

            if ($user->isSuperAdmin() || $user->isBankAdmin() || $user->isBranchAdmin()) {
                $hasAnyLeads = true;
            } else {
                $hasAnyLeads =
                    (int) ($user->lead_balance ?? 0) > 0 ||
                    \App\Models\LeadAccess::where('officer_id', $user->id)
                        ->whereNotNull('newloan_id')
                        ->exists();
            }
        @endphp

        @unless ($hasAnyLeads)
            <div class="alert alert-info">
                You don't have any purchased leads. <a href="{{ route('branch-admin.packages.gallery') }}"
                    class="alert-link">Purchase a package</a> to unlock new loan requests.
            </div>
        @endunless

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('branch-admin.new-applications.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="review" {{ request('status') == 'review' ? 'selected' : '' }}>Review</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="service_category_id" class="form-label">Service Category</label>
                        <select name="service_category_id" id="service_category_id" class="form-select">
                            <option value="">Any Category</option>
                            @foreach($serviceCategories as $category)
                                <option value="{{ $category->id }}" {{ request('service_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="service_type_id" class="form-label">Service Type</label>
                        <select name="service_type_id" id="service_type_id" class="form-select">
                            <option value="">Any Type</option>
                            @foreach($serviceCategories as $category)
                                @foreach($category->serviceTypes as $type)
                                    <option value="{{ $type->id }}" data-category-id="{{ $category->id }}" {{ request('service_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="col-md-3">
                        <label for="bank_id" class="form-label">Bank</label>
                        <select name="bank_id" id="bank_id" class="form-select">
                            <option value="">Any Bank</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="col-md-3">
                        <label for="district_id" class="form-label">District</label>
                        <select name="district_id" id="district_id" class="form-select">
                            <option value="">Any District</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('branch-admin.new-applications.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if ($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                    <th>Tenure</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    {{-- <th>Banks</th> --}}
                                    <th>Status</th>
                                    <th>Requested</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                    <tr>
                                        <td><strong>#{{ $application->id }}</strong></td>
                                        @php
                                            $canView = false;
                                            if ($user->isSuperAdmin() || $user->isBankAdmin()) {
                                                $canView = true;
                                            } else {
                                                $canView = \App\Models\LeadAccess::where('officer_id', $user->id)
                                                    ->where('newloan_id', $application->id)
                                                    ->exists();
                                            }
                                        @endphp
                                        <td>{{ optional($application->customer)->name ?? 'Guest' }}</td>
                                        <td>{{ $canView ? (optional($application->customer)->email ?? 'N/A') : 'Locked' }}</td>
                                        <td><strong>৳{{ number_format($application->expected_amount, 2) }}</strong></td>
                                        <td>{{ $application->tenure_months }} mo</td>
                                        {{-- <td class="text-capitalize">{{ str_replace('_', ' ', $application->service_category) }}</td>
                                        <td class="text-capitalize">{{ str_replace('_', ' ', $application->service_type) }}</td> --}}
                                        <td class="text-capitalize">{{ optional($application->serviceCategory)->name ?? 'N/A' }}</td>
                                        <td class="text-capitalize">{{ optional($application->serviceType)->name ?? 'N/A' }}</td>
                                        {{-- <td>
                                            @php
                                                $bankNames = collect($application->bank_ids)->filter()->map(function ($bankId) use ($banks) {
                                                    return optional($banks->firstWhere('id', $bankId))->name;
                                                })->filter()->join(', ');
                                            @endphp
                                            {{ $bankNames ?: 'N/A' }}
                                        </td> --}}
                                        <td>
                                            @if ($application->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($application->status === 'review')
                                                <span class="badge bg-info">Review</span>
                                            @elseif ($application->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif ($application->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->format('d M, Y') }}</td>
                                        <td>
                                            @php
                                                $canView = false;
                                                if ($user->isSuperAdmin() || $user->isBankAdmin()) {
                                                    $canView = true;
                                                } else {
                                                    $canView = \App\Models\LeadAccess::where('officer_id', $user->id)
                                                        ->where('newloan_id', $application->id)
                                                        ->exists();
                                                }
                                            @endphp

                                            @if ($canView)
                                                <a href="{{ route('branch-admin.new-applications.show', $application) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                            @else
                                                @if ((int) ($user->lead_balance ?? 0) > 0)
                                                    <form action="{{ route('branch-admin.new-applications.unlock', $application) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-unlock me-1"></i>Unlock to View (1)
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('branch-admin.packages.gallery') }}"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        title="Purchase leads to view">
                                                        <i class="bi bi-cart me-1"></i>Buy Leads
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        {{ $applications->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">No new loan requests found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const categorySelect = document.getElementById('service_category_id');
                const typeSelect = document.getElementById('service_type_id');
                const typeOptions = Array.from(typeSelect.options);

                function filterTypes() {
                    const selectedCategory = categorySelect.value;

                    typeOptions.forEach(function (option) {
                        if (!option.value) {
                            option.style.display = '';
                            return;
                        }

                        const optionCategory = option.dataset.categoryId || '';
                        const shouldShow = !selectedCategory || String(optionCategory) === String(selectedCategory);
                        option.style.display = shouldShow ? '' : 'none';
                    });

                    if (selectedCategory) {
                        const currentValue = typeSelect.value;
                        const currentOption = typeSelect.querySelector('option[value="' + currentValue + '"]');
                        if (currentValue && currentOption && currentOption.style.display === 'none') {
                            typeSelect.value = '';
                        }
                    }
                }

                if (categorySelect && typeSelect) {
                    categorySelect.addEventListener('change', filterTypes);
                    filterTypes();
                }
            });
        </script>
    @endpush
@endsection
