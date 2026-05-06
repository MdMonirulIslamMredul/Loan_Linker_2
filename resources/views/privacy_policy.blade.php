@extends('layouts.landing')

@section('title', 'Privacy Policy - ' . ($logoSettings->site_name ?? ''))

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="display-5">Privacy Policy</h1>
            <p class="lead text-muted">At Loan Linker, we respect your privacy. This page explains how we collect, use, and
                protect your information when you use our service to compare loan products from banks in Bangladesh.</p>

            <h4 class="mt-4">Information We Collect</h4>
            <ul>
                <li>Contact information you provide when contacting us (name, email, mobile, message).</li>
                <li>Technical data such as IP address and user agent to help prevent abuse.</li>
                <li>Non-identifying analytics about how you use the site to improve our service.</li>
            </ul>

            <h4 class="mt-4">How We Use Your Information</h4>
            <p>We use submitted contact messages to respond to inquiries and to improve our service. We do not sell personal
                information to third parties. We may share data with partner banks only as needed to process requests or
                connect you to relevant offers.</p>

            <h4 class="mt-4">Cookies & Analytics</h4>
            <p>We use cookies and analytics tools to understand site usage and to personalize content. You can control
                cookies through your browser settings.</p>

            <h4 class="mt-4">Security</h4>
            <p>We implement reasonable measures to protect your data. However, no system is completely secure—please
                exercise caution when sharing sensitive information.</p>

            <h4 class="mt-4">Contact</h4>
            <p>If you have questions about this policy or want your data removed, contact us at <a
                    href="mailto:{{ $aboutSettings->contact_email }}">{{ $aboutSettings->contact_email }}</a>.</p>
        </div>
    </section>
@endsection
