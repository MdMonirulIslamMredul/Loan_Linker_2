@extends('layouts.admin')

@section('title', 'Service Types')
@section('dashboard-title', 'Super Admin - Service Types')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">Service Types</h2>
                <a href="{{ route('super-admin.service-types.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Service Type
                </a>
            </div>

            @if ($types->isEmpty())
                <p class="text-muted">No service types available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr>
                                    <td>{{ $type->id }}</td>
                                    <td class="fw-semibold">{{ $type->name }}</td>
                                    <td>{{ optional($type->serviceCategory)->name ?? '—' }}</td>
                                    <td>{{ $type->slug }}</td>
                                    <td>{{ Str::limit($type->description, 60) }}</td>
                                    <td>
                                        <span class="badge {{ $type->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $type->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $type->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('super-admin.service-types.edit', $type) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.service-types.destroy', $type) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this service type?');">
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

                <div class="mt-4">
                    {{ $types->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
