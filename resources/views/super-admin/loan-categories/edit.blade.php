@extends('layouts.admin')

@section('title', 'Edit Loan Category')
@section('dashboard-title', 'Super Admin - Edit Loan Category')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Edit Loan Category</h2>

            <form method="POST" action="{{ route('super-admin.loan-categories.update', $loanCategory) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $loanCategory->name) }}"
                        class="form-control" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Short Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $loanCategory->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="long_description_editor" class="form-label fw-semibold">Long Description</label>
                    <div id="long_description_editor" class="form-control" style="min-height: 220px;">{!! old('long_description', $loanCategory->long_description) !!}</div>
                    <textarea name="long_description" id="long_description" class="d-none">{{ old('long_description', $loanCategory->long_description) }}</textarea>
                    @error('long_description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @error('image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @if($loanCategory->image)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $loanCategory->image) }}" alt="{{ $loanCategory->name }}" class="img-fluid rounded" style="max-height: 220px;">
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                            {{ old('is_active', $loanCategory->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                    @error('is_active')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.loan-categories.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editorContainer = document.querySelector('#long_description_editor');
            const hiddenInput = document.querySelector('#long_description');
            if (editorContainer && hiddenInput) {
                const quill = new Quill(editorContainer, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ header: [1, 2, 3, false] }],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                const form = hiddenInput.closest('form');
                if (form) {
                    form.addEventListener('submit', function () {
                        hiddenInput.value = quill.root.innerHTML;
                    });
                }
            }
        });
    </script>
@endpush
