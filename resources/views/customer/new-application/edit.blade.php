@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h3>Edit Loan Application</h3>
            <p class="text-muted">You can update this application before it is processed.</p>

            <form method="POST" action="{{ route('customer.application.update', $newApplication->id) }}">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                     <div class="col-md-6 mb-3">
                        <label for="service_category_id" class="form-label">Service Category</label>
                        <select name="service_category_id" id="service_category_id" class="form-select @error('service_category_id') is-invalid @enderror" required>
                            <option value="">Select category</option>
                            @foreach($serviceCategories as $category)
                                <option value="{{ $category->id }}" data-slug="{{ $category->slug }}" {{ old('service_category_id', $newApplication->service_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('service_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="service_type_id" class="form-label">Service Type</label>
                        <select name="service_type_id" id="service_type_id" class="form-select @error('service_type_id') is-invalid @enderror" required>
                            <option value="">Select service type</option>
                            @foreach($serviceCategories as $category)
                                @foreach($category->serviceTypes as $type)
                                    <option value="{{ $type->id }}" data-category-id="{{ $category->id }}" {{ old('service_type_id', $newApplication->service_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('service_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-6 mb-3">
                        <label for="expected_amount" class="form-label">Expected Amount</label>
                        <input type="number" step="0.01" min="0" name="expected_amount" id="expected_amount" value="{{ old('expected_amount', $newApplication->expected_amount) }}" class="form-control @error('expected_amount') is-invalid @enderror" required>
                        @error('expected_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @php
                        $selectedCategoryId = old('service_category_id', $newApplication->service_category_id);
                        $selectedCategory = $serviceCategories->firstWhere('id', $selectedCategoryId);
                        $showTenure = $selectedCategory && $selectedCategory->slug !== 'credit_card';
                    @endphp
                    <div id="tenure-section" class="col-md-6 mb-3" style="{{ $showTenure ? '' : 'display:none;' }}">
                        <label for="tenure_months" class="form-label">Tenure (Months)</label>
                        <input type="number" min="1" name="tenure_months" id="tenure_months" value="{{ old('tenure_months', $newApplication->tenure_months) }}" class="form-control @error('tenure_months') is-invalid @enderror">
                        @error('tenure_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                   
                </div>

                <div class="row mb-4 border border-3 rounded m-1 p-4">
                    <div class="col-md-12 mb-3">
                        <label class="form-label d-flex justify-content-between align-items-center" for="bank_ids_0">
                            <span class="fw-bold">If You Want You Can Select Your Preferred Banks</span>
                            <small class="text-muted">Choose up to 5 banks</small>
                        </label>
                        <div class="row g-3 mt-2">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="col-12 col-sm-6">
                                    <label for="bank_ids_{{ $i }}" class="form-label">Bank {{ $i + 1 }}</label>
                                    <select name="bank_ids[]" id="bank_ids_{{ $i }}" class="form-select @error('bank_ids.' . $i) is-invalid @enderror">
                                        <option value="">Select bank {{ $i + 1 }}</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank_ids.' . $i, $newApplication->bank_ids[$i] ?? '') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bank_ids.' . $i)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endfor
                        </div>
                        <div class="form-text">Use each dropdown to pick one bank. Leave unused fields blank.</div>
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
                    <textarea name="additional_notes" id="additional_notes" rows="3" class="form-control @error('additional_notes') is-invalid @enderror">{{ old('additional_notes', $newApplication->additional_notes) }}</textarea>
                    @error('additional_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('customer.application.show', $newApplication->id) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.querySelector('form[action="{{ route('customer.application.update', $newApplication->id) }}"]');
                const selects = Array.from(document.querySelectorAll('select[name="bank_ids[]"]'));
                const categorySelect = document.querySelector('#service_category_id');
                const typeSelect = document.querySelector('#service_type_id');
                const typeOptions = Array.from(typeSelect.options);
                const tenureSection = document.querySelector('#tenure-section');
                const tenureInput = document.querySelector('#tenure_months');

                function updateTenureVisibility() {
                    const selectedOption = categorySelect.selectedOptions[0];
                    const selectedSlug = selectedOption?.dataset?.slug || '';
                    const shouldShowTenure = selectedSlug && selectedSlug !== 'credit_card';

                    if (tenureSection) {
                        tenureSection.style.display = shouldShowTenure ? '' : 'none';
                    }
                    if (tenureInput) {
                        tenureInput.required = shouldShowTenure;
                        if (!shouldShowTenure) {
                            tenureInput.value = '';
                        }
                    }
                }

                function refreshOptions() {
                    const selectedValues = selects.map(select => select.value).filter(Boolean);

                    selects.forEach(select => {
                        const currentValue = select.value;
                        Array.from(select.options).forEach(option => {
                            if (!option.value) {
                                option.disabled = false;
                                return;
                            }
                            option.disabled = selectedValues.includes(option.value) && option.value !== currentValue;
                        });
                    });
                }

                function disableEmptySelects() {
                    selects.forEach(select => {
                        select.disabled = !select.value;
                    });
                }

                function refreshTypeOptions() {
                    const selectedCategory = categorySelect.value;
                    const currentValue = typeSelect.value;
                    typeSelect.innerHTML = '<option value="">Select service type</option>';
                    typeOptions.forEach(option => {
                        if (!option.value) {
                            return;
                        }
                        const optionCategory = option.dataset.categoryId;
                        if (!selectedCategory || optionCategory === selectedCategory) {
                            typeSelect.appendChild(option.cloneNode(true));
                        }
                    });
                    if (currentValue) {
                        typeSelect.value = currentValue;
                    }
                }

                categorySelect.addEventListener('change', function () {
                    refreshTypeOptions();
                    updateTenureVisibility();
                });

                selects.forEach(select => {
                    select.addEventListener('change', refreshOptions);
                });

                if (form) {
                    form.addEventListener('submit', function () {
                        disableEmptySelects();
                    });
                }

                refreshTypeOptions();
                refreshOptions();
            });
        </script>
    @endpush
@endsection