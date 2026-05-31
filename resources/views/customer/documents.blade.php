@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Upload Documents</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.documents.store') }}" enctype="multipart/form-data">
                @csrf

                @foreach ([
                    'picture' => 'Picture',
                    'nid' => 'NID',
                    'office_id' => 'Office ID',
                    'visiting_card' => 'Visiting Card',
                    'pay_slip' => 'Pay Slip / Salary Certificate',
                    'bank_statements' => 'Bank Statements',
                    'trade_license' => 'Trade License (for Business Loan)',
                    'tin_certificate' => 'e-TIN Certificate',
                    'lend_document' => 'Lend Document (for Home Loan)',
                    'other_document' => 'Other Document',
                ] as $field => $label)
                    @php
                        $currentFile = optional($customerDocument)->{$field};
                        $fileUrl = $currentFile ? asset('storage/' . $currentFile) : null;
                        $isImage = $currentFile ? preg_match('/\.(jpg|jpeg|png|gif|svg)$/i', $currentFile) : false;
                        $isPdf = $currentFile ? preg_match('/\.pdf$/i', $currentFile) : false;
                    @endphp
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                <div>
                                    <label class="form-label fw-semibold d-block">{{ $label }}</label>
                                    <div class="small text-muted">Upload or replace {{ strtolower($label) }}.</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $fileUrl ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $fileUrl ? 'Uploaded' : 'Not uploaded' }}
                                    </span>
                                    @if ($fileUrl)
                                        <div class="small text-muted mt-1">{{ basename($currentFile) }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3">
                                <input type="file" name="{{ $field }}" class="form-control">
                            </div>

                            @if ($fileUrl)
                                <div class="mt-3">
                                    @if ($isImage)
                                        <img src="{{ $fileUrl }}" alt="{{ $label }} preview" class="img-fluid rounded" style="max-width: 250px; max-height: 250px;">
                                    @elseif ($isPdf)
                                        <div class="ratio ratio-16x9">
                                            <iframe src="{{ $fileUrl }}" title="{{ $label }} preview"></iframe>
                                        </div>
                                    @else
                                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">Open {{ $label }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-primary" type="submit">Save Documents</button>
                    <a href="{{ route('customer.profile') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
