@extends('layouts.admin')

@section('title', 'Edit Branch')
@section('dashboard-title', 'Super Admin - Edit Branch')

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
    <div class="card-body">
        <h2 class="mb-4 fw-bold">Edit Branch</h2>

        <form method="POST" action="{{ route('super-admin.branches.update', $branch) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="bank_id" class="form-label fw-semibold">Bank</label>
                <select name="bank_id" id="bank_id" class="form-select" required>
                    <option value="">Select a bank</option>
                    @foreach($banks as $bank)
                        <option value="{{ $bank->id }}" {{ old('bank_id', $branch->bank_id) == $bank->id ? 'selected' : '' }}>
                            {{ $bank->name }}
                        </option>
                    @endforeach
                </select>
                @error('bank_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Branch Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $branch->name) }}" class="form-control" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label fw-semibold">Branch Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $branch->code) }}" class="form-control">
                @error('code')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label fw-semibold">Address</label>
                <textarea name="address" id="address" rows="3" class="form-control">{{ old('address', $branch->address) }}</textarea>
                @error('address')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="districts_id" class="form-label fw-semibold">District</label>
                    <select name="districts_id" id="districts_id" class="form-select">
                        <option value="">Select a district</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('districts_id', $branch->districts_id) == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('districts_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="thana_id" class="form-label fw-semibold">Thana</label>
                    <select name="thana_id" id="thana_id" class="form-select">
                        <option value="">Select a thana</option>
                        @foreach($thanas as $thana)
                            <option value="{{ $thana->id }}" data-district-id="{{ $thana->district_id }}" {{ old('thana_id', $branch->thana_id) == $thana->id ? 'selected' : '' }}>
                                {{ $thana->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('thana_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $branch->phone) }}" class="form-control">
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $branch->email) }}" class="form-control">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $branch->is_active) ? 'checked' : '' }} class="form-check-input" id="is_active">
                    <label class="form-check-label fw-semibold" for="is_active">Active</label>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('super-admin.branches.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Update Branch
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const districtSelect = document.getElementById('districts_id');
        const thanaSelect = document.getElementById('thana_id');
        if (!districtSelect || !thanaSelect) return;

        const allThanas = Array.from(thanaSelect.options).map(option => ({
            value: option.value,
            text: option.textContent,
            districtId: option.dataset.districtId || '',
        }));

        function updateThanaOptions() {
            const selectedDistrict = districtSelect.value;
            const currentValue = thanaSelect.value;
            thanaSelect.innerHTML = '<option value="">Select a thana</option>';

            allThanas.forEach(option => {
                if (!option.value) return;
                if (selectedDistrict === '' || option.districtId === selectedDistrict) {
                    const opt = document.createElement('option');
                    opt.value = option.value;
                    opt.textContent = option.text;
                    opt.dataset.districtId = option.districtId;
                    if (option.value === currentValue) {
                        opt.selected = true;
                    }
                    thanaSelect.appendChild(opt);
                }
            });

            if (selectedDistrict === '') {
                thanaSelect.value = '';
            }
        }

        districtSelect.addEventListener('change', updateThanaOptions);
        updateThanaOptions();
    });
</script>
