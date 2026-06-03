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
                                <select name="payment_method_id" id="payment-method" class="form-select" required>
                                    <option value="">Select method</option>
                                    @foreach ($paymentMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="payment-method-details" class="alert alert-light border rounded p-3 mb-3 d-none text-center">
                                <div>
                                    <div class="fw-bold mb-2 fs-5" id="payment-method-name"></div>
                                    <div class="text-muted mb-3 fw-semibold fs-4" id="payment-method-number"></div>
                                    <div class="d-flex justify-content-center">
                                        <img id="payment-method-image" src="" alt="Payment Method" class="rounded mx-auto d-block" style="width:100%;max-width:560px;height:auto;object-fit:contain;display:none;" />
                                    </div>
                                </div>
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

    @php
        $paymentMethodsJson = $paymentMethods->map(function ($method) {
            return [
                'id' => $method->id,
                'name' => $method->name,
                'number' => $method->number,
                'image' => $method->image,
            ];
        })->toArray();
    @endphp

    @push('scripts')
        <script>
            (function() {
                const paymentMethods = @json($paymentMethodsJson);
                const imageBase = "{{ asset('storage') }}";
                const pm = document.getElementById('payment-method');
                const bankFields = document.querySelectorAll('.bank-only');
                const txnField = document.getElementById('txn-field');
                const txnInput = txnField ? txnField.querySelector('input[name="txn_number"]') : null;
                const detailsPanel = document.getElementById('payment-method-details');
                const detailsName = document.getElementById('payment-method-name');
                const detailsNumber = document.getElementById('payment-method-number');
                const detailsImage = document.getElementById('payment-method-image');

                function updateDetails(method) {
                    if (!method) {
                        detailsPanel.classList.add('d-none');
                        detailsName.textContent = '';
                        detailsNumber.textContent = '';
                        detailsImage.style.display = 'none';
                        detailsImage.src = '';
                        return;
                    }

                    detailsPanel.classList.remove('d-none');
                    detailsName.textContent = method.name;
                    detailsNumber.textContent = method.number ? method.number : '';

                    if (method.number) {
                        detailsNumber.parentElement.classList.remove('d-none');
                    } else {
                        detailsNumber.parentElement.classList.add('d-none');
                    }

                    if (method.image) {
                        detailsImage.src = method.image.match(/^https?:\/\//) ? method.image : imageBase + '/' + method.image;
                        detailsImage.style.display = 'block';
                    } else {
                        detailsImage.style.display = 'none';
                    }
                }

                function toggleFields() {
                    if (!pm) return;

                    const selectedMethod = paymentMethods.find(function(method) {
                        return String(method.id) === String(pm.value);
                    });

                    updateDetails(selectedMethod);

                    const isBank = selectedMethod && selectedMethod.name.toLowerCase() === 'bank';

                    bankFields.forEach(function(el) {
                        el.classList.toggle('d-none', !isBank);
                        el.querySelectorAll('input').forEach(function(i) {
                            i.required = isBank;
                        });
                    });

                    if (txnInput) {
                        txnInput.required = !isBank;
                        txnField.classList.toggle('d-none', isBank);
                        if (isBank) {
                            txnInput.value = '';
                        }
                    }
                }

                pm?.addEventListener('change', toggleFields);
                toggleFields();
            })();
        </script>
    @endpush
@endsection
