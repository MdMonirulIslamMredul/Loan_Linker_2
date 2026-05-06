@extends('layouts.landing')

@section('title', 'Apply for ' . $loan->loan_name)

@section('content')
<div class="container my-5">
    <!-- Loan Info Header -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    @if($loan->branch->bank->bank_logo)
                        <img src="{{ asset($loan->branch->bank->bank_logo) }}" alt="{{ $loan->branch->bank->bank_name }}" class="img-fluid" style="max-height: 80px;">
                    @endif
                </div>
                <div class="col-md-10">
                    <h2 class="mb-1">{{ $loan->loan_name }}</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-building me-1"></i>{{ $loan->branch->bank->bank_name }} - {{ $loan->branch->branch_name }}
                    </p>
                    <div class="mt-2">
                        <span class="badge bg-primary me-2">Interest Rate: {{ $loan->interest_rate }}%</span>
                        <span class="badge bg-success me-2">Amount: {{ number_format($loan->min_loan_amount) }} - {{ number_format($loan->max_loan_amount) }} BDT</span>
                        <span class="badge bg-info">Tenure: {{ $loan->tenure_months }} months</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-file-text me-2"></i>Loan Application Form</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('loans.apply.store', $loan) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Personal Information -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-person-badge me-2"></i>Personal Information</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                   id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nid_number" class="form-label">NID Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nid_number') is-invalid @enderror"
                                   id="nid_number" name="nid_number" value="{{ old('nid_number') }}" required>
                            @error('nid_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                   id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="present_address" class="form-label">Present Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('present_address') is-invalid @enderror"
                                      id="present_address" name="present_address" rows="2" required>{{ old('present_address') }}</textarea>
                            @error('present_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="permanent_address" class="form-label">Permanent Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('permanent_address') is-invalid @enderror"
                                      id="permanent_address" name="permanent_address" rows="2" required>{{ old('permanent_address') }}</textarea>
                            @error('permanent_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-briefcase me-2"></i>Employment Information</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="occupation" class="form-label">Occupation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('occupation') is-invalid @enderror"
                                   id="occupation" name="occupation" value="{{ old('occupation') }}" required>
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="monthly_income" class="form-label">Monthly Income (BDT) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('monthly_income') is-invalid @enderror"
                                   id="monthly_income" name="monthly_income" value="{{ old('monthly_income') }}" step="0.01" required>
                            @error('monthly_income')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="employment_type" class="form-label">Employment Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type" required>
                                <option value="">Select Employment Type</option>
                                <option value="employed" {{ old('employment_type') == 'employed' ? 'selected' : '' }}>Employed</option>
                                <option value="self-employed" {{ old('employment_type') == 'self-employed' ? 'selected' : '' }}>Self-employed</option>
                                <option value="business" {{ old('employment_type') == 'business' ? 'selected' : '' }}>Business</option>
                                <option value="professional" {{ old('employment_type') == 'professional' ? 'selected' : '' }}>Professional</option>
                                <option value="student" {{ old('employment_type') == 'student' ? 'selected' : '' }}>Student</option>
                            </select>
                            @error('employment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="company_name" class="form-label">Company/Organization Name</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                   id="company_name" name="company_name" value="{{ old('company_name') }}">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Loan Details -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-currency-dollar me-2"></i>Loan Details</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="loan_amount" class="form-label">Requested Loan Amount (BDT) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('loan_amount') is-invalid @enderror"
                                   id="loan_amount" name="loan_amount" value="{{ old('loan_amount') }}"
                                   min="{{ $loan->min_loan_amount }}" max="{{ $loan->max_loan_amount }}" step="0.01" required>
                            <small class="form-text text-muted">Min: {{ number_format($loan->min_loan_amount) }} BDT | Max: {{ number_format($loan->max_loan_amount) }} BDT</small>
                            @error('loan_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tenure_months" class="form-label">Loan Tenure (Months) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tenure_months') is-invalid @enderror"
                                   id="tenure_months" name="tenure_months" value="{{ old('tenure_months', $loan->tenure_months) }}" required>
                            @error('tenure_months')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="purpose_of_loan" class="form-label">Purpose of Loan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('purpose_of_loan') is-invalid @enderror"
                                      id="purpose_of_loan" name="purpose_of_loan" rows="3" required>{{ old('purpose_of_loan') }}</textarea>
                            @error('purpose_of_loan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Document Upload -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-arrow-up me-2"></i>Required Documents</h5>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Please upload the following documents:</strong>
                        <ul class="mb-0 mt-2">
                            <li>National ID Card (NID) - Front & Back</li>
                            <li>Recent Passport Size Photograph</li>
                            <li>Income Certificate / Salary Slip</li>
                            <li>Bank Statement (Last 6 months)</li>
                            <li>Other supporting documents (if any)</li>
                        </ul>
                        <small class="text-muted">Accepted formats: PDF, JPG, JPEG, PNG | Max size: 5MB per file</small>
                    </div>

                    <div class="mb-3">
                        <label for="documents" class="form-label">Upload Documents <span class="text-danger">*</span> (You can select multiple files)</label>
                        <input type="file" class="form-control @error('documents') @error('documents.*') is-invalid @enderror @enderror"
                               id="documents" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png" required>
                        @error('documents')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('documents.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="fileList" class="mt-2"></div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-send me-2"></i>Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('documents').addEventListener('change', function(e) {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';

    if (this.files.length > 0) {
        const ul = document.createElement('ul');
        ul.className = 'list-group';

        for (let i = 0; i < this.files.length; i++) {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';

            const fileSize = (this.files[i].size / (1024 * 1024)).toFixed(2);
            li.innerHTML = `
                <span><i class="bi bi-file-earmark-text me-2"></i>${this.files[i].name}</span>
                <span class="badge bg-primary rounded-pill">${fileSize} MB</span>
            `;
            ul.appendChild(li);
        }

        fileList.appendChild(ul);
    }
});
</script>
@endsection
