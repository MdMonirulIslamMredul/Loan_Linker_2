@extends('layouts.landing')

@section('title', 'Customer Rights & Responsibilities - ' . ($logoSettings->site_name ?? ''))

@push('styles')
    <style>
        .crr-hero {
            background: linear-gradient(140deg, #0f766e 0%, #14532d 55%, #0ea5e9 100%);
            color: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(15, 118, 110, 0.25);
        }

        .crr-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .crr-subtitle {
            color: rgba(255, 255, 255, 0.9);
        }

        .crr-nav,
        .crr-section,
        .crr-note {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(9, 30, 66, 0.08);
        }

        .crr-nav .list-group-item {
            border: 0;
            border-bottom: 1px solid #eef2f7;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: #1f2937;
        }

        .crr-nav .list-group-item:last-child {
            border-bottom: 0;
        }

        .crr-section {
            scroll-margin-top: 100px;
        }

        .crr-number {
            width: 2rem;
            height: 2rem;
            flex: 0 0 2rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            background: #dcfce7;
            color: #166534;
        }

        .crr-section h3 {
            font-size: 1.2rem;
            margin-bottom: 0;
            color: #0f172a;
        }

        .crr-section ul {
            padding-left: 1.1rem;
            margin-bottom: 0;
        }

        .crr-section li {
            margin-bottom: 0.45rem;
            color: #334155;
        }

        .crr-section li:last-child {
            margin-bottom: 0;
        }

        .crr-note {
            border-left: 4px solid #ea580c;
            background: #fffaf5;
        }

        .crr-help {
            border-left: 4px solid #0ea5e9;
            background: #f0f9ff;
        }

        .commitment-points li {
            list-style: none;
            position: relative;
            padding-left: 1.6rem;
            margin-bottom: 0.55rem;
        }

        .commitment-points li::before {
            content: "\2713";
            position: absolute;
            left: 0;
            top: 0.05rem;
            color: #15803d;
            font-weight: 700;
        }

        @media (max-width: 991.98px) {
            .crr-nav {
                position: static !important;
            }
        }
    </style>
@endpush

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="crr-hero p-4 p-md-5 mb-4 mb-md-5">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="crr-badge"><i class="bi bi-people-fill"></i> Customer Rights &amp; Responsibilities</span>
                    <span class="crr-badge"><i class="bi bi-building"></i> Loan Linker</span>
                </div>
                <h1 class="display-5 fw-bold mb-2">Customer Rights &amp; Responsibilities</h1>
                <p class="mb-1 fs-5 fw-semibold">Welcome to Loan Linker</p>
                <p class="mb-0 crr-subtitle">Loan Linker-এ আপনাকে স্বাগতম।</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card crr-nav p-3 sticky-lg-top" style="top: 90px;">
                        <h5 class="fw-bold mb-3">Quick Navigation</h5>
                        <div class="list-group list-group-flush">
                            <a href="#intro" class="list-group-item list-group-item-action">ভূমিকা</a>
                            <a href="#rights" class="list-group-item list-group-item-action">Customer Rights</a>
                            <a href="#responsibilities" class="list-group-item list-group-item-action">Customer
                                Responsibilities</a>
                            <a href="#disclaimer" class="list-group-item list-group-item-action">Important Disclaimer</a>
                            <a href="#commitment" class="list-group-item list-group-item-action">Our Commitment</a>
                            <a href="#help" class="list-group-item list-group-item-action">Need Help?</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div id="intro" class="card crr-section p-4 mb-4">
                        <p class="mb-0 text-secondary lh-lg">
                            আমরা বিশ্বাস করি, একটি নিরাপদ, স্বচ্ছ এবং দায়িত্বশীল ডিজিটাল আর্থিক সেবা নিশ্চিত করতে গ্রাহক এবং
                            Loan Linker-উভয়েরই কিছু অধিকার ও দায়িত্ব রয়েছে। অনুগ্রহ করে নিচের নির্দেশনাগুলো মনোযোগ সহকারে
                            পড়ুন।
                        </p>
                    </div>

                    <div id="rights" class="card crr-section p-4 mb-4">
                        <h2 class="h4 fw-bold mb-4">Customer Rights (গ্রাহকের অধিকার)</h2>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">১</span>
                                <h3>সঠিক ও স্বচ্ছ তথ্য জানার অধিকার</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                আপনার Loan বা Credit Card আবেদন, প্রক্রিয়া, প্রয়োজনীয় কাগজপত্র এবং আমাদের সেবার সীমাবদ্ধতা
                                সম্পর্কে পরিষ্কার তথ্য জানার অধিকার আপনার রয়েছে।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">২</span>
                                <h3>নিরাপদ তথ্য সংরক্ষণের অধিকার</h3>
                            </div>
                            <p class="text-secondary mb-2">আপনার ব্যক্তিগত তথ্য, যেমন:</p>
                            <ul class="mb-2">
                                <li>নাম</li>
                                <li>মোবাইল নম্বর</li>
                                <li>NID</li>
                                <li>ঠিকানা</li>
                                <li>আয় সংক্রান্ত তথ্য</li>
                                <li>প্রয়োজনীয় ডকুমেন্ট</li>
                            </ul>
                            <p class="text-secondary mb-0">
                                যথাযথ নিরাপত্তার সঙ্গে সংরক্ষণ করা হবে এবং আপনার সম্মতি ছাড়া কোনো অননুমোদিত তৃতীয় পক্ষের
                                কাছে প্রকাশ করা হবে না।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৩</span>
                                <h3>স্বাধীন সিদ্ধান্ত গ্রহণের অধিকার</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                আপনি নিজেই সিদ্ধান্ত নেবেন কোন ব্যাংক বা Financial Institution-এর সেবা গ্রহণ করবেন। Loan
                                Linker কোনো নির্দিষ্ট ব্যাংকের সেবা গ্রহণে আপনাকে বাধ্য করবে না।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৪</span>
                                <h3>সম্মতির অধিকার (Consent)</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                আপনার অনুমতি ছাড়া আপনার আবেদন বা ব্যক্তিগত তথ্য কোনো ব্যাংক বা ব্যাংক অফিসারের সঙ্গে শেয়ার
                                করা হবে না।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৫</span>
                                <h3>ন্যায্য ও সম্মানজনক সেবা পাওয়ার অধিকার</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                আপনি বৈষম্য, হয়রানি বা অনৈতিক আচরণ ছাড়া পেশাদার সেবা পাওয়ার অধিকার রাখেন।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৬</span>
                                <h3>অভিযোগ করার অধিকার</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                যদি আপনি কোনো সমস্যা, অসদাচরণ বা প্রতারণার শিকার হন, তাহলে Loan Linker-এর কাছে অভিযোগ জানাতে
                                পারবেন। আমরা যথাসম্ভব দ্রুত বিষয়টি পর্যালোচনা করে প্রয়োজনীয় ব্যবস্থা গ্রহণ করব।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৭</span>
                                <h3>সেবা প্রত্যাখ্যানের অধিকার</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                যেকোনো সময় আপনি আপনার আবেদন বন্ধ করার বা ভবিষ্যতে যোগাযোগ না করার অনুরোধ করতে পারবেন (যদি
                                আইনগত বা প্রক্রিয়াগত কোনো বাধ্যবাধকতা না থাকে)।
                            </p>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৮</span>
                                <h3>গোপনীয়তা রক্ষার অধিকার</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                আপনার ব্যক্তিগত তথ্য শুধুমাত্র প্রয়োজনীয় সেবা প্রদানের উদ্দেশ্যে ব্যবহার করা হবে।
                            </p>
                        </div>
                    </div>

                    <div id="responsibilities" class="card crr-section p-4 mb-4">
                        <h2 class="h4 fw-bold mb-4">Customer Responsibilities (গ্রাহকের দায়িত্ব)</h2>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">১</span>
                                <h3>সঠিক তথ্য প্রদান করুন</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                Loan বা Credit Card-এর জন্য আবেদন করার সময় সর্বদা সঠিক ও হালনাগাদ তথ্য প্রদান করুন। ভুল বা
                                মিথ্যা তথ্য আবেদন বাতিল হওয়ার কারণ হতে পারে।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">২</span>
                                <h3>বৈধ কাগজপত্র জমা দিন</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                শুধুমাত্র সত্য ও বৈধ ডকুমেন্ট প্রদান করুন। জাল বা পরিবর্তিত কোনো ডকুমেন্ট ব্যবহার করা আইনত
                                দণ্ডনীয়।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৩</span>
                                <h3>কোনো অবৈধ অর্থ লেনদেন করবেন না</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                কোনো ব্যাংক কর্মকর্তা বা অন্য কাউকে ব্যক্তিগতভাবে ঘুষ, কমিশন বা অননুমোদিত অর্থ প্রদান করবেন
                                না। যদি কেউ এ ধরনের দাবি করে, সঙ্গে সঙ্গে Loan Linker-কে জানান।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৪</span>
                                <h3>ব্যক্তিগত নিরাপত্তা বজায় রাখুন</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                কেউ যদি ব্যাংকের বাইরে ব্যক্তিগত স্থানে দেখা করতে বলে, তাহলে সতর্ক থাকুন। সম্ভব হলে ব্যাংক
                                শাখা বা নিরাপদ স্থানে যোগাযোগ করুন।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৫</span>
                                <h3>OTP, PIN ও Password গোপন রাখুন</h3>
                            </div>
                            <p class="text-secondary mb-2">কাউকেই কখনো আপনার</p>
                            <ul class="mb-2">
                                <li>OTP</li>
                                <li>PIN</li>
                                <li>Password</li>
                                <li>CVV</li>
                                <li>ATM PIN</li>
                                <li>Internet Banking Password</li>
                            </ul>
                            <p class="text-secondary mb-0">প্রদান করবেন না। Loan Linker বা কোনো ব্যাংক কর্মকর্তা এসব তথ্য
                                চাইবে না।</p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৬</span>
                                <h3>ব্যাংকের সিদ্ধান্তকে সম্মান করুন</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                Loan বা Credit Card অনুমোদনের চূড়ান্ত সিদ্ধান্ত সম্পূর্ণভাবে সংশ্লিষ্ট ব্যাংক বা Financial
                                Institution-এর। Loan Linker কোনো Approval নিশ্চিত করতে পারে না।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৭</span>
                                <h3>যাচাই না হওয়া পর্যন্ত বিকল্প সুযোগ খোলা রাখুন</h3>
                            </div>
                            <p class="text-secondary mb-0">
                                আপনার আবেদন চূড়ান্তভাবে অনুমোদিত না হওয়া পর্যন্ত অন্য আগ্রহী ব্যাংক অফিসারদের আবেদন
                                পর্যালোচনার সুযোগ বন্ধ করে দেবেন না।
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৮</span>
                                <h3>প্রতারণা দেখলে রিপোর্ট করুন</h3>
                            </div>
                            <p class="text-secondary mb-2">যদি কোনো ব্যক্তি</p>
                            <ul class="mb-2">
                                <li>অতিরিক্ত টাকা দাবি করে</li>
                                <li>ভুয়া পরিচয় দেয়</li>
                                <li>ব্যক্তিগত অ্যাকাউন্টে টাকা পাঠাতে বলে</li>
                                <li>ভুয়া Loan Approval-এর প্রতিশ্রুতি দেয়</li>
                            </ul>
                            <p class="text-secondary mb-0">তাহলে দ্রুত Loan Linker-কে জানান।</p>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="crr-number">৯</span>
                                <h3>শর্তাবলী মেনে চলুন</h3>
                            </div>
                            <p class="text-secondary mb-2">Website-এর</p>
                            <ul class="mb-2">
                                <li>Terms &amp; Conditions</li>
                                <li>Privacy Policy</li>
                                <li>Disclaimer</li>
                            </ul>
                            <p class="text-secondary mb-0">অনুসরণ করা প্রত্যেক গ্রাহকের দায়িত্ব।</p>
                        </div>
                    </div>

                    <div id="disclaimer" class="card crr-note p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                            <h4 class="fw-bold mb-0">Important Disclaimer</h4>
                        </div>
                        <ul>
                            <li>Loan Linker কোনো ব্যাংক বা Non-Bank Financial Institution (NBFI) নয়।</li>
                            <li>আমরা কোনো ঋণ বা Credit Card অনুমোদন করি না।</li>
                            <li>আমরা কেবল গ্রাহক ও যাচাইকৃত ব্যাংক কর্মকর্তাদের মধ্যে সংযোগ স্থাপন করি।</li>
                            <li>
                                Loan বা Credit Card অনুমোদনের সম্পূর্ণ সিদ্ধান্ত সংশ্লিষ্ট ব্যাংক বা Financial
                                Institution-এর
                                নিজস্ব নীতিমালা ও যোগ্যতার ভিত্তিতে নেওয়া হয়।
                            </li>
                        </ul>
                    </div>

                    <div id="commitment" class="card crr-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-stars text-success"></i>
                            <h4 class="fw-bold mb-0">Our Commitment</h4>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker প্রতিশ্রুতিবদ্ধ-</p>
                        <ul class="commitment-points mb-0">
                            <li>স্বচ্ছ সেবা প্রদান করতে</li>
                            <li>গ্রাহকের তথ্য নিরাপদ রাখতে</li>
                            <li>যাচাইকৃত ব্যাংক কর্মকর্তার সঙ্গে সংযোগ নিশ্চিত করতে</li>
                            <li>দ্রুত ও নির্ভরযোগ্য ডিজিটাল অভিজ্ঞতা দিতে</li>
                            <li>নৈতিক ও আইনসম্মত ব্যবসায়িক মান বজায় রাখতে</li>
                        </ul>
                    </div>

                    <div id="help" class="card crr-help crr-section p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-headset text-info"></i>
                            <h4 class="fw-bold mb-0">Need Help?</h4>
                        </div>
                        <p class="text-secondary mb-3">
                            যদি আপনার কোনো প্রশ্ন, অভিযোগ বা পরামর্শ থাকে, আমাদের সঙ্গে যোগাযোগ করুন।
                        </p>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">Email: <a href="mailto:care@loanlinker.xyz">care@loanlinker.xyz</a></li>
                            <li class="mb-2">Hotline: <a href="tel:+8809697322750">+880 9697-322750</a></li>
                            <li class="mb-0">Website: <a href="https://www.loanlinker.xyz"
                                    target="_blank">www.loanlinker.xyz</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
