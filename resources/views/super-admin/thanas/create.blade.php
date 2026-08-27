@extends('layouts.admin')

@section('title', 'Create Thana')
@section('dashboard-title', 'Super Admin - Create Thana')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Create New Thana</h2>

            <form method="POST" action="{{ route('super-admin.thanas.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="district_id" class="form-label fw-semibold">District <span class="text-danger">*</span></label>
                    <select name="district_id" id="district_id" class="form-select" required>
                        <option value="">Select a district</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('district_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Thana Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control"
                        placeholder="e.g., Mirpur" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Create Thana
                    </button>
                    <a href="{{ route('super-admin.thanas.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
