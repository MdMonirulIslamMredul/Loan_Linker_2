@extends('layouts.admin')

@section('title', 'Create Branch Admin')
@section('dashboard-title', 'Super Admin - Create Branch Admin')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Create New Branch Admin / Officer</h2>

            <form method="POST" action="{{ route('super-admin.branch-admins.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control"
                        required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control"
                        required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control"
                        required>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row gx-3">
                    <div class="mb-3 col-md-6">
                        <label for="bank_select" class="form-label fw-semibold">Bank</label>
                        <select id="bank_select" name="bank_id" class="form-select">
                            <option value="">Select a bank</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="branch_id" class="form-label fw-semibold">Branch</label>
                        <select name="branch_id" id="branch_id" class="form-select" required>
                            <option value="">Select a branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->bank->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Create Branch Admin / Officer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankSelect = document.getElementById('bank_select');
            const branchSelect = document.getElementById('branch_id');

            async function loadBranches(bankId, preselected) {
                branchSelect.innerHTML = '<option>Loading...</option>';
                if (!bankId) {
                    branchSelect.innerHTML = '<option value="">Select a branch</option>';
                    return;
                }

                try {
                    const res = await fetch("{{ url('/api/banks') }}/" + bankId + "/branches", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) throw new Error('Network error');
                    const data = await res.json();
                    let html = '<option value="">Select a branch</option>';
                    if (data.length === 0) {
                        html += '<option value="" disabled>No branches</option>';
                    } else {
                        data.forEach(b => {
                            const selected = preselected && preselected == b.id ? ' selected' : '';
                            const code = b.code ? ' (' + b.code + ')' : '';
                            html += `<option value="${b.id}"${selected}>${b.name}${code}</option>`;
                        });
                    }
                    branchSelect.innerHTML = html;
                } catch (e) {
                    branchSelect.innerHTML = '<option value="">Select a branch</option>';
                }
            }

            bankSelect?.addEventListener('change', function() {
                loadBranches(this.value);
            });

            const initialBank = bankSelect?.value;
            const initialBranch = "{{ old('branch_id') }}";
            if (initialBank) loadBranches(initialBank, initialBranch);
        });
    </script>
@endpush
