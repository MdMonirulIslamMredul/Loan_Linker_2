@extends('layouts.admin')

@section('title', 'Customer Details')
@section('dashboard-title', 'Customer Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <a href="{{ route('super-admin.customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Customers
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">{{ $customer->name }}</h4>
                            <p class="mb-0 text-muted">Customer profile and account overview</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <form action="{{ route('super-admin.customers.updateStatus', $customer->id) }}" method="POST" onsubmit="return confirm('{{ $customer->is_active ? 'Deactivate' : 'Activate' }} this customer?');">
                                @csrf
                                <input type="hidden" name="is_active" value="{{ $customer->is_active ? 0 : 1 }}">
                                <button type="submit" class="btn btn-sm {{ $customer->is_active ? 'btn-danger' : 'btn-success' }}">
                                    <i class="bi bi-power"></i>
                                    {{ $customer->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Customer ID</small>
                                <strong>#{{ $customer->id }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $customer->email }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Phone</small>
                                <strong>{{ $customer->phone }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Registered At</small>
                                <strong>{{ $customer->created_at->format('d M, Y') }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Bank</small>
                                <strong>{{ $customer->bank->name ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Branch</small>
                                <strong>{{ $customer->branch->name ?? 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Profile Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($customer->nid_number)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">NID Number</small>
                                    <strong>{{ $customer->nid_number }}</strong>
                                </div>
                            @endif
                            @if($customer->dob)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <strong>{{ $customer->dob->format('d M, Y') }}</strong>
                                </div>
                            @endif
                            @if($customer->education)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Education</small>
                                    <strong>{{ $customer->education }}</strong>
                                </div>
                            @endif
                            @if($customer->profession)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Profession</small>
                                    <strong>{{ $customer->profession }}</strong>
                                </div>
                            @endif
                            @if($customer->organization_name)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Organization</small>
                                    <strong>{{ $customer->organization_name }}</strong>
                                </div>
                            @endif
                            @if($customer->designation)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Designation</small>
                                    <strong>{{ $customer->designation }}</strong>
                                </div>
                            @endif
                            @if($customer->date_of_joining)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Joining</small>
                                    <strong>{{ $customer->date_of_joining->format('d M, Y') }}</strong>
                                </div>
                            @endif
                            @if($customer->total_working_experience)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Work Experience</small>
                                    <strong>{{ $customer->total_working_experience }}</strong>
                                </div>
                            @endif
                            @if($customer->contact_address || $customer->contactDivision || $customer->contactDistrict)
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Contact Address</small>
                                    <p class="mb-0">
                                        @if($customer->contactDivision?->name)
                                            <strong>{{ $customer->contactDivision->name }}</strong>
                                        @endif
                                        @if($customer->contactDivision?->name && $customer->contactDistrict?->name)
                                            , 
                                        @endif
                                        @if($customer->contactDistrict?->name)
                                            <strong>{{ $customer->contactDistrict->name }}</strong>
                                        @endif
                                        @if($customer->contact_address && ($customer->contactDivision?->name || $customer->contactDistrict?->name))
                                            , {{ $customer->contact_address }}
                                        @elseif($customer->contact_address)
                                            {{ $customer->contact_address }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                            @if($customer->permanent_address || $customer->permanentDivision || $customer->permanentDistrict)
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Permanent Address</small>
                                    <p class="mb-0">
                                        @if($customer->permanentDivision?->name)
                                            <strong>{{ $customer->permanentDivision->name }}</strong>
                                        @endif
                                        @if($customer->permanentDivision?->name && $customer->permanentDistrict?->name)
                                            , 
                                        @endif
                                        @if($customer->permanentDistrict?->name)
                                            <strong>{{ $customer->permanentDistrict->name }}</strong>
                                        @endif
                                        @if($customer->permanent_address && ($customer->permanentDivision?->name || $customer->permanentDistrict?->name))
                                            , {{ $customer->permanent_address }}
                                        @elseif($customer->permanent_address)
                                            {{ $customer->permanent_address }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Financial Details</h5>
                    </div>
                    <div class="card-body">
                        @if($customer->customerFinancial)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Salary by Bank</small>
                                    <strong>{{ number_format($customer->customerFinancial->salary_by_bank, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Salary by Hand</small>
                                    <strong>{{ number_format($customer->customerFinancial->salary_by_hand, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Monthly Bank Transaction</small>
                                    <strong>{{ number_format($customer->customerFinancial->monthly_bank_transaction, 2) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Existing Loans / Credit Cards</small>
                                    <strong>{{ $customer->customerFinancial->existing_loans_credit_cards ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">No financial information available for this customer.</p>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Uploaded Documents</h5>
                    </div>
                    <div class="card-body">
                        @if($customer->customerDocument)
                            <div class="row">
                                @foreach([
                                    'picture' => 'Profile Picture',
                                    'nid' => 'NID Document',
                                    'office_id' => 'Office ID Document',
                                    'visiting_card' => 'Visiting Card',
                                    'pay_slip' => 'Pay Slip',
                                    'bank_statements' => 'Bank Statements',
                                    'trade_license' => 'Trade License',
                                    'tin_certificate' => 'TIN Certificate',
                                    'lend_document' => 'Loan Document',
                                    'other_document' => 'Other Document',
                                ] as $field => $label)
                                    @php
                                        $filePath = $customer->customerDocument->{$field};
                                        $fileUrl = $filePath ? asset('storage/' . $filePath) : null;
                                        $isImage = $filePath ? preg_match('/\.(jpg|jpeg|png|gif|svg)$/i', $filePath) : false;
                                        $isPdf = $filePath ? preg_match('/\.pdf$/i', $filePath) : false;
                                    @endphp

                                    @if($filePath)
                                        <div class="col-md-6 mb-4">
                                            <small class="text-muted d-block">{{ $label }}</small>

                                            <div class="mb-2 d-flex flex-column gap-2">
                                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        Open {{ $label }}
                                                    </a>
                                                    <span class="badge bg-secondary">{{ basename($filePath) }}</span>
                                                </div>

                                                @if($isImage)
                                                    <img src="{{ $fileUrl }}" alt="{{ $label }}" class="img-fluid rounded shadow-sm" style="max-height: 320px; width: auto;" />
                                                @elseif($isPdf)
                                                    <div class="ratio ratio-4x3">
                                                        <iframe src="{{ $fileUrl }}" frameborder="0"></iframe>
                                                    </div>
                                                @else
                                                    <div class="small text-muted">Preview not available for this file type.</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">No documents uploaded for this customer.</p>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-upload me-2"></i>Update Documents</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('super-admin.customers.documents.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @foreach([
                                'picture' => 'Profile Picture',
                                'nid' => 'NID Document',
                                'office_id' => 'Office ID Document',
                                'visiting_card' => 'Visiting Card',
                                'pay_slip' => 'Pay Slip',
                                'bank_statements' => 'Bank Statements',
                                'trade_license' => 'Trade License',
                                'tin_certificate' => 'TIN Certificate',
                                'lend_document' => 'Loan Document',
                                'other_document' => 'Other Document',
                            ] as $field => $label)
                                @php
                                    $currentFile = optional($customer->customerDocument)->{$field};
                                @endphp
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ $label }}</label>
                                    @if($currentFile)
                                        <div class="mb-2 small text-muted">
                                            Current file: <a href="{{ asset('storage/' . $currentFile) }}" target="_blank">{{ basename($currentFile) }}</a>
                                        </div>
                                    @else
                                        <div class="mb-2 small text-danger">
                                            No {{ strtolower($label) }} uploaded yet.
                                        </div>
                                    @endif
                                    <input type="file" name="{{ $field }}" class="form-control">
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">Save Documents</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
