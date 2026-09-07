@extends('layouts.admin')

@section('title', 'All Branches')
@section('dashboard-title', 'Super Admin - All Branches')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">All Branches</h2>
@php
                $canManageBranches = auth()->user()->isSuperAdmin() || auth()->user()->hasPermissionTo('branches.create', 'web');
            @endphp
            @if ($canManageBranches)
                <a href="{{ route('super-admin.branches.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Branch
                </a>
            @endif
            </div>

            <form method="GET" action="{{ route('super-admin.branches.index') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="bank_id" class="form-label">Bank</label>
                    <select name="bank_id" id="bank_id" class="form-select">
                        <option value="">All Banks</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="district_id" class="form-label">District</label>
                    <select name="district_id" id="district_id" class="form-select">
                        <option value="">All Districts</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="thana_id" class="form-label">Thana</label>
                    <select name="thana_id" id="thana_id" class="form-select">
                        <option value="">All Thanas</option>
                        @foreach ($thanas as $thana)
                            <option value="{{ $thana->id }}" data-district-id="{{ $thana->district_id }}"
                                {{ request('thana_id') == $thana->id ? 'selected' : '' }}>
                                {{ $thana->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                    <a href="{{ route('super-admin.branches.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Clear
                    </a>
                </div>
            </form>

            @if ($branches->isEmpty())
                <p class="text-muted">No branches available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Bank</th>
                                <th>Branch Name</th>
                                <th>Code</th>
                                <th>District</th>
                                <th>Thana</th>
                                <th>Phone</th>
                                {{-- <th>Officers / Admins</th> --}}
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $branch->id }}</td>
                                    <td>{{ $branch->bank->name }}</td>
                                    <td class="fw-semibold">{{ $branch->name }}</td>
                                    <td>{{ $branch->code }}</td>
                                    <td>{{ $branch->district->name ?? 'N/A' }}</td>
                                    <td>{{ $branch->thana->name ?? 'N/A' }}</td>
                                    <td>{{ $branch->phone ?? 'N/A' }}</td>
                                    {{-- <td>{{ $branch->users_count }}</td> --}}
                                    <td>
                                        <span class="badge {{ $branch->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($canManageBranches)
                                        <a href="{{ route('super-admin.branches.edit', $branch) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.branches.destroy', $branch) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-muted small"><i class="bi bi-eye"></i> View Only</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-3">
                    {{ $branches->links('pagination::bootstrap-5') }}
                </div>

        </div>

        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const districtSelect = document.getElementById('district_id');
            const thanaSelect = document.getElementById('thana_id');

            if (!districtSelect || !thanaSelect) {
                return;
            }

            const filterThanas = () => {
                const selectedDistrictId = districtSelect.value;
                let hasVisibleOption = false;

                Array.from(thanaSelect.options).forEach((option) => {
                    if (!option.value) {
                        return;
                    }

                    const optionDistrictId = option.getAttribute('data-district-id') || '';
                    const shouldShow = !selectedDistrictId || optionDistrictId === selectedDistrictId;

                    option.hidden = !shouldShow;

                    if (shouldShow) {
                        hasVisibleOption = true;
                    }
                });

                if (!hasVisibleOption) {
                    thanaSelect.value = '';
                    return;
                }

                if (thanaSelect.value && Array.from(thanaSelect.options).some(option => option.value === thanaSelect.value && !option.hidden)) {
                    return;
                }

                thanaSelect.value = '';
            };

            districtSelect.addEventListener('change', filterThanas);
            filterThanas();
        });
    </script>
@endsection
