@extends('layouts.branch-admin')

@section('title', 'Bank Official Information')
@section('dashboard-title', 'Bank Official Information')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="mb-4">Add / Update Bank Official Information</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('branch-admin.bank-official.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Bank Name</label>
                    <select name="bank_name" class="form-control" id="bank-select" required>
                        <option value="" data-bank-id="">Select a bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->name }}" data-bank-id="{{ $bank->id }}" {{ old('bank_name', $bankOfficial->bank_name ?? optional(auth()->user()->bank)->name ?? '') === $bank->name ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Branch Name</label>
                    @php
                        $selectedBranchName = old('branch_name', $bankOfficial->branch_name ?? '');
                    @endphp
                    <select name="branch_name" id="branch-select" class="form-control">
                        <option value="">Select a branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->name }}" {{ $selectedBranchName === $branch->name ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                        @if ($selectedBranchName && !$branches->contains('name', $selectedBranchName))
                            <option value="{{ $selectedBranchName }}" selected>{{ $selectedBranchName }}</option>
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" value="{{ old('designation', $bankOfficial->designation ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" value="{{ old('department', $bankOfficial->department ?? '') }}" class="form-control" placeholder="e.g. Card, Loan" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Office ID Number</label>
                    <input type="text" name="office_id_number" value="{{ old('office_id_number', $bankOfficial->office_id_number ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Joining</label>
                    <input type="date" name="date_of_joining" value="{{ old('date_of_joining', optional($bankOfficial)->date_of_joining?->format('Y-m-d')) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Official Mobile Number</label>
                    <input type="text" name="official_mobile_number" value="{{ old('official_mobile_number', $bankOfficial->official_mobile_number ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Official Email</label>
                    <input type="email" name="official_email" value="{{ old('official_email', $bankOfficial->official_email ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Working Area</label>
                    <input type="text" name="working_area" value="{{ old('working_area', $bankOfficial->working_area ?? '') }}" class="form-control" placeholder="e.g. Dhaka, Chittagong" required>
                </div>

                <button class="btn btn-primary" type="submit">Save Bank Official Information</button>
                <a href="{{ route('branch-admin.profile') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var bankSelect = document.getElementById('bank-select');
            var branchSelect = document.getElementById('branch-select');
            var selectedBranchName = @json(old('branch_name', $bankOfficial->branch_name ?? ''));

            function loadBranches(bankOption) {
                var bankId = bankOption ? bankOption.dataset.bankId : '';
                branchSelect.innerHTML = '<option value="">Select a branch</option>';

                if (!bankId) {
                    return;
                }

                fetch('{{ url('/api/banks') }}/' + bankId + '/branches')
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Failed to fetch branches');
                        }
                        return response.json();
                    })
                    .then(function (branches) {
                        branches.forEach(function (branch) {
                            var option = document.createElement('option');
                            option.value = branch.name;
                            option.textContent = branch.name;
                            if (branch.name === selectedBranchName) {
                                option.selected = true;
                            }
                            branchSelect.appendChild(option);
                        });
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }

            if (bankSelect) {
                bankSelect.addEventListener('change', function () {
                    var selectedOption = bankSelect.options[bankSelect.selectedIndex];
                    loadBranches(selectedOption);
                });

                var initialOption = bankSelect.options[bankSelect.selectedIndex];
                if (initialOption && initialOption.dataset.bankId) {
                    loadBranches(initialOption);
                }
            }
        });
    </script>
@endpush
