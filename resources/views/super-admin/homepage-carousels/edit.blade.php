@extends('layouts.admin')

@section('title', 'Edit Carousel Item')
@section('dashboard-title', 'Edit Carousel Item')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-images me-2"></i>Edit Carousel Item</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('super-admin.homepage-carousels.update', $homepageCarousel) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($homepageCarousel->image)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $homepageCarousel->image) }}" alt="Current Image"
                                        class="rounded" style="width: 160px; height: 100px; object-fit: cover;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $homepageCarousel->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                name="short_description" rows="3">{{ old('short_description', $homepageCarousel->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="button_name" class="form-label">Button Name</label>
                                <input type="text" class="form-control @error('button_name') is-invalid @enderror"
                                    id="button_name" name="button_name" value="{{ old('button_name', $homepageCarousel->button_name) }}">
                                @error('button_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="button_url" class="form-label">Button URL</label>
                                <input type="url" class="form-control @error('button_url') is-invalid @enderror"
                                    id="button_url" name="button_url" value="{{ old('button_url', $homepageCarousel->button_url) }}">
                                @error('button_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                                name="sort_order" value="{{ old('sort_order', $homepageCarousel->sort_order) }}" min="0">
                            <small class="form-text text-muted">Lower values display first.</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $homepageCarousel->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (Display on website)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Update Carousel Item
                            </button>
                            <a href="{{ route('super-admin.homepage-carousels.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
