@extends('layouts.admin')

@section('title', 'Bank Officer Ratings')
@section('dashboard-title', 'Bank Officer Ratings')

@section('content')
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('super-admin.ratings.bank-officer') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" id="search" name="search" value="{{ old('search', $search) }}" class="form-control" placeholder="Search by officer or customer name, email or phone">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-12 mt-2">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                        <div class="text-muted small">Total ratings: <strong>{{ $ratingCount }}</strong></div>
                        <div class="text-muted small">Average rating: <strong>{{ $averageRating ? number_format($averageRating, 1) : 'N/A' }}</strong></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($ratings->isEmpty())
                <div class="text-center p-5">
                    <i class="bi bi-people-fill text-muted display-4"></i>
                    <p class="text-muted mt-3 mb-0">No bank officer ratings found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Officer</th>
                                <th>Given By</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Request</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ratings as $rating)
                                <tr>
                                    <td>
                                        @if ($rating->officer)
                                            <a href="{{ route('super-admin.ratings.user.details', ['type' => 'bank_officer', 'user' => $rating->officer->id]) }}" class="btn btn-outline-success">
                                                <strong>{{ $rating->officer->name }}</strong>
                                            </a>
                                            <div class="small text-muted">{{ $rating->officer->email ?? 'No email' }}</div>
                                            
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($rating->customer)
                                            <a href="{{ route('super-admin.ratings.user.details', ['type' => 'customer', 'user' => $rating->customer->id]) }}" class="btn btn-outline-primary">
                                                <strong>{{ $rating->customer->name }}</strong>
                                            </a>
                                            <div class="small text-muted">{{ $rating->customer->email ?? 'No email' }}</div>
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
