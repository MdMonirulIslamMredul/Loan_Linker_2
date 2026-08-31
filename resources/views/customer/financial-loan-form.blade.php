@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">{{ isset($loan) ? 'Edit Loan' : 'Add Loan' }}</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ isset($loan) ? route('customer.financial.loan.update', $loan) : route('customer.financial.loan.store') }}">
                @csrf
                @if (isset($loan) && $loan)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Loan Category</label>
                        <select name="service_category_id" id="service-category-select" class="form-select @error('service_category_id') is-invalid @enderror" required>
                            <option value="">Select category</option>
                            @foreach($serviceCategories as $category)
                                <option value="{{ $category->id }}" {{ old('service_category_id', isset($loan) && $loan ? $loan->service_category_id : '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('service_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Loan Type</label>
                        <select name="service_type_id" id="service-type-select" class="form-select @error('service_type_id') is-invalid @enderror" required>
                            <option value="">Select type</option>
                        </select>
                        @error('service_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bank</label>
                        <select name="bank_id" class="form-select @error('bank_id') is-invalid @enderror">
                            <option value="">Select bank</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ old('bank_id', isset($loan) && $loan ? $loan->bank_id : '') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                            @endforeach
                        </select>
                        @error('bank_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Loan Amount</label>
                        <input type="number" step="0.01" name="loan_amount" value="{{ old('loan_amount', isset($loan) && $loan ? $loan->loan_amount : '') }}" class="form-control @error('loan_amount') is-invalid @enderror" required>
                        @error('loan_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tenure Months</label>
                        <input type="number" min="1" name="tenure_months" id="tenure-months-input" value="{{ old('tenure_months', isset($loan) && $loan ? $loan->tenure_months : '') }}" class="form-control @error('tenure_months') is-invalid @enderror">
                        @error('tenure_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">{{ isset($loan) ? 'Update Loan' : 'Save Loan' }}</button>
                    <a href="{{ route('customer.financial') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categorySelect = document.getElementById('service-category-select');
            var typeSelect = document.getElementById('service-type-select');
            var tenureInput = document.getElementById('tenure-months-input');
            var creditCardCategoryId = 1;
            var serviceTypes = @json($serviceTypes->map(function ($type) {
                return ['id' => $type->id, 'name' => $type->name, 'category_id' => $type->service_category_id];
            }));
            var selectedCategoryId = @json(old('service_category_id', isset($loan) && $loan ? $loan->service_category_id : ''));
            var selectedTypeId = @json(old('service_type_id', isset($loan) && $loan ? $loan->service_type_id : ''));

            function populateTypes(categoryId, selectedType) {
                typeSelect.innerHTML = '<option value="">Select type</option>' + serviceTypes
                    .filter(function (type) {
                        return String(type.category_id) === String(categoryId);
                    })
                    .map(function (type) {
                        return '<option value="' + type.id + '"' + (String(type.id) === String(selectedType) ? ' selected' : '') + '>' + type.name + '</option>';
                    })
                    .join('');
            }

            function toggleTenureVisibility(categoryId) {
                if (tenureInput) {
                    tenureInput.closest('.col-md-6').style.display = String(categoryId) === String(creditCardCategoryId) ? 'none' : 'block';
                }
            }

            categorySelect.addEventListener('change', function () {
                populateTypes(this.value, '');
                toggleTenureVisibility(this.value);
            });

            if (selectedCategoryId) {
                populateTypes(selectedCategoryId, selectedTypeId);
                toggleTenureVisibility(selectedCategoryId);
            }
        });
    </script>
@endpush
