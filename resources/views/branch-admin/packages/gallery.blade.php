@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <style>
            .package-card {
                position: relative;
            }

            .package-ribbon {
                position: absolute;
                top: 12px;
                left: 0;
                transform: translate(-10%, -50%);
                padding: 6px 10px;
                border-radius: 0 8px 8px 0;
                color: #fff;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.725rem;
                letter-spacing: 0.6px;
            }

            .package-card.premium .package-ribbon {
                background: linear-gradient(135deg, #f6c24b, #f59e0b);
                color: #222;
            }

            .package-card.regular .package-ribbon {
                background: #6c757d;
            }

            .package-card .card {
                border: none;
                overflow: visible;
            }

            .package-card.premium .card {
                box-shadow: 0 8px 20px rgba(245, 158, 11, 0.12);
                border-radius: .75rem;
            }

            .package-card.regular .card {
                box-shadow: 0 6px 16px rgba(33, 37, 41, 0.04);
                border-radius: .5rem;
            }

            .package-price {
                font-size: 1.25rem;
                font-weight: 700;
                color: #0d6efd;
            }

            .package-leads {
                font-weight: 600;
                color: #343a40;
            }

            .package-card .card-body h5 {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: .5rem;
            }

            .package-card .card-footer {
                background: transparent;
                border-top: none;
            }
        </style>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Lead Packages</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            $regulars = $packages->where('type', 'regular');
            $premiums = $packages->where('type', 'premium');
        @endphp

        @if ($regulars->isNotEmpty())
            <h4 class="mb-3 mt-2">Regular Packages</h4>
            <div class="row g-3 mb-4">
                @foreach ($regulars as $package)
                    <div class="col-md-4">
                        <div class="package-card regular">
                            <div class="package-ribbon">Regular</div>
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>
                                        <span>{{ $package->name }}</span>
                                        <span class="package-price">৳{{ number_format($package->price, 2) }}</span>
                                    </h5>

                                    <p class="mb-1 package-leads">Leads: <strong>{{ $package->number_of_leads }}</strong>
                                    </p>
                                    <p class="text-muted small mb-3">{{ Str::limit($package->description, 100) }}</p>
                                </div>
                                <div class="card-footer bg-white">
                                    <a href="{{ route('branch-admin.packages.purchase.form', $package) }}"
                                        class="btn btn-primary w-100">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($premiums->isNotEmpty())
            <h4 class="mb-3 mt-4">Premium Packages</h4>
            <div class="row g-3">
                @foreach ($premiums as $package)
                    <div class="col-md-4">
                        <div class="package-card premium">
                            <div class="package-ribbon">Premium</div>
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>
                                        <span>{{ $package->name }}</span>
                                        <span class="package-price">৳{{ number_format($package->price, 2) }}</span>
                                    </h5>

                                    <p class="mb-1 package-leads">Leads: <strong>{{ $package->number_of_leads }}</strong>
                                    </p>
                                    <p class="mb-2"><small
                                            class="text-warning">{{ Str::limit($package->description, 100) }} </small></p>
                                </div>
                                <div class="card-footer bg-white">
                                    <a href="{{ route('branch-admin.packages.purchase.form', $package) }}"
                                        class="btn btn-primary w-100">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
