@extends('layouts.admin')

@section('title', 'Gift Packages for Officer')
@section('dashboard-title', 'Gift Packages')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Gift Packages for {{ $user->name }}</h4>
        <a href="{{ route('super-admin.package-orders.officer-purchases') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse($giftPackages as $pkg)
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="mb-2">{{ $pkg->name }}</h5>
                        <p class="mb-1">Leads: <strong>{{ $pkg->number_of_leads }}</strong></p>
                        <p class="mb-2">Price: <strong>৳{{ number_format($pkg->price, 2) }}</strong></p>
                        <p class="text-muted small">{{ Str::limit($pkg->description, 120) }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <form method="POST" action="{{ route('super-admin.package-orders.gift.assign', $user) }}">
                            @csrf
                            <input type="hidden" name="lead_package_id" value="{{ $pkg->id }}">
                            <button type="submit" class="btn btn-success w-100"
                                onclick="return confirm('Assign this gift package to {{ addslashes($user->name) }}?')">Give
                                Gift</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No gift packages available.</p>
            </div>
        @endforelse
    </div>
@endsection
