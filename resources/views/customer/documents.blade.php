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
                    'lend_document' => 'Lend Document (for Home Loan)',
                    'other_document' => 'Other Document',
                ] as $field => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        <input type="file" name="{{ $field }}" class="form-control">
                        @php
                            $currentFile = optional($customerDocument)->{$field};
                            $fileUrl = $currentFile ? asset('storage/' . $currentFile) : null;
                            $isImage = $currentFile ? preg_match('/\.(jpg|jpeg|png|gif|svg)$/i', $currentFile) : false;
                            $isPdf = $currentFile ? preg_match('/\.pdf$/i', $currentFile) : false;
                        @endphp
                        @if ($fileUrl)
                            <div class="form-text">
                                Current file: <a href="{{ $fileUrl }}" target="_blank">View</a>
                            </div>
                            <div class="mt-2">
                                @if ($isImage)
                                    <img src="{{ $fileUrl }}" alt="{{ $label }} preview" class="img-fluid img-thumbnail" style="max-width: 250px; max-height: 250px;">
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
                @endforeach

                <button class="btn btn-primary" type="submit">Save Documents</button>
                <a href="{{ route('customer.profile') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection
