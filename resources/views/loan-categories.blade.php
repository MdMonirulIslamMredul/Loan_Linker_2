@extends('layouts.landing')

@section('title', 'Loan Categories')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-5 fw-bold">Service Categories</h1>
            <p class="lead text-muted">Browse all available service categories and explore products tailored to your needs.</p>
        </div>
    </div>

    @if($loanCategories->isEmpty())
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="alert alert-info">No service categories are available at the moment.</div>
            </div>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($loanCategories as $category)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            
                            @if($category->description)
                                <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($category->description, 120) }}</p>
                            @endif
                            <div class="mt-auto d-flex gap-2 flex-wrap">
                                <a href="{{ route('loan-categories.show', $category) }}" class="btn btn-outline-secondary btn-sm">Category Details</a>
                               
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
