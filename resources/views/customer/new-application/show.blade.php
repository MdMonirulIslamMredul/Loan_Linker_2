@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4>Application #{{ $newApplication->id }}</h4>
                    <p class="text-muted mb-0">Submitted {{ $newApplication->created_at->format('M d, Y') }}</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-secondary">{{ ucfirst($newApplication->status) }}</span>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Loan Details</h6>
                        <p><strong>Service Category:</strong> {{ ucfirst(str_replace('_', ' ', $newApplication->service_category)) }}</p>
                        <p><strong>Service Type:</strong> {{ ucfirst(str_replace('_', ' ', $newApplication->service_type)) }}</p>
                        <p><strong>Expected Amount:</strong> ৳{{ number_format($newApplication->expected_amount, 2) }}</p>
                        <p><strong>Tenure:</strong> {{ $newApplication->tenure_months }} months</p>
                    </div>
                    <div class="mb-3">
                        <h6>Selected Banks</h6>
                        <p>
                            @if (!empty($newApplication->bank_ids))
                                {{ collect($newApplication->bank_ids)
                                    ->map(fn($bankId) => optional($banks->get($bankId))->name)
                                    ->filter()
                                    ->join(', ') ?: 'N/A' }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Customer</h6>
                        <p><strong>Name:</strong> {{ optional($newApplication->customer)->name ?? 'You' }}</p>
                        <p><strong>Email:</strong> {{ optional($newApplication->customer)->email ?? auth()->user()->email }}</p>
                    </div>
                    <div>
                        <h6>Notes</h6>
                        <p>{{ $newApplication->additional_notes ?: 'No additional notes provided.' }}</p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-3">Officer Unlocks</h6>
                    @if ($newApplication->leadAccesses->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Officer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Unlocked</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($newApplication->leadAccesses as $access)
                                        <tr>
                                            <td>{{ optional($access->officer)->name ?? 'Unknown' }}</td>
                                            <td>{{ optional($access->officer)->email ?? 'N/A' }}</td>
                                            <td>{{ optional($access->officer)->phone ?? 'N/A' }}</td>
                                            <td>{{ optional($access->purchased_at)->format('M d, Y') ?? optional($access->created_at)->format('M d, Y') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.new_application.officer_details', ['newApplication' => $newApplication, 'officer' => $access->officer_id]) }}" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">No officer details are available yet. Unlock an officer to view contact and official details.</div>
                    @endif
                </div>
            </div>

            @if ($newApplication->bankOfficerRatings->isNotEmpty())
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Your Officer Ratings</h6>
                        <p class="mb-1"><strong>Average Rating:</strong> {{ number_format($newApplication->bankOfficerRatings->avg('rating'), 1) }} / 5</p>
                        <p class="mb-0"><strong>Total Ratings:</strong> {{ $newApplication->bankOfficerRatings->count() }}</p>
                    </div>
                </div>
            @endif

            <div class="mt-4 d-flex gap-2 flex-wrap">
                <a href="{{ route('customer.applications') }}" class="btn btn-outline-secondary">Back to Applications</a>
                @if ($newApplication->status === 'pending')
                    <a href="{{ route('customer.application.edit', $newApplication->id) }}" class="btn btn-outline-primary">Edit Application</a>
                    <a href="{{ route('customer.application.delete', $newApplication->id) }}" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this application?');">Delete Application</a>
                @endif
            </div>
        </div>
    </div>
@endsection