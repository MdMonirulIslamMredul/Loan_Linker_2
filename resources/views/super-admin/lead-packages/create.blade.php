<!-- Create Lead Package -->
@extends('layouts.admin')

@section('title', 'Create Lead Package')
@section('dashboard-title', 'Super Admin - Create Lead Package')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Create New Lead Package</h2>

            <form method="POST" action="{{ route('super-admin.lead-packages.store') }}">
                @csrf

                @include('super-admin.lead-packages._form')

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.lead-packages.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Create Package
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
