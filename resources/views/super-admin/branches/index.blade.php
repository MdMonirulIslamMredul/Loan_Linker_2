@extends('layouts.admin')

@section('title', 'All Branches')
@section('dashboard-title', 'Super Admin - All Branches')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">All Branches</h2>
                <a href="{{ route('super-admin.branches.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Branch
                </a>
            </div>

            @if ($branches->isEmpty())
                <p class="text-muted">No branches available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Bank</th>
                                <th>Branch Name</th>
                                <th>Code</th>
                                <th>City</th>
                                <th>Phone</th>
                                <th>Officers / Admins</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $branch->id }}</td>
                                    <td>{{ $branch->bank->name }}</td>
                                    <td class="fw-semibold">{{ $branch->name }}</td>
                                    <td>{{ $branch->code }}</td>
                                    <td>{{ $branch->city ?? 'N/A' }}</td>
                                    <td>{{ $branch->phone ?? 'N/A' }}</td>
                                    <td>{{ $branch->users_count }}</td>
                                    <td>
                                        <span class="badge {{ $branch->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('super-admin.branches.edit', $branch) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.branches.destroy', $branch) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this branch?');">
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
