@extends('layouts.landing')

@section('title', 'Terms & Conditions - ' . ($logoSettings->site_name ?? ''))

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="display-5">Terms & Conditions</h1>
            <p class="lead text-muted">These Terms and Conditions govern your use of Loan Linker. By using the site, you
                agree to these terms.</p>

            <h4 class="mt-4">Use of Service</h4>
            <p>Loan Linker provides a comparison platform to help users find loan products from banks. We are not a bank and
                do not provide financial advice. Always verify terms with the bank before accepting any offer.</p>

            <h4 class="mt-4">User Responsibilities</h4>
            <p>Users must provide accurate contact information when submitting inquiries. Misuse of the service, including
                spam or fraudulent activity, is prohibited.</p>

            <h4 class="mt-4">Intellectual Property</h4>
            <p>All content on Loan Linker is owned or licensed by us. You may not reproduce content without permission.</p>

            <h4 class="mt-4">Limitation of Liability</h4>
            <p>Loan Linker is not liable for decisions made based on information provided on the site. We strive for
                accuracy but cannot guarantee completeness.</p>

            <h4 class="mt-4">Contact</h4>
            <p>For questions regarding these terms, contact us at <a
                    href="mailto:{{ $aboutSettings->contact_email }}">{{ $aboutSettings->contact_email }}</a>.</p>
        </div>
    </section>
@endsection
