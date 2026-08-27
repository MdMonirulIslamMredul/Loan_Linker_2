@extends('layouts.admin')

@section('title', 'All Thanas')
@section('dashboard-title', 'Super Admin - All Thanas')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">All Thanas</h2>
@php
                $canManageThanas = auth()->user()->isSuperAdmin() || auth()->user()->hasPermissionTo('branches.create', 'web');
            @endphp
            @if ($canManageThanas)
                <a href="{{ route('super-admin.thanas.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Thana
                </a>
            @endif
            </div>

            <!-- Search and Filter -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('super-admin.thanas.index') }}" class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..."
                            value="{{ $search }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('super-admin.thanas.index') }}" class="input-group">
                        <select name="district" class="form-select" onchange="this.form.submit()">
                            <option value="">All Districts</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}"
                                    {{ $districtFilter == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            @if ($thanas->isEmpty())
                <p class="text-muted">No thanas available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Thana Name</th>
                                <th>District</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($thanas as $thana)
                                <tr>
                                    <td>{{ $thana->id }}</td>
                                    <td class="fw-semibold">{{ $thana->name }}</td>
                             
                                    <td>{{ $thana->district->name ?? 'N/A' }}</td>
                                   
                                    <td>
                                        @if ($canManageThanas)
                                        <a href="{{ route('super-admin.thanas.edit', $thana) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('super-admin.thanas.destroy', $thana) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this thana?');">
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

                <div class="mt-3">
                    {{ $thanas->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
