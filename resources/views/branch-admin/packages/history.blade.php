@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="bi bi-clock-history me-2"></i>Purchase History</h2>
                <p class="text-muted">Your package purchase requests and approvals.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Package</label>
                        <select name="package_id" class="form-select">
                            <option value="">All Packages</option>
                            @foreach ($packages ?? [] as $pkg)
                                <option value="{{ $pkg->id }}"
                                    {{ request('package_id') == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">From</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">To</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('branch-admin.packages.history') }}"
                                class="btn btn-outline-secondary ms-1">Reset</a>
                        </div>
                    </div>
                </form>

                @if ($orders->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">No purchases found.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Package</th>
                                    <th>Leads</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Requested</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->leadPackage->name ?? '-' }}</td>
                                        <td>{{ $order->number_of_leads }}</td>
                                        <td>{{ number_format($order->price, 2) }}</td>
                                        <td>
                                            @if ($order->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                                        <td>{{ $order->updated_by ? App\Models\User::find($order->updated_by)->name : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            @if ($orders->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
