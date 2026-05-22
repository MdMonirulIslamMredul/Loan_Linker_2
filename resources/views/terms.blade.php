@extends('layouts.landing')

@section('title', 'Terms & Conditions - ' . ($logoSettings->site_name ?? ''))

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-body py-5 px-4 px-md-5">
                            <div class="text-center mb-5">
                                <span class="badge bg-primary mb-3">Legal</span>
                                <h1 class="display-5">{{ $terms->title ?? 'Terms & Conditions' }}</h1>
                                <p class="text-muted">Please read these terms carefully before using Loan Linker.</p>
                            </div>

                            <div class="mb-4">
                                @if ($terms)
                                    {!! $terms->content !!}
                                @else
                                    <p class="text-muted">No active terms and conditions are available at this time. Please check back later.</p>
                                @endif
                            </div>

                            <div class="mt-5 border-top pt-4">
                                <h5>Contact</h5>
                                <p class="text-muted mb-0">
                                    If you have questions regarding these terms, contact us at
                                    <a href="mailto:{{ $aboutSettings->contact_email }}">{{ $aboutSettings->contact_email }}</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
