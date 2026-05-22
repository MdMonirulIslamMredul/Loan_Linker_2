@extends('layouts.landing')

@section('title', 'Register as Bank Officer')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">Register as a Bank Officer</h4>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('register.bank_officer.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}"
                                        class="form-control @error('dob') is-invalid @enderror" required>
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control @error('phone') is-invalid @enderror" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">NID Number</label>
                                <input type="text" name="nid_number" value="{{ old('nid_number') }}"
                                    class="form-control @error('nid_number') is-invalid @enderror" required>
                                @error('nid_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Bank</label>
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
                            

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Contact Division</label>
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
                                <div class="col-md-6">
                                    <label class="form-label">Contact District</label>
                                    <select name="c_district_id" id="c_district_id" class="form-select @error('c_district_id') is-invalid @enderror" required>
                                        <option value="">Select district</option>
                                    </select>
                                    @error('c_district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contact Address</label>
                                <textarea name="contact_address" rows="3"
                                    class="form-control @error('contact_address') is-invalid @enderror" required>{{ old('contact_address') }}</textarea>
                                @error('contact_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="same_as_contact" name="same_as_contact" {{ old('same_as_contact') ? 'checked' : '' }}>
                                <label class="form-check-label" for="same_as_contact">Same as Contact Address</label>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Permanent Division</label>
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
                                <div class="col-md-6">
                                    <label class="form-label">Permanent District</label>
                                    <select name="p_district_id" id="p_district_id" class="form-select @error('p_district_id') is-invalid @enderror" required>
                                        <option value="">Select district</option>
                                    </select>
                                    @error('p_district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Permanent Address</label>
                                <textarea name="permanent_address" rows="3" id="permanent_address"
                                    class="form-control @error('permanent_address') is-invalid @enderror" required>{{ old('permanent_address') }}</textarea>
                                @error('permanent_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

                                    if (! districtsByDivision[divisionId]) {
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

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input @error('accepted_terms') is-invalid @enderror" type="checkbox"
                                    id="accepted_terms" name="accepted_terms" {{ old('accepted_terms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="accepted_terms">
                                    I accept the <a href="{{ route('pages.terms') }}" target="_blank">Terms & Conditions</a>.
                                </label>
                                @error('accepted_terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
