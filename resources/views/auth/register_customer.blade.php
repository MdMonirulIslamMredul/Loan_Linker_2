@extends('layouts.landing')

@section('title', 'Register as Customer')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">Register as a Customer</h4>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('register.customer.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                <div class="form-text text-muted">Use the name as shown on your government ID.</div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    class="form-control @error('email') is-invalid @enderror" required>
                                <div class="form-text text-muted">We'll send your account confirmation to this email.</div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    placeholder="01XXXXXXXXX"
                                    class="form-control @error('phone') is-invalid @enderror" required>
                                <div class="form-text text-muted">Enter your mobile number in local format.</div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}"
                                        class="form-control @error('dob') is-invalid @enderror" required>
                                    <div class="form-text text-muted">Enter your birth date.</div>
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Joining</label>
                                    <input type="date" name="date_of_joining" value="{{ old('date_of_joining') }}"
                                        class="form-control @error('date_of_joining') is-invalid @enderror" required>
                                    <div class="form-text text-muted">When did you join your current organization?</div>
                                    @error('date_of_joining')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contact Address</label>
                                <textarea name="contact_address" rows="3"
                                    class="form-control @error('contact_address') is-invalid @enderror" required>{{ old('contact_address') }}</textarea>
                                <div class="form-text text-muted">Provide your current contact address.</div>
                                @error('contact_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Permanent Address</label>
                                <textarea name="permanent_address" rows="3"
                                    class="form-control @error('permanent_address') is-invalid @enderror" required>{{ old('permanent_address') }}</textarea>
                                <div class="form-text text-muted">Provide your permanent home address.</div>
                                @error('permanent_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Education</label>
                                    <input type="text" name="education" value="{{ old('education') }}"
                                        placeholder="e.g. BBA, MBA, HSC"
                                        class="form-control @error('education') is-invalid @enderror" required>
                                    <div class="form-text text-muted">Enter your highest completed education.</div>
                                    @error('education')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profession</label>
                                    <input type="text" name="profession" value="{{ old('profession') }}"
                                        placeholder="e.g. Accountant, Engineer"
                                        class="form-control @error('profession') is-invalid @enderror" required>
                                    <div class="form-text text-muted">Your current profession or job role.</div>
                                    @error('profession')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Organization Name</label>
                                    <input type="text" name="organization_name" value="{{ old('organization_name') }}"
                                        placeholder="Company or organization"
                                        class="form-control @error('organization_name') is-invalid @enderror" required>
                                    <div class="form-text text-muted">Where you are currently employed.</div>
                                    @error('organization_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="designation" value="{{ old('designation') }}"
                                        placeholder="e.g. Manager, Officer"
                                        class="form-control @error('designation') is-invalid @enderror" required>
                                    <div class="form-text text-muted">Your role or job title.</div>
                                    @error('designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total Working Experience</label>
                                <input type="text" name="total_working_experience" value="{{ old('total_working_experience') }}"
                                    placeholder="e.g. 3 years 6 months"
                                    class="form-control @error('total_working_experience') is-invalid @enderror" required>
                                <div class="form-text text-muted">Enter total years of work experience.</div>
                                @error('total_working_experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                    placeholder="Choose a secure password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                <div class="form-text text-muted">Use at least 8 characters with letters and numbers.</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
