@extends('layouts.admin')

@section('title', $type === 'customer' ? 'Customer Rating Details' : ($type === 'bank_officer' ? 'Bank Officer Rating Details' : 'Branch Admin Rating Details'))
@section('dashboard-title', $type === 'customer' ? 'Customer Rating Details' : ($type === 'bank_officer' ? 'Bank Officer Rating Details' : 'Branch Admin Rating Details'))

@section('content')
    <div class="mb-4">
        <a href="{{ $type === 'bank_officer' ? route('super-admin.ratings.bank-officer') : route('super-admin.ratings.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Ratings
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-4">
                    <small class="text-muted d-block">{{ $type === 'customer' ? 'Customer' : ($type === 'bank_officer' ? 'Bank Officer' : 'Branch Admin') }}</small>
                    <strong>{{ $user->name }}</strong>
                    <div class="small text-muted">{{ $user->email ?? 'N/A' }}</div>
                    <div class="small text-muted">{{ $user->phone ?? 'N/A' }}</div>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Total Ratings</small>
                    <strong>{{ $ratingCount }}</strong>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Average Rating</small>
                    <strong>{{ $averageRating ? number_format($averageRating, 1) : 'N/A' }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Rating Records</h5>
        </div>
        <div class="card-body p-0">
            @if ($ratings->isEmpty())
                <div class="text-center p-5">
                    <i class="bi bi-star text-muted display-4"></i>
                    <p class="text-muted mt-3 mb-0">No ratings found for this {{ $type === 'customer' ? 'customer' : 'branch admin' }}.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ $type === 'customer' ? 'Branch Admin' : 'Customer' }}</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Request</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ratings as $rating)
                                @php
                                    if ($type === 'customer') {
                                        $relatedUser = $rating->branchAdmin;
                                    } elseif ($type === 'branch_admin') {
                                        $relatedUser = $rating->customer;
                                    } else {
                                        $relatedUser = $rating->customer;
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        @if ($relatedUser)
                                            <strong>{{ $relatedUser->name }}</strong>
                                            <div class="small text-muted">{{ $relatedUser->email ?? 'No email' }}</div>
                                            <div class="small text-muted">{{ $relatedUser->phone ?? 'No phone' }}</div>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $rating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="small text-muted">{{ $rating->rating }}/5</div>
                                    </td>
                                    <td>{{ $rating->comment ?: 'No comment' }}</td>
                                    <td>{{ $rating->newLoanApplication?->id ? 'Request #' . $rating->newLoanApplication->id : 'N/A' }}</td>
                                    <td>{{ $rating->created_at?->format('d M, Y') ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if ($ratings->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-center">{{ $ratings->links('pagination::bootstrap-5') }}</div>
            </div>
        @endif
    </div>
@endsection
