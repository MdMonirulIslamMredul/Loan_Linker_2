@extends('layouts.branch-admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="mb-1">Ratings History</h4>
                    <p class="text-muted mb-0">Review ratings and view customers currently available for rating by your officer account.</p>
                </div>
                <div class="text-end">
                    <div class="text-muted">Total ratings</div>
                    <div class="h5 mb-0">{{ $ratingCount }}</div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-4">
                   

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted mb-2">Pending Ratings</h6>
                            <div class="h5 mb-0">{{ $pendingUnlocks->count() }}</div>
                            <p class="text-muted mb-0">Customers unlocked for rating that you have not rated yet.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Pending Customer Ratings</h5>
                        </div>
                        <div class="card-body">
                            @if ($pendingUnlocks->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Customer</th>
                                                <th>Request</th>
                                                <th>Unlocked</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendingUnlocks as $unlock)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('branch-admin.new-applications.customer-ratings', $unlock->newLoanApplication) }}" class="btn btn-outline-success">
                                                            {{ optional($unlock->newLoanApplication->customer)->name ?? 'Customer' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $unlock->newLoanApplication?->id ? 'Request #' . $unlock->newLoanApplication->id : 'N/A' }}</td>
                                                    <td>{{ optional($unlock->created_at)->format('d M, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('branch-admin.new-applications.show', ['newApplication' => $unlock->newLoanApplication]) }}" class="btn btn-sm btn-primary">View Application</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-success mb-0">No customers currently available for rating.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Rating History</h5>
                        </div>
                        <div class="card-body">
                            @if ($ratings->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Customer</th>
                                                <th>Request</th>
                                                <th>Rating</th>
                                                <th>Comment</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ratings as $rating)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('branch-admin.new-applications.customer-ratings', $rating->newLoanApplication) }}" class="btn btn-outline-success">
                                                            {{ optional($rating->customer)->name ?? 'Customer' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $rating->newLoanApplication?->id ? 'Request #' . $rating->newLoanApplication->id : 'N/A' }}</td>
                                                    <td>
                                                        <span class="text-warning">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="bi {{ $i <= $rating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                            @endfor
                                                        </span>
                                                        <span class="ms-1">{{ $rating->rating }}/5</span>
                                                    </td>
                                                    <td>{{ $rating->comment ?: 'No comment' }}</td>
                                                    <td>{{ optional($rating->created_at)->format('d M, Y') }}</td>
                                                   
                                                         <td>
                                                        <a href="{{ route('branch-admin.new-applications.show', ['newApplication' => $rating->newLoanApplication]) }}" class="btn btn-sm btn-primary">View Application</a>
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mb-0">No ratings found yet.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
