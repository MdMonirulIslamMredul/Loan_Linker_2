@extends('layouts.admin')

@section('title', 'All Loans')
@section('dashboard-title', 'Super Admin - Loan Management')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">All Loans</h2>
                <a href="{{ route('super-admin.loans.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Loan
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($loans->isEmpty())
                <p class="text-muted">No loans available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Banner</th>
                                <th>Loan Name</th>
                                <th>Category</th>
                                <th>Branch</th>
                                <th>Bank</th>
                                <th>Interest Rate</th>
                                <th>Amount Range</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                                <tr>
                                    <td>{{ $loan->id }}</td>
                                    <td>
                                        @if ($loan->banner)
                                            <img src="{{ asset($loan->banner) }}" alt="{{ $loan->name }} Banner"
                                                class="rounded" style="height: 48px; width: 80px; object-fit: cover;">
                                        @else
                                            <span class="text-muted small">No banner</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $loan->name }}</td>
                                    <td>
                                        @if ($loan->category)
                                            <span class="badge bg-info">{{ $loan->category->name }}</span>
                                        @else
                                            <span class="text-muted small">Uncategorized</span>
                                        @endif
                                    </td>
                                    <td>{{ $loan->branch->name }}</td>
                                    <td>{{ $loan->branch->bank->name }}</td>
                                    <td>
                                        {{ $loan->interest_rate ? $loan->interest_rate . '%' : 'N/A' }}
                                    </td>
                                    <td class="small">
                                        @if ($loan->min_amount || $loan->max_amount)
                                            {{ $loan->min_amount ? '₹' . number_format($loan->min_amount) : 'N/A' }} -
                                            {{ $loan->max_amount ? '₹' . number_format($loan->max_amount) : 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $loan->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $loan->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $loan->created_at->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('super-admin.loans.edit', $loan) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.loans.destroy', $loan) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this loan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
