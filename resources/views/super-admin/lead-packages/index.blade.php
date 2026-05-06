<!-- Lead Packages index -->
@extends('layouts.admin')

@section('title', 'Manage Lead Packages')
@section('dashboard-title', 'Manage Lead Packages')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i>All Lead Packages</h4>
        <a href="{{ route('super-admin.lead-packages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Package
        </a>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('super-admin.lead-packages.index') }}" class="d-flex">
                <select name="type" id="type" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">All types</option>
                    <option value="regular" {{ request('type') === 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="gift" {{ request('type') === 'gift' ? 'selected' : '' }}>Gift</option>
                    <option value="premium" {{ request('type') === 'premium' ? 'selected' : '' }}>Premium</option>
                </select>
                <button type="submit" class="btn btn-outline-secondary">Filter</button>
                @if (request()->filled('type'))
                    <a href="{{ route('super-admin.lead-packages.index') }}" class="btn btn-link ms-2">Reset</a>
                @endif
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($packages->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No lead packages found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">Name</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Price</th>
                                <th class="py-3">Leads</th>
                                <th class="py-3">Duration (days)</th>
                                <th class="py-3">Created</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>
                                        <strong>{{ $package->name }}</strong>
                                    </td>

                                    <td>
                                        <span
                                            class="badge bg-{{ $package->type === 'gift' ? 'success' : ($package->type === 'premium' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($package->type) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ number_format($package->price, 2) }}
                                    </td>
                                    <td>
                                        {{ $package->number_of_leads }}
                                    </td>
                                    <td>
                                        {{ $package->duration }}
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $package->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('super-admin.lead-packages.edit', $package) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('super-admin.lead-packages.destroy', $package) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this package?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if ($packages->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
@endsection
