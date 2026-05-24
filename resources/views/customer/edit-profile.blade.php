@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Edit Profile</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Joined</label>
                            <input type="text" class="form-control" value="{{ optional($user->created_at)->format('M d, Y') }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control" value="{{ optional($user->updated_at)->format('M d, Y') }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', optional($user->dob)->format('Y-m-d')) }}" class="form-control">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Contact Division</label>
                        <select name="c_division_id" id="c_division_id" class="form-select @error('c_division_id') is-invalid @enderror">
                            <option value="">Select division</option>
                            @foreach($divisions as $divisionId => $divisionName)
                                <option value="{{ $divisionId }}" {{ old('c_division_id', $user->c_division_id) == $divisionId ? 'selected' : '' }}>{{ $divisionName }}</option>
                            @endforeach
                        </select>
                        @error('c_division_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact District</label>
                        <select name="c_district_id" id="c_district_id" class="form-select @error('c_district_id') is-invalid @enderror">
                            <option value="">Select district</option>
                        </select>
                        @error('c_district_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Address</label>
                    <textarea name="contact_address" rows="3" class="form-control">{{ old('contact_address', $user->contact_address) }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Permanent Division</label>
                        <select name="p_division_id" id="p_division_id" class="form-select @error('p_division_id') is-invalid @enderror">
                            <option value="">Select division</option>
                            @foreach($divisions as $divisionId => $divisionName)
                                <option value="{{ $divisionId }}" {{ old('p_division_id', $user->p_division_id) == $divisionId ? 'selected' : '' }}>{{ $divisionName }}</option>
                            @endforeach
                        </select>
                        @error('p_division_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Permanent District</label>
                        <select name="p_district_id" id="p_district_id" class="form-select @error('p_district_id') is-invalid @enderror">
                            <option value="">Select district</option>
                        </select>
                        @error('p_district_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Permanent Address</label>
                    <textarea name="permanent_address" rows="3" class="form-control">{{ old('permanent_address', $user->permanent_address) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Education</label>
                    <input type="text" name="education" value="{{ old('education', $user->education) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Profession</label>
                    <input type="text" name="profession" value="{{ old('profession', $user->profession) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Organization</label>
                    <input type="text" name="organization_name" value="{{ old('organization_name', $user->organization_name) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" value="{{ old('designation', $user->designation) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Joining</label>
                    <input type="date" name="date_of_joining" value="{{ old('date_of_joining', optional($user->date_of_joining)->format('Y-m-d')) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Working Experience</label>
                    <input type="text" name="total_working_experience" value="{{ old('total_working_experience', $user->total_working_experience) }}" class="form-control">
                </div>

                <script>
                    const districtsByDivision = @json($districts);
                    const oldContactDistrict = @json(old('c_district_id', $user->c_district_id));
                    const oldPermanentDistrict = @json(old('p_district_id', $user->p_district_id));

                    function fillDistrictOptions(divisionSelectId, districtSelectId, selectedDistrict) {
                        const divisionElement = document.getElementById(divisionSelectId);
                        const districtElement = document.getElementById(districtSelectId);
                        const divisionId = parseInt(divisionElement.value, 10);

                        districtElement.innerHTML = '<option value="">Select district</option>';

                        if (! districtsByDivision[divisionId]) {
                            return;
                        }

                        Object.entries(districtsByDivision[divisionId]).forEach(([districtId, districtName]) => {
                            const option = document.createElement('option');
                            option.value = districtId;
                            option.textContent = districtName;
                            if (selectedDistrict && selectedDistrict.toString() === districtId.toString()) {
                                option.selected = true;
                            }
                            districtElement.appendChild(option);
                        });
                    }

                    document.getElementById('c_division_id').addEventListener('change', () => {
                        fillDistrictOptions('c_division_id', 'c_district_id', null);
                    });

                    document.getElementById('p_division_id').addEventListener('change', () => {
                        fillDistrictOptions('p_division_id', 'p_district_id', null);
                    });

                    document.addEventListener('DOMContentLoaded', () => {
                        fillDistrictOptions('c_division_id', 'c_district_id', oldContactDistrict);
                        fillDistrictOptions('p_division_id', 'p_district_id', oldPermanentDistrict);
                    });
                </script>

                <button class="btn btn-primary" type="submit">Save Changes</button>
                <a href="{{ route('customer.profile') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection
