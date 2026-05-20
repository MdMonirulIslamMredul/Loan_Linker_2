@extends('layouts.admin')

@section('title', 'Edit Service Type')
@section('dashboard-title', 'Super Admin - Edit Service Type')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Edit Service Type</h2>

            <form method="POST" action="{{ route('super-admin.service-types.update', $serviceType) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="service_category_id" class="form-label fw-semibold">Service Category</label>
                    <select name="service_category_id" id="service_category_id" class="form-select" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('service_category_id', $serviceType->service_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_category_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $serviceType->name) }}" class="form-control" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $serviceType->slug) }}" class="form-control">
                    <div class="form-text">Optional. Generated from name if left blank.</div>
                    @error('slug')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $serviceType->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                            {{ old('is_active', $serviceType->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                    @error('is_active')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.service-types.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Update Service Type
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
