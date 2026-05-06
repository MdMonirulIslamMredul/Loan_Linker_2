@extends('layouts.bank-admin')

@section('title', 'Edit Branch')
@section('dashboard-title', 'Bank Admin - Edit Branch')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Branch</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('bank-admin.branches.update', $branch) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Branch Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $branch->name) }}"
                        class="form-control" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">Branch Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $branch->code) }}"
                        class="form-control" required>
                    @error('code')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" rows="3" class="form-control">{{ old('address', $branch->address) }}</textarea>
                    @error('address')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $branch->city) }}"
                            class="form-control">
                        @error('city')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="state" class="form-label">State</label>
                        <input type="text" name="state" id="state" value="{{ old('state', $branch->state) }}"
                            class="form-control">
                        @error('state')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $branch->phone) }}"
                            class="form-control">
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $branch->email) }}"
                            class="form-control">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input"
                        {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('bank-admin.branches.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Branch</button>
                </div>
            </form>
        </div>
    </div>
@endsection
