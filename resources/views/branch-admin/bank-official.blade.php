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
                    <select name="bank_name" class="form-control" required>
                        <option value="">Select a bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->name }}" {{ old('bank_name', $bankOfficial->bank_name ?? '') === $bank->name ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Branch Name</label>
                    <input type="text" name="branch_name" value="{{ old('branch_name', $bankOfficial->branch_name ?? '') }}" class="form-control" required>
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
