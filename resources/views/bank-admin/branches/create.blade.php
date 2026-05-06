@extends('layouts.bank-admin')

@section('title', 'Create Branch')
@section('dashboard-title', 'Bank Admin - Create Branch')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Create New Branch</h2>

            <form method="POST" action="{{ route('bank-admin.branches.store') }}">
                @csrf



                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Branch Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control"
                        required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label fw-semibold">Branch Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control"
                        required>
                    @error('code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <textarea name="address" id="address" rows="3" class="form-control">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="city" class="form-label fw-semibold">City</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            class="form-control">
                        @error('city')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="state" class="form-label fw-semibold">State</label>
                        <input type="text" name="state" id="state" value="{{ old('state') }}"
                            class="form-control">
                        @error('state')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="form-control">
                        @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('bank-admin.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Create Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
