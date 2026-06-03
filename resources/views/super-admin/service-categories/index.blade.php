@extends('layouts.admin')

@section('title', 'Service Categories')
@section('dashboard-title', 'Super Admin - Service Categories')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">Service Categories</h2>
                <a href="{{ route('super-admin.service-categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Service Category
                </a>
            </div>

            @if ($categories->isEmpty())
                <p class="text-muted">No service categories available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td class="fw-semibold">{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ Str::limit($category->description, 60) }}</td>
                                    <td>
                                        <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $category->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('super-admin.service-categories.edit', $category) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.service-categories.destroy', $category) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection

