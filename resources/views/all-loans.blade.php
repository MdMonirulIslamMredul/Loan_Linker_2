@extends('layouts.landing')

@section('title', 'All Loans - Loan Maker')

@section('content')
    <!-- Header -->
    <section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Browse All Loan Offers</h1>
            <p class="lead">Discover and compare loan options from Bangladesh's leading banks</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="bg-white py-4 shadow-sm sticky-top" style="top: 80px; z-index: 40;">
        <div class="container">
            <form action="{{ route('loans.all') }}" method="GET" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Bank Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label for="bank" class="form-label fw-semibold">
                            <i class="bi bi-building me-2"></i>Filter by Bank
                        </label>
                        <select name="bank" id="bank" class="form-select"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Banks</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}" {{ $bankId == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label for="category" class="form-label fw-semibold">
                            <i class="bi bi-tags me-2"></i>Filter by Category
                        </label>
                        <select name="category" id="category" class="form-select"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Loan Name Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label for="loan_name" class="form-label fw-semibold">
                            <i class="bi bi-search me-2"></i>Filter by Loan Name
                        </label>
                        <input type="text" name="loan_name" id="loan_name" class="form-control"
                            placeholder="Enter loan name..." value="{{ $loanName }}">
                    </div>

                    <!-- Buttons -->
                    <div class="col-lg-3 col-md-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-funnel me-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('loans.all') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Loans Grid -->
    <section class="py-5 bg-light min-vh-100">
        <div class="container">
            @if ($loans->count() > 0)
                <!-- Results Count -->
                <div class="mb-4">
                    <p class="text-muted">
                        Showing <span class="fw-semibold text-dark">{{ $loans->total() }}</span> loan(s)
                        @if ($bankId || $categoryId || $loanName)
                            with applied filters
                        @endif
                    </p>
                </div>

                <!-- Loans Grid -->
                <div class="row g-4 mb-4">
                    @foreach ($loans as $loan)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-lift">
                                @if ($loan->banner)
                                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                                        <img src="{{ asset($loan->banner) }}" class="card-img-top h-100 object-fit-cover"
                                            alt="{{ $loan->name }}">
                                        <span
                                            class="position-absolute top-0 end-0 m-3 badge bg-primary fs-6">{{ $loan->interest_rate }}%
                                            APR</span>
                                    </div>
                                @else
                                    <div class="position-relative d-flex align-items-center justify-content-center bg-gradient"
                                        style="height: 200px; background: linear-gradient(135deg, #E0F2FE 0%, #DDD6FE 100%);">
                                        <div class="text-center">
                                            <i class="bi bi-cash-coin display-1 text-primary opacity-25"></i>
                                        </div>
                                        <span
                                            class="position-absolute top-0 end-0 m-3 badge bg-primary fs-6">{{ $loan->interest_rate }}%
                                            APR</span>
                                    </div>
                                @endif

                                <div class="card-body">
                                    @if ($loan->branch && $loan->branch->bank)
                                        <div class="d-flex align-items-center mb-3">
                                            @if ($loan->branch->bank->logo)
                                                <img src="{{ asset($loan->branch->bank->logo) }}"
                                                    alt="{{ $loan->branch->bank->name }}"
                                                    style="width: 40px; height: 40px; object-fit: contain;" class="me-2">
                                            @endif
                                            <small class="text-muted">{{ $loan->branch->bank->name }} </small>
                                            <small class="text-muted">, {{ $loan->branch->name }} Branch</small>
                                        </div>
                                    @endif

                                    <h5 class="card-title fw-bold mb-2" style="min-height: 50px;">{{ $loan->name }}</h5>

                                    @if ($loan->category)
                                        <div class="mb-2">
                                            <span class="badge bg-info text-dark"><i
                                                    class="bi bi-tag-fill me-1"></i>{{ $loan->category->name }}</span>
                                        </div>
                                    @endif

                                    <p class="card-text text-muted" style="min-height: 60px;">
                                        {{ Str::limit($loan->description, 100) }}</p>

                                    <div class="row g-2 mb-3 small">
                                        @if ($loan->min_amount && $loan->max_amount)
                                            <div class="col-6">
                                                <div class="text-muted">Amount Range</div>
                                                <div class="fw-semibold">৳{{ number_format($loan->min_amount / 1000) }}K -
                                                    ৳{{ number_format($loan->max_amount / 1000) }}K</div>
                                            </div>
                                        @endif
                                        @if ($loan->min_tenure_months && $loan->max_tenure_months)
                                            <div class="col-6">
                                                <div class="text-muted">Tenure</div>
                                                <div class="fw-semibold">
                                                    {{ $loan->min_tenure_months }}-{{ $loan->max_tenure_months }} months
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary flex-fill">View
                                            Details</a>
                                        <a href="#" class="btn btn-outline-secondary">
                                            <i class="bi bi-share"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($loans->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $loans->appends(['bank' => $bankId, 'loan_name' => $loanName])->links() }}
                    </div>
                @endif
            @else
                <!-- No Results -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                    </div>
                    <h3 class="fw-bold mb-3">No Loans Found</h3>
                    <p class="text-muted mb-4">We couldn't find any loans matching your filters.</p>
                    <a href="{{ route('loans.all') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
        <div class="container">
            <h2 class="display-6 fw-bold mb-3">Need Help Finding the Right Loan?</h2>
            <p class="lead mb-4">Use our search feature to find specific loan options</p>
            <a href="{{ route('search') }}" class="btn btn-light btn-lg shadow">
                <i class="bi bi-search me-2"></i>Search Loans
            </a>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>
@endpush
