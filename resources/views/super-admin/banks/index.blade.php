@extends('layouts.admin')

@section('title', 'All Banks')
@section('dashboard-title', 'Super Admin - All Banks')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold">All Banks</h2>
            <a href="{{ route('super-admin.banks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Create New Bank
            </a>
        </div>

        @if($banks->isEmpty())
            <p class="text-muted">No banks available.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Bank Name</th>

                            <th>Code</th>
                            <th>Branches</th>
                            <th>Users</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                            <tr>
                                <td>{{ $bank->id }}</td>
                                <td>
                                    @if($bank->logo)
                                        <img src="{{ asset($bank->logo) }}" alt="{{ $bank->name }} Logo" style="height: 48px; width: 48px; object-fit: contain;">
                                    @else
                                        <span class="text-muted small">No logo</span>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $bank->name }}</td>
                                <td>{{ $bank->code }}</td>
                                <td>{{ $bank->branches_count }}</td>
                                <td>{{ $bank->users_count }}</td>
                                <td>
                                    <span class="badge {{ $bank->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $bank->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $bank->created_at->format('Y-m-d') }}
                                </td>
                                <td>
                                    <a href="{{ route('super-admin.banks.edit', $bank) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('super-admin.banks.destroy', $bank) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this bank?');">
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
