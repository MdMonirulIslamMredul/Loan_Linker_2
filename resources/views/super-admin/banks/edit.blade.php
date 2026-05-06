@extends('layouts.admin')

@section('title', 'Edit Bank')
@section('dashboard-title', 'Super Admin - Edit Bank')

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
    <div class="card-body">
        <h2 class="mb-4 fw-bold">Edit Bank</h2>

        <form method="POST" action="{{ route('super-admin.banks.update', $bank) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Bank Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $bank->name) }}" class="form-control" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label fw-semibold">Bank Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $bank->code) }}" class="form-control" required>
                @error('code')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $bank->description) }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="details" class="form-label fw-semibold">Details</label>
                <textarea name="details" id="details" rows="5" class="form-control">{{ old('details', $bank->details) }}</textarea>
                @error('details')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label fw-semibold">Bank Logo</label>
                @if($bank->logo)
                    <div class="mb-2">
                        <img src="{{ asset($bank->logo) }}" alt="Current Logo" style="height: 64px; object-fit: contain;">
                        <p class="text-muted small mb-0">Current logo</p>
                    </div>
                @endif
                <input type="file" name="logo" id="logo" accept="image/*" class="form-control">
                <div class="form-text">Leave empty to keep current logo</div>
                @error('logo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="banner" class="form-label fw-semibold">Bank Banner</label>
                @if($bank->banner)
                    <div class="mb-2">
                        <img src="{{ asset($bank->banner) }}" alt="Current Banner" class="w-100" style="height: 128px; object-fit: cover;">
                        <p class="text-muted small mb-0">Current banner</p>
                    </div>
                @endif
                <input type="file" name="banner" id="banner" accept="image/*" class="form-control">
                <div class="form-text">Leave empty to keep current banner</div>
                @error('banner')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $bank->is_active) ? 'checked' : '' }} class="form-check-input" id="is_active">
                    <label class="form-check-label fw-semibold" for="is_active">Active</label>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('super-admin.banks.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Update Bank
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
