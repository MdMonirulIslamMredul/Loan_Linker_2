@extends('layouts.admin')

@section('title', 'Logo Settings')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Logo Settings</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Manage Site Logos & Branding</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('super-admin.logo-settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Site Name -->
                    <div class="mb-4">
                        <label for="site_name" class="form-label fw-bold">Site Name</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror" id="site_name"
                            name="site_name" value="{{ old('site_name', $settings->site_name) }}" required>
                        @error('site_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Header Logo -->
                        <div class="col-md-4 mb-4">
                            <label for="header_logo" class="form-label fw-bold">Header Logo</label>
                            @if ($settings->header_logo)
                                <div class="mb-3 p-3 border rounded bg-light text-center">
                                    <img src="{{ asset('storage/' . $settings->header_logo) }}" alt="Header Logo"
                                        style="max-width: 200px; max-height: 100px;" class="img-fluid">
                                    <div class="mt-2">
                                        <form action="{{ route('super-admin.logo-settings.delete', 'header_logo') }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this logo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('header_logo') is-invalid @enderror"
                                id="header_logo" name="header_logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml">
                            <small class="form-text text-muted">Recommended: PNG/SVG, Max 2MB</small>
                            @error('header_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Footer Logo -->
                        <div class="col-md-4 mb-4">
                            <label for="footer_logo" class="form-label fw-bold">Footer Logo</label>
                            @if ($settings->footer_logo)
                                <div class="mb-3 p-3 border rounded bg-dark text-center">
                                    <img src="{{ asset('storage/' . $settings->footer_logo) }}" alt="Footer Logo"
                                        style="max-width: 200px; max-height: 100px;" class="img-fluid">
                                    <div class="mt-2">
                                        <form action="{{ route('super-admin.logo-settings.delete', 'footer_logo') }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this logo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('footer_logo') is-invalid @enderror"
                                id="footer_logo" name="footer_logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml">
                            <small class="form-text text-muted">Recommended: PNG/SVG (light version), Max 2MB</small>
                            @error('footer_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Favicon -->
                        <div class="col-md-4 mb-4">
                            <label for="favicon" class="form-label fw-bold">Favicon</label>
                            @if ($settings->favicon)
                                <div class="mb-3 p-3 border rounded bg-light text-center">
                                    <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon"
                                        style="max-width: 64px; max-height: 64px;" class="img-fluid">
                                    <div class="mt-2">
                                        <form action="{{ route('super-admin.logo-settings.delete', 'favicon') }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this favicon?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon"
                                name="favicon" accept="image/png,image/x-icon,image/svg+xml">
                            <small class="form-text text-muted">Recommended: 32x32px or 64x64px PNG/ICO, Max 1MB</small>
                            @error('favicon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Logo Settings
                        </button>
                        <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Preview</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">Header Preview</h6>
                        <div class="p-3 border rounded bg-white">
                            <div class="d-flex align-items-center">
                                @if ($settings->header_logo)
                                    <img src="{{ asset('storage/' . $settings->header_logo) }}" alt="Header Logo"
                                        style="max-height: 40px;" class="me-2">
                                @else
                                    <div class="bg-gradient bg-primary rounded d-flex align-items-center justify-content-center me-2"
                                        style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold fs-5">LL</span>
                                    </div>
                                @endif
                                <span class="fs-4 fw-bold">{{ $settings->site_name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">Footer Preview</h6>
                        <div class="p-3 border rounded bg-dark text-white">
                            <div class="d-flex align-items-center">
                                @if ($settings->footer_logo)
                                    <img src="{{ asset('storage/' . $settings->footer_logo) }}" alt="Footer Logo"
                                        style="max-height: 40px;" class="me-2">
                                @else
                                    <div class="bg-gradient bg-primary rounded d-flex align-items-center justify-content-center me-2"
                                        style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold fs-5">LL</span>
                                    </div>
                                @endif
                                <span class="fs-5 fw-bold text-white">{{ $settings->site_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
