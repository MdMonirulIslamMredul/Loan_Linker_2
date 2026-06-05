@extends('layouts.landing')

@section('title', 'Register as Bank Officer')

@section('content')
    @push('styles')
        <style>
            .auth-card {
                background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
                border-radius: 1.5rem;
                box-shadow: 0 30px 80px rgba(0, 0, 0, 0.18);
            }

            .auth-card .card-body {
                padding: 2rem;
            }

            .auth-card .form-control,
            .auth-card .form-select,
            .auth-card textarea {
                border-radius: 0.95rem;
                min-height: 52px;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.96);
                border: none;
            }

            .auth-card .input-group-text {
                width: 3.4rem;
                justify-content: center;
                border-radius: 0.95rem 0 0 0.95rem;
                border: none;
                background: rgba(255, 255, 255, 0.92);
                color: #0d6efd;
            }

            .auth-card .input-group .btn {
                color: #0d6efd;
                background: rgba(255, 255, 255, 0.96);
                border: none;
                border-radius: 0 0.95rem 0.95rem 0;
                margin-left: -1px;
                padding: 0.55rem 0.85rem;
            }

            .auth-card .input-group .btn:hover,
            .auth-card .input-group .btn:focus {
                color: #0b5ed7;
                background: rgba(255, 255, 255, 1);
                box-shadow: none;
            }

            .auth-card .input-group .form-control {
                border-radius: 0.95rem 0 0 0.95rem;
            }

            .auth-card .form-control:focus,
            .auth-card .form-select:focus,
            .auth-card textarea:focus {
                box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
            }

            .auth-card .btn-primary {
                border-radius: 1rem;
                min-height: 52px;
                font-weight: 600;
                letter-spacing: 0.02em;
            }

            .auth-card .form-text {
                color: rgba(255, 255, 255, 0.8);
            }

            .auth-card .invalid-feedback {
                color: #ffd6d9;
            }
        </style>
    @endpush

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card auth-card">
                    <div class="card-body text-white">
                        <h3 class="fw-bold mb-2">Register as a Bank Officer</h3>
                        <p class="text-white-75 mb-4">Join Loan Linker and connect with customers looking for bank services.</p>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('register.bank_officer.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Enter your full name"
                                        class="form-control @error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                                        <input type="date" name="dob" value="{{ old('dob') }}"
                                            placeholder="Enter your date of birth"
                                            class="form-control @error('dob') is-invalid @enderror" required>
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile Number</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                            placeholder="01XXXXXXXXX"
                                            class="form-control @error('phone') is-invalid @enderror" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">NID Number</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                    <input type="text" name="nid_number" value="{{ old('nid_number') }}"
                                        placeholder="Enter your NID number"
                                        class="form-control @error('nid_number') is-invalid @enderror" required>
                                    @error('nid_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        placeholder="you@example.com"
                                        class="form-control @error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Bank</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-bank2"></i></span>
                                    <select name="bank_id" class="form-select @error('bank_id') is-invalid @enderror" required>
                                        <option value="">Select a bank</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Contact Division</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                        <select name="c_division_id" id="c_division_id" class="form-select @error('c_division_id') is-invalid @enderror" required>
                                            <option value="">Select division</option>
                                            @foreach($divisions as $divisionId => $divisionName)
                                                <option value="{{ $divisionId }}" {{ old('c_division_id') == $divisionId ? 'selected' : '' }}>{{ $divisionName }}</option>
                                            @endforeach
                                        </select>
                                        @error('c_division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact District</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-signpost-2-fill"></i></span>
                                        <select name="c_district_id" id="c_district_id" class="form-select @error('c_district_id') is-invalid @enderror" required>
                                            <option value="">Select district</option>
                                        </select>
                                        @error('c_district_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contact Address</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text align-items-start pt-3"><i class="bi bi-house-door-fill"></i></span>
                                    <textarea name="contact_address" rows="3" placeholder="Enter contact address" class="form-control @error('contact_address') is-invalid @enderror" required>{{ old('contact_address') }}</textarea>
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="same_as_contact" name="same_as_contact" {{ old('same_as_contact') ? 'checked' : '' }}>
                                <label class="form-check-label" for="same_as_contact">Same as Contact Address</label>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Permanent Division</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                        <select name="p_division_id" id="p_division_id" class="form-select @error('p_division_id') is-invalid @enderror" required>
                                            <option value="">Select division</option>
                                            @foreach($divisions as $divisionId => $divisionName)
                                                <option value="{{ $divisionId }}" {{ old('p_division_id') == $divisionId ? 'selected' : '' }}>{{ $divisionName }}</option>
                                            @endforeach
                                        </select>
                                        @error('p_division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Permanent District</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-signpost-2-fill"></i></span>
                                        <select name="p_district_id" id="p_district_id" class="form-select @error('p_district_id') is-invalid @enderror" required>
                                            <option value="">Select district</option>
                                        </select>
                                        @error('p_district_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Permanent Address</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text align-items-start pt-3"><i class="bi bi-house-door-fill"></i></span>
                                    <textarea name="permanent_address" rows="3" id="permanent_address" placeholder="Enter permanent address" class="form-control @error('permanent_address') is-invalid @enderror" required>{{ old('permanent_address') }}</textarea>
                                    @error('permanent_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <script>
                                const districtsByDivision = @json($districts);
                                const oldContactDistrict = @json(old('c_district_id'));
                                const oldPermanentDistrict = @json(old('p_district_id'));

                                function fillDistrictOptions(divisionSelectId, districtSelectId, selectedOption) {
                                    const divisionSelect = document.getElementById(divisionSelectId);
                                    const districtSelect = document.getElementById(districtSelectId);
                                    const divisionId = parseInt(divisionSelect.value, 10);
                                    districtSelect.innerHTML = '<option value="">Select district</option>';

                                    if (!districtsByDivision[divisionId]) {
                                        return;
                                    }

                                    Object.entries(districtsByDivision[divisionId]).forEach(([districtId, districtName]) => {
                                        const option = document.createElement('option');
                                        option.value = districtId;
                                        option.textContent = districtName;
                                        if (selectedOption && selectedOption.toString() === districtId.toString()) {
                                            option.selected = true;
                                        }
                                        districtSelect.appendChild(option);
                                    });
                                }

                                function copyContactToPermanent() {
                                    const sameAsContact = document.getElementById('same_as_contact').checked;
                                    if (!sameAsContact) {
                                        return;
                                    }

                                    const contactDivision = document.getElementById('c_division_id').value;
                                    const contactDistrict = document.getElementById('c_district_id').value;
                                    const contactAddress = document.getElementsByName('contact_address')[0].value;

                                    document.getElementById('p_division_id').value = contactDivision;
                                    fillDistrictOptions('p_division_id', 'p_district_id', contactDistrict);
                                    document.getElementById('permanent_address').value = contactAddress;
                                }

                                document.getElementById('c_division_id').addEventListener('change', () => {
                                    fillDistrictOptions('c_division_id', 'c_district_id', null);
                                    if (document.getElementById('same_as_contact').checked) {
                                        copyContactToPermanent();
                                    }
                                });

                                document.getElementById('p_division_id').addEventListener('change', () => {
                                    fillDistrictOptions('p_division_id', 'p_district_id', null);
                                });

                                document.getElementById('c_district_id').addEventListener('change', () => {
                                    if (document.getElementById('same_as_contact').checked) {
                                        copyContactToPermanent();
                                    }
                                });

                                document.getElementById('same_as_contact').addEventListener('change', () => {
                                    copyContactToPermanent();
                                });

                                document.addEventListener('DOMContentLoaded', () => {
                                    fillDistrictOptions('c_division_id', 'c_district_id', oldContactDistrict);
                                    fillDistrictOptions('p_division_id', 'p_district_id', oldPermanentDistrict);

                                    if (document.getElementById('same_as_contact').checked) {
                                        copyContactToPermanent();
                                    }
                                });
                            </script>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    function togglePasswordVisibility(buttonId, inputId) {
                                        const button = document.getElementById(buttonId);
                                        const input = document.getElementById(inputId);
                                        if (!button || !input) return;

                                        button.addEventListener('click', function () {
                                            const isPassword = input.type === 'password';
                                            input.type = isPassword ? 'text' : 'password';
                                            const icon = this.querySelector('i');
                                            if (icon) {
                                                icon.classList.toggle('bi-eye');
                                                icon.classList.toggle('bi-eye-slash');
                                            }
                                        });
                                    }

                                    togglePasswordVisibility('togglePassword', 'password');
                                    togglePasswordVisibility('togglePasswordConfirmation', 'password_confirmation');
                                });
                            </script>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password" name="password" placeholder="Choose a secure password" class="form-control @error('password') is-invalid @enderror" required>
                                    <button class="btn btn-outline-secondary border-0 bg-white" type="button" id="togglePassword" tabindex="-1">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" class="form-control" required>
                                    <button class="btn btn-outline-secondary border-0 bg-white" type="button" id="togglePasswordConfirmation" tabindex="-1">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input @error('accepted_terms') is-invalid @enderror" type="checkbox" id="accepted_terms" name="accepted_terms" {{ old('accepted_terms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="accepted_terms">
                                    I accept the <a href="{{ route('pages.terms') }}" target="_blank" class="text-warning">Terms & Conditions</a>.
                                </label>
                                @error('accepted_terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-light text-primary fw-bold">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
