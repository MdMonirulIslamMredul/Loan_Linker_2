@extends('layouts.landing')

@section('title', 'Terms & Conditions - ' . ($logoSettings->site_name ?? ''))

@push('styles')
    <style>
        .terms-hero {
            background: linear-gradient(135deg, #0b5ed7 0%, #764ba2 100%);
            color: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(11, 94, 215, 0.2);
        }

        .terms-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .terms-subtitle {
            color: rgba(255, 255, 255, 0.9);
        }

        .policy-nav,
        .policy-section,
        .policy-note {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(9, 30, 66, 0.08);
        }

        .policy-nav .list-group-item {
            border: 0;
            border-bottom: 1px solid #f1f4f8;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: #234;
        }

        .policy-nav .list-group-item:last-child {
            border-bottom: 0;
        }

        .policy-section {
            scroll-margin-top: 100px;
        }

        .section-number {
            width: 2rem;
            height: 2rem;
            flex: 0 0 2rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            background: #ede7f6;
            color: #764ba2;
        }

        .policy-section h3 {
            font-size: 1.2rem;
            margin-bottom: 0;
            color: #102a43;
        }

        .policy-section ul {
            padding-left: 1.1rem;
            margin-bottom: 0;
        }

        .policy-section li {
            margin-bottom: 0.4rem;
            color: #334e68;
        }

        .policy-section li:last-child {
            margin-bottom: 0;
        }

        .policy-note {
            border-left: 4px solid #764ba2;
        }

        .policy-note.alert-danger {
            border-left: 4px solid #dc3545;
            background: #fff6f6;
        }

        .policy-note.alert-warning {
            border-left: 4px solid #ffc107;
            background: #fffdf0;
        }

        .prohibited-list li {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0.5rem;
            color: #334e68;
        }

        @media (max-width: 991.98px) {
            .policy-nav {
                position: static !important;
            }
        }
    </style>
@endpush

@section('content')
    <section class="py-5">
        <div class="container">
            {{-- Hero --}}
            <div class="terms-hero p-4 p-md-5 mb-4 mb-md-5">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="terms-badge"><i class="bi bi-file-earmark-text"></i> Terms & Conditions</span>
                    <span class="terms-badge"><i class="bi bi-building"></i> Loan Linker</span>
                </div>
                <h1 class="display-5 fw-bold mb-2">শর্তাবলী (Terms & Conditions)</h1>
                <p class="mb-2 fs-5 fw-semibold">ডিজিটাল Loan Lead Marketplace</p>
                <p class="mb-1 terms-subtitle">সর্বশেষ আপডেট: July 2026</p>
                <p class="mb-0 terms-subtitle">ওয়েবসাইট: www.loanlinker.xyz &nbsp;|&nbsp; ঠিকানা: Mawna, Sreepur, Gazipur, Bangladesh</p>
            </div>

            <div class="row g-4">
                {{-- Sidebar Navigation --}}
                <div class="col-lg-4">
                    <div class="card policy-nav p-3 sticky-lg-top" style="top: 90px;">
                        <h5 class="fw-bold mb-3">Quick Navigation</h5>
                        <div class="list-group list-group-flush">
                            <a href="#section-1"  class="list-group-item list-group-item-action">১. শর্তাবলীর গ্রহণযোগ্যতা</a>
                            <a href="#section-2"  class="list-group-item list-group-item-action">২. Loan Linker সম্পর্কে</a>
                            <a href="#section-3"  class="list-group-item list-group-item-action">৩. যোগ্যতা</a>
                            <a href="#section-4"  class="list-group-item list-group-item-action">৪. ইউজার অ্যাকাউন্ট</a>
                            <a href="#section-5"  class="list-group-item list-group-item-action">৫. প্ল্যাটফর্মের সেবা</a>
                            <a href="#section-6"  class="list-group-item list-group-item-action">৬. Lead Purchase & Payment</a>
                            <a href="#section-7"  class="list-group-item list-group-item-action">৭. ডাটা প্রাইভেসি</a>
                            <a href="#section-8"  class="list-group-item list-group-item-action">৮. ব্যবহারকারীর দায়িত্ব</a>
                            <a href="#section-9"  class="list-group-item list-group-item-action">৯. নিষিদ্ধ কার্যক্রম</a>
                            <a href="#section-10" class="list-group-item list-group-item-action">১০. Lead Accuracy</a>
                            <a href="#section-11" class="list-group-item list-group-item-action">১১. Liability Limitation</a>
                            <a href="#section-12" class="list-group-item list-group-item-action">১২. No Guarantee Policy</a>
                            <a href="#section-13" class="list-group-item list-group-item-action">১৩. Account Suspension</a>
                            <a href="#section-14" class="list-group-item list-group-item-action">১৪. Intellectual Property</a>
                            <a href="#section-15" class="list-group-item list-group-item-action">১৫. বিরোধ নিষ্পত্তি</a>
                            <a href="#section-16" class="list-group-item list-group-item-action">১৬. Terms পরিবর্তন</a>
                            <a href="#section-17" class="list-group-item list-group-item-action">১৭. Force Majeure</a>
                            <a href="#section-18" class="list-group-item list-group-item-action">১৮. যোগাযোগ</a>
                        </div>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="col-lg-8">

                    {{-- Section 1 --}}
                    <div id="section-1" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১</span>
                            <h3>শর্তাবলীর গ্রহণযোগ্যতা</h3>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker ওয়েবসাইট, অ্যাপ বা সেবাসমূহ ব্যবহার করার মাধ্যমে আপনি এই শর্তাবলী মেনে নিতে সম্মত হচ্ছেন।</p>
                        <p class="text-secondary mb-2">যদি আপনি এই শর্তাবলীর কোনো অংশের সাথে একমত না হন, তাহলে অনুগ্রহ করে আমাদের প্ল্যাটফর্ম ব্যবহার করবেন না।</p>
                        <p class="text-secondary mb-0">Loan Linker যেকোনো সময় পূর্ব ঘোষণা ছাড়াই এই শর্তাবলী পরিবর্তন, সংশোধন বা আপডেট করার অধিকার সংরক্ষণ করে। আপডেটের পর প্ল্যাটফর্ম ব্যবহার চালিয়ে গেলে তা নতুন শর্তাবলী গ্রহণ হিসেবে গণ্য হবে।</p>
                    </div>

                    {{-- Section 2 --}}
                    <div id="section-2" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">২</span>
                            <h3>Loan Linker সম্পর্কে</h3>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker একটি ডিজিটাল Loan Lead Marketplace, যা সংযুক্ত করে:</p>
                        <ul class="mb-3">
                            <li>ঋণ বা ক্রেডিট কার্ড নিতে আগ্রহী গ্রাহক</li>
                            <li>যাচাইকৃত ব্যাংক কর্মকর্তা ও ফাইন্যান্সিয়াল প্রতিনিধিদের</li>
                        </ul>
                        <p class="text-secondary mb-2">Loan Linker কোনোভাবেই:</p>
                        <ul class="mb-3">
                            <li>ব্যাংক নয়</li>
                            <li>ঋণদাতা প্রতিষ্ঠান নয়</li>
                            <li>NBFI নয়</li>
                            <li>Loan Approval Authority নয়</li>
                            <li>Financial Advisory প্রতিষ্ঠান নয়</li>
                        </ul>
                        <p class="text-secondary mb-2">আমরা শুধুমাত্র গ্রাহক ও ব্যাংক কর্মকর্তাদের মধ্যে যোগাযোগ ও Lead Exchange-এর জন্য একটি ডিজিটাল প্ল্যাটফর্ম হিসেবে কাজ করি।</p>
                        <p class="text-secondary mb-0">Loan Linker কোনো ঋণ অনুমোদন, সুদের হার নির্ধারণ বা লোন নিশ্চিত করে না।</p>
                    </div>

                    {{-- Section 3 --}}
                    <div id="section-3" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৩</span>
                            <h3>যোগ্যতা (Eligibility)</h3>
                        </div>
                        <h6 class="fw-bold">৩.১ গ্রাহকদের জন্য</h6>
                        <p class="text-secondary mb-2">প্ল্যাটফর্ম ব্যবহার করতে হলে আপনাকে:</p>
                        <ul class="mb-4">
                            <li>কমপক্ষে ১৮ বছর বয়সী হতে হবে</li>
                            <li>সঠিক ও সত্য তথ্য প্রদান করতে হবে</li>
                            <li>বৈধ ও আসল ডকুমেন্ট আপলোড করতে হবে</li>
                        </ul>
                        <h6 class="fw-bold">৩.২ ব্যাংক কর্মকর্তাদের জন্য</h6>
                        <p class="text-secondary mb-2">ব্যাংক কর্মকর্তা বা প্রতিনিধি হিসেবে প্ল্যাটফর্ম ব্যবহার করতে হলে আপনাকে:</p>
                        <ul class="mb-3">
                            <li>কোনো অনুমোদিত ব্যাংক বা আর্থিক প্রতিষ্ঠানের কর্মী হতে হবে</li>
                            <li>বৈধ কর্মপরিচয় ও ভেরিফিকেশন প্রদান করতে হবে</li>
                            <li>গ্রাহকের তথ্যের গোপনীয়তা রক্ষা করতে হবে</li>
                            <li>শুধুমাত্র বৈধ ব্যাংকিং কার্যক্রমের জন্য তথ্য ব্যবহার করতে হবে</li>
                        </ul>
                        <p class="text-secondary mb-0">Loan Linker প্রয়োজন অনুযায়ী যেকোনো অ্যাকাউন্ট যাচাই, বাতিল, স্থগিত বা নিষিদ্ধ করতে পারবে।</p>
                    </div>

                    {{-- Section 4 --}}
                    <div id="section-4" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৪</span>
                            <h3>ইউজার অ্যাকাউন্ট ও নিরাপত্তা</h3>
                        </div>
                        <p class="text-secondary mb-2">আপনার অ্যাকাউন্টের সম্পূর্ণ নিরাপত্তার দায়িত্ব আপনার নিজের:</p>
                        <ul class="mb-3">
                            <li>Username</li>
                            <li>Password</li>
                            <li>OTP</li>
                            <li>Login তথ্য</li>
                        </ul>
                        <p class="text-secondary mb-2">আপনার অ্যাকাউন্টের মাধ্যমে সংঘটিত যেকোনো কার্যক্রম আপনার নিজের কার্যক্রম হিসেবে বিবেচিত হবে।</p>
                        <p class="text-secondary mb-0">যদি আপনি অননুমোদিত প্রবেশ, হ্যাকিং বা সন্দেহজনক কার্যক্রম লক্ষ্য করেন, তাহলে অবিলম্বে Loan Linker-কে জানাতে হবে।</p>
                    </div>

                    {{-- Section 5 --}}
                    <div id="section-5" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৫</span>
                            <h3>প্ল্যাটফর্মের সেবা</h3>
                        </div>
                        <h6 class="fw-bold">৫.১ গ্রাহকদের জন্য সেবা</h6>
                        <p class="text-secondary mb-2">গ্রাহকরা পারবেন:</p>
                        <ul class="mb-4">
                            <li>Loan বা Credit Card আবেদন জমা দিতে</li>
                            <li>বিভিন্ন ব্যাংকের অফার তুলনা করতে</li>
                            <li>যাচাইকৃত ব্যাংক কর্মকর্তার সাথে যোগাযোগ করতে</li>
                            <li>ব্যাংক প্রতিনিধিদের সহায়তা পেতে</li>
                        </ul>
                        <h6 class="fw-bold">৫.২ ব্যাংক কর্মকর্তাদের জন্য সেবা</h6>
                        <p class="text-secondary mb-2">ব্যাংক কর্মকর্তারা পারবেন:</p>
                        <ul class="mb-4">
                            <li>যাচাইকৃত গ্রাহক Lead দেখতে</li>
                            <li>Lead Purchase বা Unlock করতে</li>
                            <li>গ্রাহকের সাথে যোগাযোগ করতে</li>
                            <li>Dashboard, Payment History ও Lead Activity দেখতে</li>
                        </ul>
                        <h6 class="fw-bold">৫.৩ গুরুত্বপূর্ণ ঘোষণা</h6>
                        <p class="text-secondary mb-2">Loan Linker কখনোই নিশ্চয়তা দেয় না:</p>
                        <ul class="mb-3">
                            <li>Loan Approval</li>
                            <li>Credit Card Approval</li>
                            <li>Processing Time</li>
                            <li>Interest Rate</li>
                            <li>Customer Response</li>
                            <li>ব্যাংক সুবিধা</li>
                        </ul>
                        <p class="text-secondary mb-0">সকল চূড়ান্ত সিদ্ধান্ত সংশ্লিষ্ট ব্যাংক বা আর্থিক প্রতিষ্ঠানের নিজস্ব নীতিমালার উপর নির্ভরশীল।</p>
                    </div>

                    {{-- Section 6 --}}
                    <div id="section-6" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৬</span>
                            <h3>Lead Purchase ও Payment Policy</h3>
                        </div>
                        <h6 class="fw-bold">৬.১ Lead Fee</h6>
                        <p class="text-secondary mb-2">ব্যাংক কর্মকর্তারা Lead সংগ্রহ করতে পারবেন:</p>
                        <ul class="mb-3">
                            <li>প্রতি Lead ভিত্তিক মূল্য দিয়ে</li>
                            <li>Monthly বা Annual Subscription-এর মাধ্যমে</li>
                            <li>বিশেষ Package বা Promotional Plan-এর মাধ্যমে</li>
                        </ul>
                        <p class="text-secondary mb-4">Lead-এর মূল্য বিভিন্ন বিষয়ের উপর নির্ভর করে পরিবর্তিত হতে পারে।</p>

                        <h6 class="fw-bold">৬.২ পেমেন্ট পদ্ধতি</h6>
                        <p class="text-secondary mb-2">পেমেন্ট করা যেতে পারে:</p>
                        <ul class="mb-3">
                            <li>bKash</li>
                            <li>Nagad</li>
                            <li>Bank Transfer</li>
                            <li>Mobile Financial Service</li>
                            <li>অথবা Loan Linker অনুমোদিত অন্য যেকোনো মাধ্যমে</li>
                        </ul>
                        <p class="text-secondary mb-4">পূর্ণ পেমেন্ট সম্পন্ন হওয়ার পরই Lead Access প্রদান করা হবে।</p>

                        <h6 class="fw-bold">৬.৩ Refund Policy</h6>
                        <ul class="mb-3">
                            <li>সকল Payment Non-Refundable</li>
                            <li>Subscription Transfer করা যাবে না</li>
                            <li>Lead Unlock হওয়ার পর Refund প্রযোজ্য নয়</li>
                        </ul>
                        <p class="text-secondary mb-4">তবে বিশেষ টেকনিক্যাল বা প্রশাসনিক কারণে Loan Linker ব্যতিক্রমী সিদ্ধান্ত নিতে পারে।</p>

                        <h6 class="fw-bold">৬.৪ Lead Ownership</h6>
                        <p class="text-secondary mb-2">Lead Purchase করার পর:</p>
                        <ul class="mb-3">
                            <li>কর্মকর্তা Customer Information Access পাবেন</li>
                            <li>Lead অন্য কারও কাছে বিক্রি বা শেয়ার করা যাবে না</li>
                            <li>অননুমোদিত মার্কেটিং বা বাণিজ্যিক কাজে ব্যবহার করা যাবে না</li>
                        </ul>
                        <p class="text-secondary mb-0">Loan Linker Customer Response বা Conversion Guarantee দেয় না।</p>
                    </div>

                    {{-- Section 7 --}}
                    <div id="section-7" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৭</span>
                            <h3>ডাটা প্রাইভেসি ও নিরাপত্তা</h3>
                        </div>
                        <h6 class="fw-bold">৭.১ Customer Data Protection</h6>
                        <p class="text-secondary mb-2"><strong>তথ্যের ব্যবহার:</strong></p>
                        <ul class="mb-3">
                            <li><strong>অনুমোদিত এক্সেস:</strong> লোন বা ক্রেডিট কার্ডের আবেদনের পর সংশ্লিষ্ট অফিসারগন গ্রাহকের সব তথ্য ও ডকুমেন্ট দেখার অধিকারী হবেন।</li>
                            <li><strong>উদ্দেশ্য:</strong> সংগৃহীত তথ্যসমূহ শুধুমাত্র উক্ত লোন বা ক্রেডিট কার্ড প্রসেসিং এবং ভেরিফিকেশনের কাজে ব্যবহার করা যাবে।</li>
                        </ul>
                        <p class="text-secondary mb-2"><strong>অফিসারের জন্য নিষিদ্ধ কার্যক্রম:</strong></p>
                        <ul class="mb-3">
                            <li>গ্রাহকের তথ্য কোনো তৃতীয় পক্ষের কাছে বিক্রি বা হস্তান্তর করা।</li>
                            <li>যথাযথ অনুমতি ছাড়া যেকোনো তথ্য বা ডকুমেন্ট শেয়ার করা।</li>
                            <li>অপ্রাসঙ্গিক মার্কেটিং, স্প্যাম (Spam) বা গ্রাহককে কোনো প্রকার হয়রানি করা।</li>
                        </ul>
                        <p class="text-secondary mb-2"><strong>নিয়ম ভঙ্গের শাস্তি:</strong> কোনো অফিসার উপরোক্ত নিয়ম ভঙ্গ করলে বা তথ্যের অপব্যবহার করলে:</p>
                        <ul class="mb-4">
                            <li>তাকে প্ল্যাটফর্ম থেকে স্থায়ীভাবে বরখাস্ত (Permanent Ban) করা হবে।</li>
                            <li>প্রচলিত আইন অনুযায়ী তার বিরুদ্ধে কঠোর আইনগত ব্যবস্থা (Legal Action) গ্রহণ করা হবে।</li>
                        </ul>

                        <h6 class="fw-bold">৭.২ Officer Verification</h6>
                        <p class="text-secondary mb-2">ব্যাংক কর্মকর্তাদের প্রয়োজন হতে পারে:</p>
                        <ul class="mb-3">
                            <li>NID</li>
                            <li>Employee ID</li>
                            <li>Official Email</li>
                            <li>Official Phone Number</li>
                            <li>Bank Name ও Branch Information</li>
                        </ul>
                        <p class="fw-semibold text-dark mb-0">ভুয়া তথ্য প্রদান সম্পূর্ণ নিষিদ্ধ।</p>
                    </div>

                    {{-- Section 8 --}}
                    <div id="section-8" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৮</span>
                            <h3>ব্যবহারকারীর দায়িত্ব</h3>
                        </div>
                        <h6 class="fw-bold">গ্রাহকদের অবশ্যই:</h6>
                        <ul class="mb-4">
                            <li>আসল ও সঠিক ডকুমেন্ট প্রদান করতে হবে</li>
                            <li>বাংলাদেশের আর্থিক আইন মেনে চলতে হবে</li>
                            <li>Fake বা Manipulated Document ব্যবহার করা যাবে না</li>
                        </ul>
                        <h6 class="fw-bold">ব্যাংক কর্মকর্তাদের অবশ্যই:</h6>
                        <ul>
                            <li>Professional আচরণ বজায় রাখতে হবে</li>
                            <li>Customer Information গোপন রাখতে হবে</li>
                            <li>অবৈধ প্রতিশ্রুতি বা Shortcut প্রদান করা যাবে না</li>
                            <li>ব্যাংকের Compliance Policy অনুসরণ করতে হবে</li>
                        </ul>
                    </div>

                    {{-- Section 9 --}}
                    <div id="section-9" class="card policy-note alert-danger p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-shield-exclamation text-danger fs-5"></i>
                            <h3 class="mb-0" style="font-size:1.2rem; color:#102a43;">নিষিদ্ধ কার্যক্রম</h3>
                        </div>
                        <p class="text-secondary mb-2">নিচের কার্যক্রম সম্পূর্ণ নিষিদ্ধ:</p>
                        <ul class="prohibited-list mb-0" style="padding-left:0;">
                            <li>❌ ভুয়া তথ্য প্রদান</li>
                            <li>❌ ব্যাংক কর্মকর্তা সেজে প্রতারণা</li>
                            <li>❌ ডাটা চুরি বা অপব্যবহার</li>
                            <li>❌ Harassment বা Abusive আচরণ</li>
                            <li>❌ ঘুষ বা অবৈধ কমিশন লেনদেন</li>
                            <li>❌ Malware বা ক্ষতিকর কনটেন্ট আপলোড</li>
                            <li>❌ Platform Manipulation</li>
                            <li>❌ আইনবিরোধী কার্যক্রম</li>
                        </ul>
                    </div>

                    {{-- Section 10 --}}
                    <div id="section-10" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১০</span>
                            <h3>Lead Accuracy ও Availability</h3>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker যথাসম্ভব সঠিক ও কার্যকর Lead প্রদান করার চেষ্টা করে। তবে:</p>
                        <ul class="mb-3">
                            <li>গ্রাহক সিদ্ধান্ত পরিবর্তন করতে পারেন</li>
                            <li>কিছু গ্রাহক যোগাযোগ নাও করতে পারেন</li>
                            <li>Loan Eligibility ব্যাংকভেদে ভিন্ন হতে পারে</li>
                        </ul>
                        <p class="text-secondary mb-0">Loan Linker কোনো Lead-এর সফলতা বা Loan Approval নিশ্চিত করে না।</p>
                    </div>

                    {{-- Section 11 --}}
                    <div id="section-11" class="card policy-note alert-warning p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-exclamation-circle-fill text-warning fs-5"></i>
                            <h3 class="mb-0" style="font-size:1.2rem; color:#102a43;">Liability Limitation</h3>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker দায়ী থাকবে না:</p>
                        <ul class="mb-3">
                            <li><strong>Loan Rejection:</strong> লোন আবেদন প্রত্যাখ্যান হলে।</li>
                            <li><strong>Customer Non-Response:</strong> গ্রাহকের পক্ষ থেকে কোনো সাড়া বা যোগাযোগ না পাওয়া গেলে।</li>
                            <li><strong>Officer Misconduct:</strong> কোনো অফিসারের অসদাচরণ বা নীতিবহির্ভূত কাজের জন্য।</li>
                            <li><strong>Financial Loss:</strong> যেকোনো ধরনের আর্থিক ক্ষতির জন্য।</li>
                            <li><strong>System Downtime:</strong> সিস্টেমের সাময়িক নিষ্ক্রিয়তা বা বন্ধ থাকার কারণে।</li>
                            <li><strong>Technical Error:</strong> কারিগরি ত্রুটি বা টেকনিক্যাল সমস্যার জন্য।</li>
                            <li><strong>Business Loss:</strong> ব্যবসায়িক কোনো ক্ষতির সম্মুখীন হলে।</li>
                        </ul>
                        <p class="text-secondary mb-2"><strong>বিশেষ দ্রষ্টব্য:</strong> লোন অনুমোদন (Approve) বা প্রত্যাখ্যান (Reject) করার চূড়ান্ত সিদ্ধান্ত এবং পরবর্তীতে উক্ত লোন রিকভারি বা আদায়ের সম্পূর্ণ দায়িত্ব ও দায়ভার সংশ্লিষ্ট ব্যাংক বা আর্থিক প্রতিষ্ঠানের। এই প্রক্রিয়ায় Loan Linker কোনো ধরনের দায় বহন করবে না।</p>
                        <p class="text-secondary mb-0">সর্বোচ্চ দায় শুধুমাত্র প্রদত্ত সার্ভিস ফি বা Lead Fee-এর সীমার মধ্যে সীমাবদ্ধ থাকবে।</p>
                    </div>

                    {{-- Section 12 --}}
                    <div id="section-12" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১২</span>
                            <h3>No Guarantee Policy</h3>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker শুধুমাত্র একটি সংযোগ প্ল্যাটফর্ম।</p>
                        <p class="text-secondary mb-2">আমরা কোনো নিশ্চয়তা দিই না:</p>
                        <ul>
                            <li>Loan Approval</li>
                            <li>Credit Card Approval</li>
                            <li>Interest Rate</li>
                            <li>Processing Speed</li>
                            <li>Officer Performance</li>
                            <li>Financial Benefit</li>
                        </ul>
                    </div>

                    {{-- Section 13 --}}
                    <div id="section-13" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১৩</span>
                            <h3>Account Suspension ও Termination</h3>
                        </div>
                        <p class="text-secondary mb-2">নিম্নোক্ত কারণে Loan Linker যেকোনো Account Suspend বা Terminate করতে পারবে:</p>
                        <ul class="mb-3">
                            <li>Terms Violations</li>
                            <li>Fraudulent Activity</li>
                            <li>Fake Identity</li>
                            <li>Data Misuse</li>
                            <li>Payment Violation</li>
                            <li>Security Risk</li>
                        </ul>
                        <p class="text-secondary mb-0">পূর্ব নোটিশ ছাড়াই অ্যাকাউন্ট বন্ধ করা হতে পারে।</p>
                    </div>

                    {{-- Section 14 --}}
                    <div id="section-14" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১৪</span>
                            <h3>Intellectual Property Rights</h3>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker-এর নিচের সব কিছু মেধাস্বত্ব আইন দ্বারা সুরক্ষিত:</p>
                        <ul class="mb-3">
                            <li>Logo</li>
                            <li>Branding</li>
                            <li>Website Design</li>
                            <li>Database</li>
                            <li>Software Interface</li>
                            <li>Content</li>
                        </ul>
                        <p class="text-secondary mb-0">অনুমতি ছাড়া কোনো কনটেন্ট Copy, Modify, Resell বা Redistribute করা যাবে না।</p>
                    </div>

                    {{-- Section 15 --}}
                    <div id="section-15" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১৫</span>
                            <h3>বিরোধ নিষ্পত্তি (Dispute Resolution)</h3>
                        </div>
                        <p class="text-secondary mb-2">যেকোনো বিরোধ নিম্নোক্ত প্রক্রিয়ায় সমাধান করা হবে:</p>
                        <ul class="mb-3">
                            <li>Internal Review</li>
                            <li>Mediation</li>
                            <li>প্রয়োজনে বাংলাদেশের প্রচলিত আইনের অধীনে আইনি ব্যবস্থা</li>
                        </ul>
                        <p class="text-secondary mb-0"><strong>Jurisdiction:</strong> Gazipur, Bangladesh-এর প্রযোজ্য আদালত।</p>
                    </div>

                    {{-- Section 16 --}}
                    <div id="section-16" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১৬</span>
                            <h3>Terms পরিবর্তনের অধিকার</h3>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker যেকোনো সময় নিচের বিষয়গুলো পরিবর্তন বা আপডেট করার অধিকার সংরক্ষণ করে:</p>
                        <ul>
                            <li>Platform Feature</li>
                            <li>Pricing</li>
                            <li>Subscription Plan</li>
                            <li>Service Policy</li>
                        </ul>
                    </div>

                    {{-- Section 17 --}}
                    <div id="section-17" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১৭</span>
                            <h3>Force Majeure</h3>
                        </div>
                        <p class="text-secondary mb-2">নিম্নোক্ত অনিয়ন্ত্রিত পরিস্থিতির জন্য Loan Linker দায়ী থাকবে না:</p>
                        <ul>
                            <li>প্রাকৃতিক দুর্যোগ</li>
                            <li>ইন্টারনেট বিভ্রাট</li>
                            <li>Cyber Attack</li>
                            <li>Power Failure</li>
                            <li>Government Restriction</li>
                            <li>Third-Party Service Failure</li>
                        </ul>
                    </div>

                    {{-- Section 18 --}}
                    <div id="section-18" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১৮</span>
                            <h3>যোগাযোগের তথ্য</h3>
                        </div>
                        <p class="text-secondary mb-3">এই শর্তাবলী সম্পর্কে কোনো প্রশ্ন বা অভিযোগ থাকলে যোগাযোগ করুন:</p>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>Loan Linker</strong></li>
                            <li class="mb-2"><i class="bi bi-geo-alt me-2 text-muted"></i>Mawna, Sreepur, Gazipur, Bangladesh</li>
                            <li class="mb-2"><i class="bi bi-envelope me-2 text-muted"></i>Email: <a href="mailto:care@loanlinker.xyz">care@loanlinker.xyz</a></li>
                            <li class="mb-0"><i class="bi bi-globe me-2 text-muted"></i>Website: <a href="https://www.loanlinker.xyz" target="_blank">www.loanlinker.xyz</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection