@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h3>New Loan Application</h3>

            @php
                $missingDocuments = $missingDocuments ?? [];
            @endphp

            @if ($errors->has('documents'))
                <div class="alert alert-danger">
                    {{ $errors->first('documents') }}
                </div>
            @endif

            @if (!empty($missingDocuments))
                <div class="alert alert-warning">
                    <h5 class="mb-2">Required documents are missing</h5>
                    <p>Please upload the following documents before applying for a new loan:</p>
                    <ul class="mb-2">
                        @foreach ($missingDocuments as $document)
                            <li>{{ $document }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('customer.documents') }}" class="btn btn-sm btn-primary">Upload Documents</a>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.new_application.store') }}">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="expected_amount" class="form-label">Expected Amount</label>
                        <input type="number" step="0.01" min="0" name="expected_amount" id="expected_amount" value="{{ old('expected_amount') }}" class="form-control @error('expected_amount') is-invalid @enderror" required>
                        @error('expected_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tenure_months" class="form-label">Tenure (Months)</label>
                        <input type="number" min="1" name="tenure_months" id="tenure_months" value="{{ old('tenure_months') }}" class="form-control @error('tenure_months') is-invalid @enderror" required>
                        @error('tenure_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="service_category_id" class="form-label">Service Category</label>
                        <select name="service_category_id" id="service_category_id" class="form-select @error('service_category_id') is-invalid @enderror" required>
                            <option value="">Select category</option>
                            @foreach($serviceCategories as $category)
                                <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                    <option value="{{ $type->id }}" data-category-id="{{ $category->id }}" {{ old('service_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('service_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class= "row mb-4 border border-3 rounded m-1 p-4" >
                   
                    <div class="col-md-12 mb-3">
                        <label class="form-label d-flex justify-content-between align-items-center" for="bank_ids_0">
                            <span class="fw-bold">If You Want You Can Select Your Preferred Banks</span>
                            <small class="text-muted">Choose between 1 and 5 banks</small>
                        </label>
                        <div class="row g-3 mt-2">
                            @for ($i = 0; $i < 5; $i++)
                                @php
                                    $selectedBank = optional($banks->firstWhere('id', old("bank_ids.$i")))->name;
                                @endphp
                                <div class="col-12 col-sm-6">
                                    <label for="bank_search_{{ $i }}" class="form-label">Bank {{ $i + 1 }}</label>
                                    <div class="mb-2 position-relative">
                                        <input type="search" name="bank_names[]" id="bank_search_{{ $i }}" class="form-control bank-search-input @error('bank_ids.' . $i) is-invalid @enderror" data-target="bank_ids_{{ $i }}" placeholder="Select bank or search" aria-label="Search bank {{ $i + 1 }}" value="{{ old("bank_names.$i", $selectedBank) }}" autocomplete="off">
                                        <input type="hidden" name="bank_ids[]" id="bank_ids_{{ $i }}" value="{{ old("bank_ids.$i") }}">
                                        <div class="bank-search-dropdown list-group position-absolute w-100 mt-1 d-none" style="max-height:220px; overflow-y:auto; z-index:1050;"></div>
                                    </div>
                                    @error('bank_ids.' . $i)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endfor
                        </div>
                        <div class="form-text">Start typing a bank name to search, then choose from the list. Leave unused fields blank.</div>
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

                <button type="submit" class="btn btn-primary" {{ !empty($missingDocuments) ? 'disabled' : '' }}>Submit Application</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const bankSearchInputs = Array.from(document.querySelectorAll('.bank-search-input'));
                const bankList = @json($banks->map(function ($bank) { return ['id' => $bank->id, 'name' => $bank->name]; }));
                const categorySelect = document.querySelector('#service_category_id');
                const typeSelect = document.querySelector('#service_type_id');
                const typeOptions = Array.from(typeSelect.options);

                function findBankIdByName(name) {
                    const normalized = name.trim().toLowerCase();
                    const bank = bankList.find(item => item.name.toLowerCase() === normalized);
                    return bank ? bank.id : '';
                }

                function getDropdown(input) {
                    return input.closest('.position-relative')?.querySelector('.bank-search-dropdown');
                }

                function renderDropdown(input, filter = '') {
                    const dropdown = getDropdown(input);
                    if (!dropdown) {
                        return;
                    }

                    const normalized = filter.trim().toLowerCase();
                    const matches = bankList.filter(item => item.name.toLowerCase().includes(normalized));

                    dropdown.innerHTML = '';
                    if (!matches.length) {
                        const none = document.createElement('div');
                        none.className = 'list-group-item disabled';
                        none.textContent = 'No banks found';
                        dropdown.appendChild(none);
                        return;
                    }

                    matches.forEach(bank => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = bank.name;
                        item.addEventListener('click', function () {
                            input.value = bank.name;
                            const hiddenInput = document.getElementById(input.dataset.target);
                            if (hiddenInput) {
                                hiddenInput.value = bank.id;
                            }
                            dropdown.classList.add('d-none');
                        });
                        dropdown.appendChild(item);
                    });
                }

                function openDropdown(input) {
                    const dropdown = getDropdown(input);
                    if (!dropdown) {
                        return;
                    }
                    renderDropdown(input, input.value);
                    dropdown.classList.remove('d-none');
                }

                function closeAllDropdowns() {
                    document.querySelectorAll('.bank-search-dropdown').forEach(dropdown => {
                        dropdown.classList.add('d-none');
                    });
                }

                bankSearchInputs.forEach(input => {
                    input.addEventListener('focus', function () {
                        openDropdown(this);
                    });
                    input.addEventListener('input', function () {
                        const hiddenInput = document.getElementById(this.dataset.target);
                        if (hiddenInput) {
                            hiddenInput.value = findBankIdByName(this.value);
                        }
                        renderDropdown(this, this.value);
                    });
                    input.addEventListener('change', function () {
                        const hiddenInput = document.getElementById(this.dataset.target);
                        if (hiddenInput) {
                            hiddenInput.value = findBankIdByName(this.value);
                        }
                    });
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('.bank-search-dropdown') && !event.target.closest('.bank-search-input')) {
                        closeAllDropdowns();
                    }
                });

                function refreshTypeOptions() {
                    const selectedCategory = categorySelect.value;

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
                }

                categorySelect.addEventListener('change', function () {
                    refreshTypeOptions();
                });

                refreshTypeOptions();
            });
        </script>
    @endpush
@endsection
