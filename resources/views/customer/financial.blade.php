@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Financial Information</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.financial.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Salary by Bank</label>
                    <input type="number" step="0.01" name="salary_by_bank" value="{{ old('salary_by_bank', $customerFinancial->salary_by_bank ?? '') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Salary Bank</label>
                    <select name="salary_bank_id" class="form-select @error('salary_bank_id') is-invalid @enderror">
                        <option value="">Select bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" {{ old('salary_bank_id', $customerFinancial->salary_bank_id ?? '') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                        @endforeach
                    </select>
                    @error('salary_bank_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Salary by Hand</label>
                    <input type="number" step="0.01" name="salary_by_hand" value="{{ old('salary_by_hand', $customerFinancial->salary_by_hand ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Monthly Bank Transaction (for Business Loan)</label>
                    <input type="number" step="0.01" name="monthly_bank_transaction" value="{{ old('monthly_bank_transaction', $customerFinancial->monthly_bank_transaction ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Do You Have Any Loan ?</label>
                    <select name="has_loan" id="has-loan-select" class="form-select @error('has_loan') is-invalid @enderror">
                        <option value="">Select an option</option>
                        <option value="1" {{ (int) old('has_loan', $customerFinancial->has_loan ?? '') === 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ (int) old('has_loan', $customerFinancial->has_loan ?? '') === 0 ? 'selected' : '' }}>No</option>
                    </select>
                    @error('has_loan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">Save Financial Info</button>
                <a href="{{ route('customer.profile') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>

            <div id="loan-entries" class="mb-4" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Existing Loans / Credit Cards</label>
                    <a href="{{ route('customer.financial.loan.create') }}" class="btn btn-sm btn-outline-primary">+ Add Loan</a>
                </div>

                @if($customerFinancial && $customerFinancial->loans->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Bank</th>
                                    <th>Amount</th>
                                    <th>Tenure</th>
                                    <th style="width: 140px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customerFinancial->loans as $loan)
                                    <tr>
                                        <td>{{ $loan->serviceCategory?->name ?? '-' }}</td>
                                        <td>{{ $loan->serviceType?->name ?? '-' }}</td>
                                        <td>{{ $loan->bank?->name ?? '-' }}</td>
                                        <td>{{ number_format($loan->loan_amount, 2) }}</td>
                                        <td>{{ $loan->tenure_months ? $loan->tenure_months . ' months' : '-' }}</td>
                                        <td>
                                            <a href="{{ route('customer.financial.loan.edit', $loan) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('customer.financial.loan.destroy', $loan) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this loan?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-light border">No loans added yet.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var hasLoanSelect = document.getElementById('has-loan-select');
            var loanEntries = document.getElementById('loan-entries');

            function toggleLoanEntries() {
                if (loanEntries && hasLoanSelect) {
                    loanEntries.style.display = hasLoanSelect.value === '1' ? 'block' : 'none';
                }
            }

            function saveHasLoan(value) {
                fetch('{{ route('customer.financial.has_loan.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ has_loan: value })
                }).then(function () {
                    window.location.reload();
                }).catch(function () {
                    window.location.reload();
                });
            }

            if (hasLoanSelect) {
                hasLoanSelect.addEventListener('change', function () {
                    toggleLoanEntries();
                    saveHasLoan(this.value === '1');
                });
            }

            toggleLoanEntries();
        });
    </script>
@endpush
