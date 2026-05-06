@extends('layouts.admin')

@section('title', 'Edit Branch Admin')
@section('dashboard-title', 'Super Admin - Edit Branch Admin')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="bi bi-person-badge fs-2 text-success"></i>
                </div>
                <div>
                    <h2 class="mb-1 fw-bold">Edit Branch Admin / Officer </h2>
                    <p class="mb-0 text-muted">Update branch administrator details</p>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('super-admin.branch-admins.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        <i class="bi bi-person me-1"></i>Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="form-control" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        <i class="bi bi-envelope me-1"></i>Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="form-control" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">
                        <i class="bi bi-telephone me-1"></i>Phone
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                        class="form-control" required>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="branch_id" class="form-label fw-semibold">
                        <i class="bi bi-diagram-3 me-1"></i>Branch
                    </label>
                    <select name="branch_id" id="branch_id" class="form-select" required>
                        <option value="">Select a branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }} - {{ $branch->bank->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Leave password fields empty to keep the current password
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">
                        <i class="bi bi-key me-1"></i>New Password
                    </label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Leave blank to keep current password">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">
                        <i class="bi bi-key me-1"></i>Confirm New Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Confirm new password">
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">
                            <i class="bi bi-toggle-on me-1"></i>Active Status
                        </label>
                    </div>
                    <small class="text-muted">Inactive admins cannot log in to the system</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.branch-admins.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Branch Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
