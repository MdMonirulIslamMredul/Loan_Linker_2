@extends('layouts.admin')

@section('title', 'Create Admin')
@section('dashboard-title', 'Create Admin')

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 860px; margin: 0 auto;">
    <div class="card-body">
        <h2 class="mb-4 fw-bold">Create New Admin User</h2>

        <form method="POST" action="{{ route('super-admin.admins.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control">
                    @error('phone')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label fw-semibold">Designation</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">Select Designation</option>
                        @foreach ($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Create Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection