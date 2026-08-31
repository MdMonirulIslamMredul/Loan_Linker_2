@extends('layouts.landing')

@section('title', 'Privacy Policy - ' . ($logoSettings->site_name ?? ''))

@push('styles')
    <style>
        .privacy-hero {
            background: linear-gradient(135deg, #0b5ed7 0%, #198754 100%);
            color: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(11, 94, 215, 0.2);
        }

        .privacy-badge {
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

        .privacy-subtitle {
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
            background: #e7f1ff;
            color: #0b5ed7;
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
            border-left: 4px solid #198754;
        }

        .policy-note.alert {
            border-left: 4px solid #dc3545;
            background: #fff6f6;
        }

        .trust-points li {
            list-style: none;
            position: relative;
            padding-left: 1.6rem;
            margin-bottom: 0.55rem;
        }

        .trust-points li::before {
            content: "\2713";
            position: absolute;
            left: 0;
            top: 0.05rem;
            color: #198754;
            font-weight: 700;
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
            <div class="privacy-hero p-4 p-md-5 mb-4 mb-md-5">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="privacy-badge"><i class="bi bi-shield-lock"></i> Privacy Policy</span>
                    <span class="privacy-badge"><i class="bi bi-building"></i> Loan Linker</span>
                </div>
                <h1 class="display-5 fw-bold mb-2">Privacy Policy</h1>
                <p class="mb-2 fs-5 fw-semibold">Smart Connection Between Customer &amp; Bank</p>
                <p class="mb-0 privacy-subtitle">Last Updated: 11/07/2026</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card policy-nav p-3 sticky-lg-top" style="top: 90px;">
                        <h5 class="fw-bold mb-3">Quick Navigation</h5>
                        <div class="list-group list-group-flush">
                            <a href="#intro" class="list-group-item list-group-item-action">ভূমিকা</a>
                            <a href="#section-1" class="list-group-item list-group-item-action">১. তথ্য সংগ্রহ</a>
                            <a href="#section-2" class="list-group-item list-group-item-action">২. তথ্যের ব্যবহার</a>
                            <a href="#section-3" class="list-group-item list-group-item-action">৩. তথ্য শেয়ারিং</a>
                            <a href="#section-4" class="list-group-item list-group-item-action">৪. তথ্য নিরাপত্তা</a>
                            <a href="#section-5" class="list-group-item list-group-item-action">৫. Cookies Policy</a>
                            <a href="#section-6" class="list-group-item list-group-item-action">৬. আপনার অধিকার</a>
                            <a href="#section-7" class="list-group-item list-group-item-action">৭. তথ্য সংরক্ষণ</a>
                            <a href="#section-8" class="list-group-item list-group-item-action">৮. শিশুদের তথ্য</a>
                            <a href="#section-9" class="list-group-item list-group-item-action">৯. Third-Party Services</a>
                            <a href="#section-10" class="list-group-item list-group-item-action">১০. Policy পরিবর্তন</a>
                            <a href="#section-11" class="list-group-item list-group-item-action">১১. Disclaimer</a>
                            <a href="#section-12" class="list-group-item list-group-item-action">১২. Fraud Notice</a>
                            <a href="#section-13" class="list-group-item list-group-item-action">১৩. Contact Us</a>
                            <a href="#commitment" class="list-group-item list-group-item-action">আমাদের প্রতিশ্রুতি</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div id="intro" class="card policy-section p-4 mb-4">
                        <p class="mb-0 text-secondary lh-lg">
                            Loan Linker ("আমরা", "আমাদের" বা "Loan Linker") আপনার ব্যক্তিগত তথ্যের গোপনীয়তা ও নিরাপত্তাকে
                            সর্বোচ্চ গুরুত্ব দেয়। এই Privacy Policy-তে ব্যাখ্যা করা হয়েছে আমরা কী ধরনের তথ্য সংগ্রহ করি,
                            কীভাবে ব্যবহার করি, কীভাবে সংরক্ষণ করি এবং আপনার কী কী অধিকার রয়েছে। আমাদের ওয়েবসাইট,
                            মোবাইল অ্যাপ বা যেকোনো সেবা ব্যবহার করার মাধ্যমে আপনি এই Privacy Policy-তে সম্মতি প্রদান করছেন।
                        </p>
                    </div>

                    <div id="section-1" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১</span>
                            <h3>আমরা কী ধরনের তথ্য সংগ্রহ করি</h3>
                        </div>

                        <p class="text-secondary mb-3">আমরা নিম্নোক্ত তথ্য সংগ্রহ করতে পারি:</p>

                        <h6 class="fw-bold">ব্যক্তিগত তথ্য</h6>
                        <ul class="mb-3">
                            <li>নাম</li>
                            <li>মোবাইল নম্বর</li>
                            <li>ই-মেইল ঠিকানা</li>
                            <li>জন্মতারিখ (যদি প্রয়োজন হয়)</li>
                            <li>জাতীয় পরিচয়পত্র (NID) নম্বর (যদি প্রয়োজন হয়)</li>
                            <li>বর্তমান ও স্থায়ী ঠিকানা</li>
                        </ul>

                        <h6 class="fw-bold">আর্থিক তথ্য</h6>
                        <ul class="mb-3">
                            <li>পেশা</li>
                            <li>মাসিক আয়</li>
                            <li>প্রতিষ্ঠানের নাম</li>
                            <li>প্রয়োজনীয় ব্যাংকিং তথ্য (যদি আবেদন প্রক্রিয়ার জন্য প্রয়োজন হয়)</li>
                        </ul>

                        <h6 class="fw-bold">আবেদন সংক্রান্ত তথ্য</h6>
                        <ul class="mb-3">
                            <li>Loan বা Credit Card-এর ধরন</li>
                            <li>প্রয়োজনীয় ঋণের পরিমাণ</li>
                            <li>আবেদন সংক্রান্ত ডকুমেন্ট</li>
                        </ul>

                        <h6 class="fw-bold">প্রযুক্তিগত তথ্য</h6>
                        <ul>
                            <li>IP Address</li>
                            <li>Device Information</li>
                            <li>Browser Type</li>
                            <li>Operating System</li>
                            <li>Login Information</li>
                            <li>Cookies</li>
                        </ul>
                    </div>

                    <div id="section-2" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">২</span>
                            <h3>আমরা কেন এই তথ্য সংগ্রহ করি</h3>
                        </div>
                        <p class="text-secondary mb-2">আপনার তথ্য ব্যবহার করা হয়-</p>
                        <ul>
                            <li>Loan বা Credit Card আবেদন প্রক্রিয়ায় সহায়তা করার জন্য</li>
                            <li>আপনার তথ্য Verified Bank Officer-এর সঙ্গে শেয়ার করার জন্য (আপনার সম্মতিতে)</li>
                            <li>আবেদন ট্র্যাক করার জন্য</li>
                            <li>Customer Support প্রদান করার জন্য</li>
                            <li>Fraud প্রতিরোধের জন্য</li>
                            <li>Platform উন্নত করার জন্য</li>
                            <li>আইনগত বাধ্যবাধকতা পালন করার জন্য</li>
                        </ul>
                    </div>

                    <div id="section-3" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৩</span>
                            <h3>তথ্য কার সাথে শেয়ার করা হতে পারে</h3>
                        </div>
                        <p class="text-secondary mb-2">আপনার সম্মতি অনুযায়ী তথ্য শেয়ার করা হতে পারে-</p>
                        <ul>
                            <li>Verified Bank Officer</li>
                            <li>Partner Bank</li>
                            <li>Partner Financial Institution (NBFI)</li>
                            <li>প্রযুক্তিগত সেবা প্রদানকারী (Hosting, SMS, Email ইত্যাদি)</li>
                            <li>আইন প্রয়োগকারী সংস্থা (প্রয়োজনে আইন অনুযায়ী)</li>
                        </ul>
                        <p class="fw-semibold text-dark mt-3 mb-0">আমরা কখনোই আপনার ব্যক্তিগত তথ্য বিক্রি করি না।</p>
                    </div>

                    <div id="section-4" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৪</span>
                            <h3>তথ্যের নিরাপত্তা</h3>
                        </div>
                        <p class="text-secondary mb-2">
                            Loan Linker আপনার তথ্য সুরক্ষার জন্য যুক্তিসঙ্গত প্রযুক্তিগত ও প্রশাসনিক ব্যবস্থা গ্রহণ করে,
                            যেমন-
                        </p>
                        <ul>
                            <li>SSL Encryption</li>
                            <li>Secure Server</li>
                            <li>Password Protection</li>
                            <li>Role-Based Access Control</li>
                            <li>Data Backup</li>
                            <li>System Monitoring</li>
                        </ul>
                        <p class="text-secondary mt-3 mb-0">
                            তবে ইন্টারনেটের মাধ্যমে তথ্য আদান-প্রদান ১০০% নিরাপদ নিশ্চিত করা সম্ভব নয়।
                        </p>
                    </div>

                    <div id="section-5" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৫</span>
                            <h3>Cookies Policy</h3>
                        </div>
                        <p class="text-secondary mb-2">আমাদের ওয়েবসাইট Cookies ব্যবহার করতে পারে যাতে-</p>
                        <ul>
                            <li>আপনার ব্যবহার অভিজ্ঞতা উন্নত হয়</li>
                            <li>Login সহজ হয়</li>
                            <li>Website Performance বিশ্লেষণ করা যায়</li>
                        </ul>
                        <p class="text-secondary mt-3 mb-0">আপনি চাইলে Browser Settings থেকে Cookies বন্ধ করতে পারবেন।</p>
                    </div>

                    <div id="section-6" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৬</span>
                            <h3>আপনার অধিকার</h3>
                        </div>
                        <p class="text-secondary mb-2">আপনি যেকোনো সময়-</p>
                        <ul>
                            <li>নিজের তথ্য দেখতে পারবেন</li>
                            <li>ভুল তথ্য সংশোধনের অনুরোধ করতে পারবেন</li>
                            <li>তথ্য হালনাগাদ করতে পারবেন</li>
                            <li>নির্দিষ্ট ক্ষেত্রে তথ্য মুছে ফেলার অনুরোধ করতে পারবেন</li>
                            <li>Marketing Communication বন্ধ করার অনুরোধ করতে পারবেন</li>
                        </ul>
                    </div>

                    <div id="section-7" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৭</span>
                            <h3>তথ্য সংরক্ষণ</h3>
                        </div>
                        <p class="text-secondary mb-0">
                            আপনার তথ্য শুধুমাত্র প্রয়োজনীয় সময় পর্যন্ত সংরক্ষণ করা হবে অথবা আইন অনুযায়ী যতদিন সংরক্ষণ
                            করা বাধ্যতামূলক।
                        </p>
                    </div>

                    <div id="section-8" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৮</span>
                            <h3>শিশুদের তথ্য</h3>
                        </div>
                        <p class="text-secondary mb-0">
                            ১৮ বছরের কম বয়সী ব্যক্তিদের জন্য আমাদের সেবা নয়। আমরা ইচ্ছাকৃতভাবে অপ্রাপ্তবয়স্কদের ব্যক্তিগত
                            তথ্য সংগ্রহ করি না।
                        </p>
                    </div>

                    <div id="section-9" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">৯</span>
                            <h3>Third-Party Services</h3>
                        </div>
                        <p class="text-secondary mb-0">
                            আমাদের ওয়েবসাইটে তৃতীয় পক্ষের ওয়েবসাইট বা সেবার লিংক থাকতে পারে। এসব ওয়েবসাইটের Privacy
                            Policy-এর জন্য Loan Linker দায়ী নয়।
                        </p>
                    </div>

                    <div id="section-10" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১০</span>
                            <h3>Policy পরিবর্তন</h3>
                        </div>
                        <p class="text-secondary mb-0">
                            ব্যবসায়িক বা আইনগত প্রয়োজন অনুযায়ী Loan Linker যেকোনো সময় এই Privacy Policy পরিবর্তন করতে
                            পারে। পরিবর্তনের পর নতুন সংস্করণ ওয়েবসাইটে প্রকাশ করা হবে।
                        </p>
                    </div>

                    <div id="section-11" class="card policy-note p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-circle-fill text-warning"></i>
                            <h5 class="fw-bold mb-0">১১. গুরুত্বপূর্ণ ঘোষণা (Disclaimer)</h5>
                        </div>
                        <ul>
                            <li>Loan Linker কোনো ব্যাংক বা Non-Bank Financial Institution (NBFI) নয়।</li>
                            <li>আমরা কোনো Loan বা Credit Card অনুমোদন করি না।</li>
                            <li>আমরা শুধুমাত্র গ্রাহক এবং Verified Bank Officer-এর মধ্যে সংযোগ স্থাপন করি।</li>
                            <li>
                                Loan বা Credit Card অনুমোদনের চূড়ান্ত সিদ্ধান্ত সংশ্লিষ্ট ব্যাংক বা Financial Institution-এর
                                নিজস্ব নীতিমালা, যাচাই ও যোগ্যতার ভিত্তিতে নেওয়া হয়।
                            </li>
                        </ul>
                    </div>

                    <div id="section-12" class="card policy-note alert p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-shield-exclamation text-danger"></i>
                            <h5 class="fw-bold mb-0">১২. Fraud Protection Notice</h5>
                        </div>
                        <p class="mb-2">Loan Linker অথবা কোনো Verified Bank Officer কখনোই আপনার-</p>
                        <ul>
                            <li>OTP</li>
                            <li>ATM PIN</li>
                            <li>Debit/Credit Card PIN</li>
                            <li>Internet Banking Password</li>
                            <li>Mobile Banking PIN</li>
                            <li>CVV</li>
                        </ul>
                        <p class="mb-0 fw-semibold">চাইবে না। কেউ এসব তথ্য চাইলে তাৎক্ষণিকভাবে আমাদের জানান।</p>
                    </div>

                    <div id="section-13" class="card policy-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="section-number">১৩</span>
                            <h3>Contact Us</h3>
                        </div>
                        <p class="text-secondary mb-3">
                            যদি এই Privacy Policy সম্পর্কে আপনার কোনো প্রশ্ন, মতামত বা অভিযোগ থাকে, তাহলে যোগাযোগ করুন-
                        </p>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>Loan Linker</strong></li>
                            <li class="mb-2">Website: <a href="https://www.loanlinker.xyz"
                                    target="_blank">www.loanlinker.xyz</a></li>
                            <li class="mb-2">Email: <a href="mailto:care@loanlinker.xyz">care@loanlinker.xyz</a></li>
                            <li class="mb-0">Hotline: <a href="tel:+8809697322750">+880 9697-322750</a></li>
                        </ul>
                    </div>

                    <div id="commitment" class="card policy-note p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-stars text-success"></i>
                            <h5 class="fw-bold mb-0">আমাদের প্রতিশ্রুতি</h5>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker প্রতিশ্রুতিবদ্ধ-</p>
                        <ul class="trust-points mb-0">
                            <li>আপনার ব্যক্তিগত তথ্যের গোপনীয়তা রক্ষা করতে।</li>
                            <li>নিরাপদ ও স্বচ্ছ ডিজিটাল সেবা নিশ্চিত করতে।</li>
                            <li>বাংলাদেশের প্রচলিত আইন, নৈতিক ব্যবসায়িক মান এবং তথ্য সুরক্ষার সর্বোচ্চ চর্চা অনুসরণ করতে।
                            </li>
                            <li>
                                গ্রাহক, ব্যাংক কর্মকর্তা এবং অংশীদার প্রতিষ্ঠানের মধ্যে একটি বিশ্বাসযোগ্য (Trusted), নিরাপদ
                                (Secure) এবং স্বচ্ছ (Transparent) আর্থিক সংযোগ গড়ে তুলতে।
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
