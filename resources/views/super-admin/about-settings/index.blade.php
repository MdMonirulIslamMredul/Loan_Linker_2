@extends('layouts.admin')

@section('title', 'About Us Settings')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">About Us Settings</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Manage About Us Content</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('super-admin.about-settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Who We Are -->
                    <div class="mb-4">
                        <label for="who_we_are" class="form-label fw-bold">Who We Are</label>
                        <textarea class="form-control @error('who_we_are') is-invalid @enderror" id="who_we_are" name="who_we_are"
                            rows="4">{{ old('who_we_are', $settings->who_we_are) }}</textarea>
                        <small class="form-text text-muted">Describe your company and what you do.</small>
                        @error('who_we_are')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Our Vision -->
                        <div class="col-md-6 mb-4">
                            <label for="our_vision" class="form-label fw-bold">Our Vision</label>
                            <textarea class="form-control @error('our_vision') is-invalid @enderror" id="our_vision" name="our_vision"
                                rows="4">{{ old('our_vision', $settings->our_vision) }}</textarea>
                            <small class="form-text text-muted">Your company's vision statement.</small>
                            @error('our_vision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Our Mission -->
                        <div class="col-md-6 mb-4">
                            <label for="our_mission" class="form-label fw-bold">Our Mission</label>
                            <textarea class="form-control @error('our_mission') is-invalid @enderror" id="our_mission" name="our_mission"
                                rows="4">{{ old('our_mission', $settings->our_mission) }}</textarea>
                            <small class="form-text text-muted">Your company's mission statement.</small>
                            @error('our_mission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- What We Believe -->
                    <div class="mb-4">
                        <label for="what_we_believe" class="form-label fw-bold">What We Believe</label>
                        <textarea class="form-control @error('what_we_believe') is-invalid @enderror" id="what_we_believe"
                            name="what_we_believe" rows="4">{{ old('what_we_believe', $settings->what_we_believe) }}</textarea>
                        <small class="form-text text-muted">Your core values and beliefs.</small>
                        @error('what_we_believe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contact_email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                        id="contact_email" name="contact_email"
                                        value="{{ old('contact_email', $settings->contact_email) }}">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                        id="contact_phone" name="contact_phone"
                                        value="{{ old('contact_phone', $settings->contact_phone) }}">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="working_hours" class="form-label">Working Hours</label>
                                    <input type="text" class="form-control @error('working_hours') is-invalid @enderror"
                                        id="working_hours" name="working_hours"
                                        value="{{ old('working_hours', $settings->working_hours) }}"
                                        placeholder="e.g. Monday - Saturday, 09:00 AM to 06:00 PM">
                                    <small class="form-text text-muted">Human-readable working hours for display on contact
                                        page.</small>
                                    @error('working_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_whatsapp" class="form-label">WhatsApp Number</label>
                                    <input type="text"
                                        class="form-control @error('contact_whatsapp') is-invalid @enderror"
                                        id="contact_whatsapp" name="contact_whatsapp"
                                        value="{{ old('contact_whatsapp', $settings->contact_whatsapp) }}"
                                        placeholder="8801234567890">
                                    <small class="form-text text-muted">Format: 8801234567890 (without + or spaces)</small>
                                    @error('contact_whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_address" class="form-label">Address</label>
                                    <textarea class="form-control @error('contact_address') is-invalid @enderror" id="contact_address"
                                        name="contact_address" rows="3">{{ old('contact_address', $settings->contact_address) }}</textarea>
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Social Media Links</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="facebook_url" class="form-label">
                                        <i class="bi bi-facebook text-primary me-2"></i>Facebook URL
                                    </label>
                                    <input type="url" class="form-control @error('facebook_url') is-invalid @enderror"
                                        id="facebook_url" name="facebook_url"
                                        value="{{ old('facebook_url', $settings->facebook_url) }}"
                                        placeholder="https://facebook.com/yourpage">
                                    @error('facebook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="twitter_url" class="form-label">
                                        <i class="bi bi-twitter-x text-info me-2"></i>Twitter URL
                                    </label>
                                    <input type="url" class="form-control @error('twitter_url') is-invalid @enderror"
                                        id="twitter_url" name="twitter_url"
                                        value="{{ old('twitter_url', $settings->twitter_url) }}"
                                        placeholder="https://twitter.com/yourprofile">
                                    @error('twitter_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="linkedin_url" class="form-label">
                                        <i class="bi bi-linkedin text-primary me-2"></i>LinkedIn URL
                                    </label>
                                    <input type="url"
                                        class="form-control @error('linkedin_url') is-invalid @enderror"
                                        id="linkedin_url" name="linkedin_url"
                                        value="{{ old('linkedin_url', $settings->linkedin_url) }}"
                                        placeholder="https://linkedin.com/company/yourcompany">
                                    @error('linkedin_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="instagram_url" class="form-label">
                                        <i class="bi bi-instagram text-danger me-2"></i>Instagram URL
                                    </label>
                                    <input type="url"
                                        class="form-control @error('instagram_url') is-invalid @enderror"
                                        id="instagram_url" name="instagram_url"
                                        value="{{ old('instagram_url', $settings->instagram_url) }}"
                                        placeholder="https://instagram.com/yourprofile">
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update About Us Settings
                        </button>
                        <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        <a href="{{ route('about') }}" class="btn btn-info" target="_blank">
                            <i class="bi bi-eye"></i> Preview Page
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
