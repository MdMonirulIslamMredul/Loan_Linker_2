@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Purchase Package: {{ $leadPackage->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">Leads: <strong>{{ $leadPackage->number_of_leads }}</strong></p>
                        <p class="mb-3">Price: <strong>৳{{ number_format($leadPackage->price, 2) }}</strong></p>

                        <form method="POST" action="{{ route('branch-admin.packages.purchase', $leadPackage) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" id="payment-method" class="form-select" required>
                                    <option value="">Select method</option>
                                    <option value="Bkash">Bkash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Rocket">Rocket</option>
                                    <option value="Bank">Bank</option>
                                </select>
                                @error('payment_method')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="txn-field">
                                <label class="form-label">Transaction Number</label>
                                <input type="text" name="txn_number" class="form-control" autocomplete="off">
                                @error('txn_number')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                                @error('phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 bank-only d-none">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control">
                                @error('bank_name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 bank-only d-none">
                                <label class="form-label">Account No</label>
                                <input type="text" name="account_no" class="form-control">
                                @error('account_no')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Payment Screenshot (optional)</label>
                                <input type="file" name="screenshot" class="form-control">
                                @error('screenshot')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('branch-admin.packages.gallery') }}"
                                    class="btn btn-outline-secondary">Back</a>
                                <button class="btn btn-primary">Submit Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                const pm = document.getElementById('payment-method');
                const bankFields = document.querySelectorAll('.bank-only');
                const txnField = document.getElementById('txn-field');
                const txnInput = txnField ? txnField.querySelector('input[name="txn_number"]') : null;

                function toggleFields() {
                    if (!pm) return;
                    if (pm.value === 'Bank') {
                        bankFields.forEach(function(el) {
                            el.classList.remove('d-none');
                            el.querySelectorAll('input').forEach(function(i) {
                                i.required = true;
                            });
                        });
                        if (txnInput) {
                            txnInput.required = false;
                            txnInput.value = ''; // clear any prefilled value when Bank selected
                            txnField.classList.add('d-none');
                        }
                    } else {
                        bankFields.forEach(function(el) {
                            el.classList.add('d-none');
                            el.querySelectorAll('input').forEach(function(i) {
                                i.required = false;
                            });
                        });
                        if (txnInput) {
                            txnInput.required = true;
                            txnField.classList.remove('d-none');
                        }
                    }
                }

                pm?.addEventListener('change', toggleFields);
                // run once on load to set correct visibility/required state
                toggleFields();
            })();
        </script>
    @endpush
@endsection
