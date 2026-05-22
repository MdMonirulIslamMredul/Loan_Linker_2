@extends('layouts.admin')

@section('title', 'Terms & Conditions Management')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Terms & Conditions</h1>
            <a href="{{ route('super-admin.terms-conditions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create New Entry
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                @if ($terms->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Active</th>
                                    <th>Updated</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($terms as $term)
                                    <tr>
                                        <td>{{ $term->title ?? 'Terms & Conditions' }}</td>
                                        <td>
                                            @if ($term->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $term->updated_at->format('M j, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('super-admin.terms-conditions.edit', $term) }}" class="btn btn-sm btn-outline-primary me-2">
                                                Edit
                                            </a>
                                            <form action="{{ route('super-admin.terms-conditions.destroy', $term) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this terms entry?');">
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

                    <div class="mt-4">
                        {{ $terms->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="mb-3">No terms entries found yet.</p>
                        <a href="{{ route('super-admin.terms-conditions.create') }}" class="btn btn-primary">Add the first terms entry</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
