@extends('layouts.admin')

@section('title', 'Edit Badge')
@section('dashboard-title', 'Super Admin - Edit Badge')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Edit Badge</h2>

            <form method="POST" action="{{ route('super-admin.badges.update', $badge) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Badge Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $badge->name) }}" class="form-control" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label fw-semibold">Badge Type</label>
                    <input type="text" name="type" id="type" value="{{ old('type', $badge->type) }}" class="form-control">
                    @error('type')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $badge->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label fw-semibold">Badge Logo</label>
                    <input type="file" name="logo" id="logo" accept="image/*" class="form-control">
                    @if($badge->logo)
                        <div class="mt-2">
                            <img src="{{ asset($badge->logo) }}" alt="Badge logo" class="img-thumbnail" style="max-width: 120px;">
                        </div>
                    @endif
                    @error('logo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" {{ old('is_active', $badge->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label fw-semibold">Active</label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.badges.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Update Badge
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
