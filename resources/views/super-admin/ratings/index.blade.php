@extends('layouts.admin')

@section('title', 'Ratings History')
@section('dashboard-title', 'Ratings History')

@section('content')
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('super-admin.ratings.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" id="search" name="search" value="{{ old('search', $search) }}" class="form-control" placeholder="Search by customer or branch admin name, email or phone">
                </div>
                {{-- <div class="col-md-4">
                    <label for="search_target" class="form-label">Filter by</label>
                    <select id="search_target" name="search_target" class="form-select">
                        <option value="" {{ $searchTarget === '' ? 'selected' : '' }}>All Users</option>
                        <option value="customer" {{ $searchTarget === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="branch_admin" {{ $searchTarget === 'branch_admin' ? 'selected' : '' }}>Branch Admin</option>
                    </select>
                </div> --}}
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
                    <i class="bi bi-star text-muted display-4"></i>
                    <p class="text-muted mt-3 mb-0">No ratings found matching your criteria.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Role</th>
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
                                        @if ($rating->customer)
                                            <a href="{{ route('super-admin.ratings.user.details', ['type' => 'customer', 'user' => $rating->customer->id]) }}" class="btn btn-outline-success">
                                                {{ $rating->customer->name }}
                                            </a>
                                            <div class="small text-muted">{{ $rating->customer->email ?? 'No email' }}</div>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>Customer</td>
                                    <td>
                                        @if ($rating->branchAdmin)
                                            <a href="{{ route('super-admin.ratings.user.details', ['type' => 'branch_admin', 'user' => $rating->branchAdmin->id]) }}" class="btn btn-outline-primary">
                                                {{ $rating->branchAdmin->name }}
                                            </a>
                                            <div class="small text-muted">{{ $rating->branchAdmin->email ?? 'No email' }}</div>
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
