@extends('layouts.admin')

@section('title', 'Create Bank')
@section('dashboard-title', 'Super Admin - Create Bank')

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
    <div class="card-body">
        <h2 class="mb-4 fw-bold">Create New Bank</h2>

        <form method="POST" action="{{ route('super-admin.banks.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Bank Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label fw-semibold">Bank Code</label>
                <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control" required>
                @error('code')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="details" class="form-label fw-semibold">Details</label>
                <textarea name="details" id="details" rows="5" class="form-control">{{ old('details') }}</textarea>
                @error('details')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label fw-semibold">Bank Logo</label>
                <input type="file" name="logo" id="logo" accept="image/*" class="form-control">
                @error('logo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="banner" class="form-label fw-semibold">Bank Banner</label>
                <input type="file" name="banner" id="banner" accept="image/*" class="form-control">
                @error('banner')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Create Bank
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
