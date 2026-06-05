@extends('layouts.landing')

@section('title', $loanCategory->name . ' Category Details - Loan Linker')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        @if($loanCategory->image)
                            <div class="bg-light" style="height: 360px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('storage/' . $loanCategory->image) }}" alt="{{ $loanCategory->name }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </div>
                        @endif
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h1 class="display-6 fw-bold mb-2">{{ $loanCategory->name }}</h1>
                                    <p class="text-muted mb-0">Loan category details page with no loan listings.</p>
                                </div>
                                <a href="{{ route('loan-categories.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i>Back to Categories
                                </a>
                            </div>

                            @if($loanCategory->description)
                                <p class="mb-4">{{ $loanCategory->description }}</p>
                            @endif

                            @if($loanCategory->long_description)
                                <div class="mb-4">
                                    {!! $loanCategory->long_description !!}
                                </div>
                            @endif

                            {{-- <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="bg-white rounded-3 p-4 border">
                                        <h6 class="text-uppercase text-muted mb-2">Status</h6>
                                        <p class="mb-0">{{ $loanCategory->is_active ? 'Active' : 'Inactive' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="bg-white rounded-3 p-4 border">
                                        <h6 class="text-uppercase text-muted mb-2">More Information</h6>
                                        <p class="mb-0">This page shows only category details and no loan products. Use the buttons below to view related loans or return to the category list.</p>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="mt-4 d-flex flex-wrap gap-2">
                                <a href="{{ route('customer.new_application.create') }}" class="btn btn-primary">Apply Now</a>
                                <a href="{{ route('loan-categories.index') }}" class="btn btn-outline-secondary">Back to All Categories</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
