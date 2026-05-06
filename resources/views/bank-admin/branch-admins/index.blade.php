@extends('layouts.bank-admin')

@section('title', 'Branch Admins')
@section('dashboard-title', 'Bank Admin - Branch Admins')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Branch Admins</h4>
                <a href="{{ route('bank-admin.branch-admins.create') }}" class="btn btn-primary">Create Branch Admin</a>
            </div>

            @if ($branchAdmins->isEmpty())
                <p class="text-muted">No branch admins found. <a href="{{ route('bank-admin.branch-admins.create') }}">Create
                        one now</a>.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Branch</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branchAdmins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td class="fw-semibold">{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->branch->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('bank-admin.branch-admins.edit', $admin) }}"
                                            class="btn btn-sm btn-outline-primary me-2">Edit</a>
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
