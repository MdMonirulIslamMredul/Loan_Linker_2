@extends('layouts.admin')

@section('title', 'Edit Image Advertisement')
@section('dashboard-title', 'Edit Image Advertisement')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>Edit Image Advertisement</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('super-admin.image-advertisements.update', $imageAdvertisement) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($imageAdvertisement->image)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $imageAdvertisement->image) }}" alt="Current Image"
                                        class="rounded" style="width: 160px; height: 100px; object-fit: cover;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $imageAdvertisement->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="link_url" class="form-label">Link URL</label>
                            <input type="url" class="form-control @error('link_url') is-invalid @enderror" id="link_url"
                                name="link_url" value="{{ old('link_url', $imageAdvertisement->link_url) }}">
                            @error('link_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                                name="sort_order" value="{{ old('sort_order', $imageAdvertisement->sort_order) }}" min="0">
                            <small class="form-text text-muted">Lower values display first.</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $imageAdvertisement->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (Display on website)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Update Advertisement
                            </button>
                            <a href="{{ route('super-admin.image-advertisements.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
