@extends('layouts.bank-admin')

@section('title', 'All Branches')
@section('dashboard-title', 'Bank Admin - All Branches')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">All Branches</h4>
                <a href="{{ route('bank-admin.branches.create') }}" class="btn btn-primary">Create New Branch</a>
            </div>

            @if ($branches->isEmpty())
                <p class="text-muted">No branches available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Branch Name</th>
                                <th>Code</th>
                                <th>City</th>
                                <th>Phone</th>
                                <th>Users</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $branch->id }}</td>
                                    <td class="fw-semibold">{{ $branch->name }}</td>
                                    <td>{{ $branch->code }}</td>
                                    <td>{{ $branch->city ?? 'N/A' }}</td>
                                    <td>{{ $branch->phone ?? 'N/A' }}</td>
                                    <td>{{ $branch->users_count }}</td>
                                    <td>
                                        @if ($branch->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('bank-admin.branches.edit', $branch) }}"
                                            class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                        <form action="{{ route('bank-admin.branches.destroy', $branch) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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
