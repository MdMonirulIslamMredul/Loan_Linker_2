@extends('layouts.branch-admin')

@section('title', 'Officer Documents')
@section('dashboard-title', 'Officer Documents')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="mb-4">Upload Officer Documents</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('branch-admin.officer-document.store') }}" enctype="multipart/form-data">
                @csrf

                @php
                    $documentFields = [
                        'picture' => 'Picture',
                        'nid' => 'NID',
                        'office_id' => 'Office ID',
                        'visiting_card' => 'Visiting Card',
                    ];
                    $hasMissingDocument = collect($documentFields)->contains(fn ($label, $field) => !optional($officerDocument)->{$field});
                @endphp

                @if (!$hasMissingDocument)
                    <div class="alert alert-info">
                        All officer documents are already uploaded. If you need to change any uploaded document, please contact admin.
                    </div>
                @endif

                @foreach ($documentFields as $field => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>

                        @php
                            $currentFile = optional($officerDocument)->{$field};
                            $fileUrl = $currentFile ? asset('storage/' . $currentFile) : null;
                            $isImage = $currentFile ? preg_match('/\.(jpg|jpeg|png|gif|svg)$/i', $currentFile) : false;
                            $isPdf = $currentFile ? preg_match('/\.pdf$/i', $currentFile) : false;
                        @endphp

                        <input type="file" name="{{ $field }}" class="form-control" {{ $fileUrl ? 'disabled' : '' }}>

                        @if ($fileUrl)
                            <div class="form-text mt-1 text-warning">
                                This document has already been uploaded and cannot be changed. Please contact admin if you need an update.
                            </div>
                        @endif

                        @if ($fileUrl)
                            <div class="form-text mt-1">
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

                <button class="btn btn-primary" type="submit" {{ $hasMissingDocument ? '' : 'disabled' }}>Save Documents</button>
                <a href="{{ route('branch-admin.profile') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection
