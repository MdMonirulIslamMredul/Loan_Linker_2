@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h3>New Loan Application</h3>

            <form method="POST" action="{{ route('customer.new_application.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="expected_amount" class="form-label">Expected Amount</label>
                        <input type="number" step="0.01" min="0" name="expected_amount" id="expected_amount" value="{{ old('expected_amount') }}" class="form-control @error('expected_amount') is-invalid @enderror" required>
                        @error('expected_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tenure_months" class="form-label">Tenure (Months)</label>
                        <input type="number" min="1" name="tenure_months" id="tenure_months" value="{{ old('tenure_months') }}" class="form-control @error('tenure_months') is-invalid @enderror" required>
                        @error('tenure_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="service_category" class="form-label">Service Category</label>
                        <select name="service_category" id="service_category" class="form-select @error('service_category') is-invalid @enderror" required>
                            <option value="">Select category</option>
                            <option value="credit_card" {{ old('service_category') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="loan" {{ old('service_category') === 'loan' ? 'selected' : '' }}>Loan</option>
                        </select>
                        @error('service_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="service_type" class="form-label">Service Type</label>
                        <select name="service_type" id="service_type" class="form-select @error('service_type') is-invalid @enderror" required>
                            <option value="">Select service type</option>
                            <option value="visa_credit_card" {{ old('service_type') === 'visa_credit_card' ? 'selected' : '' }}>Visa Credit Card</option>
                            <option value="personal_loan" {{ old('service_type') === 'personal_loan' ? 'selected' : '' }}>Personal Loan</option>
                        </select>
                        @error('service_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bank_ids" class="form-label">Bank Selection</label>
                        <select name="bank_ids[]" id="bank_ids" class="form-select @error('bank_ids') is-invalid @enderror" multiple size="5" required>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ in_array($bank->id, old('bank_ids', [])) ? 'selected' : '' }}>{{ $bank->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Select up to 5 banks.</div>
                        @error('bank_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('bank_ids.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="additional_notes" class="form-label">Additional Notes (optional)</label>
                    <textarea name="additional_notes" id="additional_notes" rows="3" class="form-control @error('additional_notes') is-invalid @enderror">{{ old('additional_notes') }}</textarea>
                    @error('additional_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit Application</button>
            </form>
        </div>
    </div>
@endsection
