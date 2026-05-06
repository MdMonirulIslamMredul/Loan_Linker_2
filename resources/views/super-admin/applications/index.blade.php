@extends('layouts.admin')


@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-file-text-fill fs-2 text-primary"></i>
                            </div>
                            <div>
                                <h2 class="mb-1 fw-bold text-dark">Loan Applications</h2>
                                <p class="mb-0 text-muted">Manage and review all customer loan applications</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total Applications</p>
                                <h3 class="mb-0 fw-bold">{{ $applications->total() }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-files text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Pending Review</p>
                                <h3 class="mb-0 fw-bold text-warning">
                                    {{ $applications->where('status', 'pending')->count() }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Approved</p>
                                <h3 class="mb-0 fw-bold text-success">
                                    {{ $applications->where('status', 'approved')->count() }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Rejected</p>
                                <h3 class="mb-0 fw-bold text-danger">
                                    {{ $applications->where('status', 'rejected')->count() }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-x-circle text-danger fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Applications</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('super-admin.applications.index') }}" class="row g-3">

                    <div class="col-md-3">
                        <label for="bank_id" class="form-label fw-semibold">Bank</label>
                        <select name="bank_id" id="bank_id" class="form-select">
                            <option value="">All Banks</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="branch_id" class="form-label fw-semibold">Branch</label>
                        <select name="branch_id" id="branch_id" class="form-select">
                            <option value="">All Branches</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}
                                    ({{ $branch->code ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="category_id" class="form-label fw-semibold">Loan Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Any Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="loan_name" class="form-label fw-semibold">
                            <i class="bi bi-search me-1"></i>Loan Name
                        </label>
                        <input type="text" name="loan_name" id="loan_name" class="form-control"
                            value="{{ request('loan_name') }}" placeholder="Enter loan name">
                    </div>

                    <div class="col-md-3">
                        <label for="from_date" class="form-label fw-semibold">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="to_date" class="form-label fw-semibold">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label fw-semibold">
                            <i class="bi bi-tag me-1"></i>Filter by Status
                        </label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under
                                Review</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary px-4 me-2">
                            <i class="bi bi-filter me-2"></i>Apply Filter
                        </button>
                        <a href="{{ route('super-admin.applications.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-table me-2"></i>Applications List</h5>
                    <span class="badge bg-primary rounded-pill">{{ $applications->total() }} Total</span>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="py-3">Applicant Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Phone</th>
                                    <th class="py-3">Bank</th>
                                    <th class="py-3">Branch</th>
                                    <th class="py-3">Loan Type</th>
                                    <th class="py-3">Amount</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Applied Date</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                    <tr>
                                        <td class="px-4">
                                            <span class="badge bg-secondary">#{{ $application->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person text-primary"></i>
                                                </div>
                                                <strong>{{ $application->full_name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-envelope me-1"></i>{{ $application->email }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>{{ $application->phone }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-building me-1"></i>{{ $application->loan->branch->bank->name ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-geo-alt me-1"></i>{{ $application->loan->branch->name ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                <i
                                                    class="bi bi-cash-stack me-1"></i>{{ $application->loan->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong
                                                class="text-success">৳{{ number_format($application->loan_amount, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if ($application->status == 'pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-clock-history me-1"></i>Pending
                                                </span>
                                            @elseif($application->status == 'under_review')
                                                <span class="badge bg-info text-dark">
                                                    <i class="bi bi-eye me-1"></i>Under Review
                                                </span>
                                            @elseif($application->status == 'approved')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Approved
                                                </span>
                                            @elseif($application->status == 'rejected')
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-calendar3 me-1"></i>{{ $application->created_at->format('d M, Y') }}
                                            </small>
                                        </td>
                                        <td class="px-4">
                                            <a href="{{ route('super-admin.applications.show', $application) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye me-1"></i>View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of
                                {{ $applications->total() }} applications
                            </div>
                            <div>
                                {{ $applications->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">No Applications Found</h5>
                        <p class="text-muted">There are no loan applications matching your filters.</p>
                        <a href="{{ route('super-admin.applications.index') }}" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankSelect = document.getElementById('bank_id');
            const branchSelect = document.getElementById('branch_id');

            async function fetchBranches(bankId, preselected) {
                branchSelect.innerHTML = '<option>Loading...</option>';
                if (!bankId) {
                    branchSelect.innerHTML = '<option value="">All Branches</option>';
                    return;
                }
                try {
                    const res = await fetch("{{ url('/api/banks') }}/" + bankId + "/branches", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) throw new Error('Network error');
                    const data = await res.json();
                    let html = '<option value="">All Branches</option>';
                    if (data.length === 0) {
                        html += '<option value="" disabled>No branches</option>';
                    } else {
                        data.forEach(b => {
                            const selected = preselected && preselected == b.id ? ' selected' : '';
                            const code = b.code ? ' (' + b.code + ')' : '';
                            html += `<option value="${b.id}"${selected}>${b.name}${code}</option>`;
                        });
                    }
                    branchSelect.innerHTML = html;
                } catch (e) {
                    branchSelect.innerHTML = '<option value="">All Branches</option>';
                }
            }

            bankSelect?.addEventListener('change', function(e) {
                fetchBranches(this.value);
            });

            const initialBank = bankSelect?.value;
            const initialBranch = "{{ request('branch_id') }}";
            if (initialBank) fetchBranches(initialBank, initialBranch);
        });
    </script>
@endpush
