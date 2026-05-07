@extends('layouts.admin')

@section('title', 'Manage Homepage Carousel')
@section('dashboard-title', 'Manage Homepage Carousel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="bi bi-images me-2"></i>Homepage Carousel Items</h4>
        <a href="{{ route('super-admin.homepage-carousels.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Carousel Item
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($carousels->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No carousel items found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Image</th>
                                <th class="py-3">Title</th>
                                <th class="py-3">Description</th>
                                <th class="py-3">Button</th>
                                <th class="py-3">Order</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carousels as $carousel)
                                <tr>
                                    <td class="px-4">
                                        @if ($carousel->image)
                                            <img src="{{ asset('storage/' . $carousel->image) }}" alt="Carousel Image"
                                                class="rounded" style="width: 90px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $carousel->title ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($carousel->short_description, 80) }}</small>
                                    </td>
                                    <td>
                                        @if ($carousel->button_name && $carousel->button_url)
                                            <a href="{{ $carousel->button_url }}" target="_blank"
                                                class="badge bg-primary text-decoration-none">{{ $carousel->button_name }}</a>
                                        @elseif ($carousel->button_name)
                                            <span class="text-muted">{{ $carousel->button_name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $carousel->sort_order }}</span>
                                    </td>
                                    <td>
                                        @if ($carousel->is_active)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('super-admin.homepage-carousels.edit', $carousel) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('super-admin.homepage-carousels.destroy', $carousel) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this carousel item?');">
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
        @if ($carousels->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $carousels->links() }}
            </div>
        @endif
    </div>
@endsection
