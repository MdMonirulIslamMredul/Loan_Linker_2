@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Officer Details</h4>

            <div class="mb-4">
                <h5>Request #{{ $newApplication->id }}</h5>
                <p><strong>Service Category:</strong> {{ ucfirst(str_replace('_', ' ', $newApplication->service_category)) }}</p>
                <p><strong>Service Type:</strong> {{ ucfirst(str_replace('_', ' ', $newApplication->service_type)) }}</p>
                <p><strong>Expected Amount:</strong> ৳{{ number_format($newApplication->expected_amount, 2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($newApplication->status) }}</p>
            </div>

            @foreach ($unlocks as $access)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Officer: {{ optional($access->officer)->name ?? 'Unknown officer' }}</h5>
                        <p><strong>Email:</strong> {{ optional($access->officer)->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ optional($access->officer)->phone ?? 'N/A' }}</p>
                        <p><strong>Officer Role:</strong> {{ optional($access->officer)->role ?? 'N/A' }}</p>
                        <p><strong>Unlocked At:</strong> {{ optional($access->purchased_at)->format('M d, Y H:i') ?? optional($access->created_at)->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            @endforeach

            <a href="{{ route('customer.applications') }}" class="btn btn-secondary">Back to requests</a>
        </div>
    </div>
@endsection
