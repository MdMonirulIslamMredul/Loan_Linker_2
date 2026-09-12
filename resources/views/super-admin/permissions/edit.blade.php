@extends('layouts.admin')

@section('title', 'Edit Feature Permissions')
@section('dashboard-title', 'Edit Feature Permissions')

@section('content')
    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4>Edit Permissions for {{ $user->name }}</h4>
                <p class="text-muted">Assign or revoke access to super-admin operations.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('super-admin.permissions.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <h5 class="mb-3">Feature Permissions</h5>
                        </div>

                        @php
                            $groupLabels = [
                                'banks' => 'Bank Management',
                                'branches' => 'Branch Management',
                                'branch-admins' => 'Branch Admin Management',
                                'admins' => 'Admin Management',
                                'permissions' => 'Permission Management',
                                'loan-categories' => 'Loan Category Management',
                                'service-categories' => 'Service Category Management',
                                'service-types' => 'Service Type Management',
                                'payment-methods' => 'Payment Method Management',
                                'lead-packages' => 'Lead Package Management',
                                'package-orders' => 'Package Order Management',
                                'customer-messages' => 'Customer Message Management',
                                'customers' => 'Customer Management',
                                'applications' => 'Application Management',
                                'ratings' => 'Rating Management',
                                'sitesettings' => 'Site Settings Management',
                            ];

                            $permissionGroups = collect($permissions)
                                ->groupBy(fn ($permission) => explode('.', $permission, 2)[0]);
                        @endphp

                        @foreach ($permissionGroups as $group => $groupPermissions)
                            <div class="col-12 mb-4">
                                <h5 class="mb-3">{{ $groupLabels[$group] ?? ucfirst(str_replace(['-', '_'], ' ', $group)) }}</h5>
                                <div class="row g-3">
                                    @foreach ($groupPermissions as $permission)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $permission }}"
                                                    id="permission_{{ md5($permission) }}"
                                                    name="permissions[]"
                                                    {{ $user->hasPermissionTo($permission, 'web') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ md5($permission) }}">
                                                    {{ ucfirst(str_replace(['-', '_'], ' ', $permission)) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Save Permissions</button>
                            <a href="{{ route('super-admin.permissions.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
