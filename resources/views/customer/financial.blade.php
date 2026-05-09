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
                    <label class="form-label">Salary by Hand</label>
                    <input type="number" step="0.01" name="salary_by_hand" value="{{ old('salary_by_hand', $customerFinancial->salary_by_hand ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Monthly Bank Transaction (for Business Loan)</label>
                    <input type="number" step="0.01" name="monthly_bank_transaction" value="{{ old('monthly_bank_transaction', $customerFinancial->monthly_bank_transaction ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Existing Loans / Credit Cards</label>
                    <textarea name="existing_loans_credit_cards" class="form-control" rows="4">{{ old('existing_loans_credit_cards', $customerFinancial->existing_loans_credit_cards ?? '') }}</textarea>
                </div>

                <button class="btn btn-primary" type="submit">Save Financial Info</button>
                <a href="{{ route('customer.profile') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection
