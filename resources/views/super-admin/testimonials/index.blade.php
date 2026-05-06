@extends('layouts.admin')

@section('title', 'Manage Testimonials')
@section('dashboard-title', 'Manage Testimonials')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="bi bi-chat-quote me-2"></i>All Testimonials</h4>
        <a href="{{ route('super-admin.testimonials.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Testimonial
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
            @if ($testimonials->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-3 mb-0">No testimonials found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Order</th>
                                <th class="py-3">Name</th>
                                <th class="py-3">Location/Role</th>
                                <th class="py-3">Message</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Created</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonials as $testimonial)
                                <tr>
                                    <td class="px-4">
                                        <span class="badge bg-secondary">{{ $testimonial->display_order }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $testimonial->name }}</strong>
                                    </td>
                                    <td>
                                        @if ($testimonial->location)
                                            <span class="text-muted">{{ $testimonial->location }}</span>
                                        @endif
                                        @if ($testimonial->role)
                                            <span class="text-muted">{{ $testimonial->role }}</span>
                                        @endif
                                        @if (!$testimonial->location && !$testimonial->role)
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($testimonial->message, 60) }}</small>
                                    </td>
                                    <td>
                                        @if ($testimonial->is_active)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $testimonial->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('super-admin.testimonials.edit', $testimonial) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('super-admin.testimonials.destroy', $testimonial) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
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
        @if ($testimonials->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
@endsection
