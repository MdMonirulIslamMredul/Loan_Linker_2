@extends('layouts.admin')

@section('title', 'Manage Image Advertisements')
@section('dashboard-title', 'Manage Image Advertisements')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="bi bi-megaphone me-2"></i>Image Advertisements</h4>
        <a href="{{ route('super-admin.image-advertisements.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Advertisement
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
            @if ($advertisements->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No image advertisements found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Image</th>
                                <th class="py-3">Title</th>
                                <th class="py-3">Link</th>
                                <th class="py-3">Order</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($advertisements as $advertisement)
                                <tr>
                                    <td class="px-4">
                                        @if ($advertisement->image)
                                            <img src="{{ asset('storage/' . $advertisement->image) }}"
                                                alt="Advertisement Image"
                                                class="rounded" style="width: 90px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $advertisement->title ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        @if ($advertisement->link_url)
                                            <a href="{{ $advertisement->link_url }}" target="_blank" rel="noopener"
                                                class="badge bg-primary text-decoration-none">Visit</a>
                                        @else
                                            <span class="text-muted">No link</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $advertisement->sort_order }}</span>
                                    </td>
                                    <td>
                                        @if ($advertisement->is_active)
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
                                            <a href="{{ route('super-admin.image-advertisements.edit', $advertisement) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('super-admin.image-advertisements.destroy', $advertisement) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this advertisement?');">
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
        @if ($advertisements->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $advertisements->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

