@extends('layouts.landing')

@section('title', 'Bank Officer Code of Conduct - ' . ($logoSettings->site_name ?? ''))

@push('styles')
    <style>
        .bocc-hero {
            background: linear-gradient(140deg, #1d4ed8 0%, #0f766e 52%, #14532d 100%);
            color: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(15, 118, 110, 0.22);
        }

        .bocc-badge {
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

        .bocc-subtitle {
            color: rgba(255, 255, 255, 0.92);
        }

        .bocc-nav,
        .bocc-section,
        .bocc-note,
        .bocc-prohibited,
        .bocc-help {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(9, 30, 66, 0.08);
        }

        .bocc-nav .list-group-item {
            border: 0;
            border-bottom: 1px solid #eef2f7;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: #1f2937;
        }

        .bocc-nav .list-group-item:last-child {
            border-bottom: 0;
        }

        .bocc-section {
            scroll-margin-top: 100px;
        }

        .bocc-number {
            width: 2rem;
            height: 2rem;
            flex: 0 0 2rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            background: #e0e7ff;
            color: #1d4ed8;
        }

        .bocc-section h3 {
            font-size: 1.15rem;
            margin-bottom: 0;
            color: #0f172a;
        }

        .bocc-section ul {
            padding-left: 1.1rem;
            margin-bottom: 0;
        }

        .bocc-section li {
            margin-bottom: 0.45rem;
            color: #334155;
        }

        .bocc-section li:last-child {
            margin-bottom: 0;
        }

        .bocc-note {
            border-left: 4px solid #0ea5e9;
            background: #f0f9ff;
        }

        .bocc-prohibited {
            border-left: 4px solid #dc2626;
            background: #fef2f2;
        }

        .bocc-help {
            border-left: 4px solid #0284c7;
            background: #f0f9ff;
        }

        .declaration-points li,
        .commitment-points li {
            list-style: none;
            position: relative;
            padding-left: 1.6rem;
            margin-bottom: 0.55rem;
        }

        .declaration-points li::before,
        .commitment-points li::before {
            content: "\2713";
            position: absolute;
            left: 0;
            top: 0.05rem;
            color: #15803d;
            font-weight: 700;
        }

        @media (max-width: 991.98px) {
            .bocc-nav {
                position: static !important;
            }
        }
    </style>
@endpush

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="bocc-hero p-4 p-md-5 mb-4 mb-md-5">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="bocc-badge"><i class="bi bi-shield-check"></i> Bank Officer Code of Conduct</span>
                    <span class="bocc-badge"><i class="bi bi-building"></i> Loan Linker</span>
                </div>
                <h1 class="display-5 fw-bold mb-2">Bank Officer Code of Conduct</h1>
                <p class="mb-2 fs-5 fw-semibold">Smart Connection Between Customer &amp; Bank</p>
                <p class="mb-0 bocc-subtitle">ভূমিকা: Loan Linker-এর লক্ষ্য হলো গ্রাহক এবং Verified Bank Officer-এর মধ্যে
                    একটি নিরাপদ, স্বচ্ছ ও পেশাদার সংযোগ তৈরি করা। Loan Linker-এ নিবন্ধিত প্রত্যেক ব্যাংক অফিসার নিম্নোক্ত
                    আচরণবিধি মেনে চলতে সম্মত থাকবেন।</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card bocc-nav p-3 sticky-lg-top" style="top: 90px;">
                        <h5 class="fw-bold mb-3">Quick Navigation</h5>
                        <div class="list-group list-group-flush">
                            <a href="#section-1" class="list-group-item list-group-item-action">১. Professional Conduct</a>
                            <a href="#section-2" class="list-group-item list-group-item-action">২. Identity Verification</a>
                            <a href="#section-3" class="list-group-item list-group-item-action">৩. অবৈধ অর্থ গ্রহণ
                                নিষিদ্ধ</a>
                            <a href="#section-4" class="list-group-item list-group-item-action">৪. মিথ্যা প্রতিশ্রুতি নয়</a>
                            <a href="#section-5" class="list-group-item list-group-item-action">৫. তথ্যের গোপনীয়তা</a>
                            <a href="#section-6" class="list-group-item list-group-item-action">৬. অফিসিয়াল যোগাযোগ</a>
                            <a href="#section-7" class="list-group-item list-group-item-action">৭. OTP/PIN/Password</a>
                            <a href="#section-8" class="list-group-item list-group-item-action">৮. সঠিক তথ্য</a>
                            <a href="#section-9" class="list-group-item list-group-item-action">৯. গ্রাহকের সিদ্ধান্ত</a>
                            <a href="#section-10" class="list-group-item list-group-item-action">১০. দ্রুত সাড়া</a>
                            <a href="#section-11" class="list-group-item list-group-item-action">১১. ভুয়া আবেদন রিপোর্ট</a>
                            <a href="#section-12" class="list-group-item list-group-item-action">১২. স্বার্থের সংঘাত</a>
                            <a href="#section-13" class="list-group-item list-group-item-action">১৩. আইন ও নীতিমালা</a>
                            <a href="#section-14" class="list-group-item list-group-item-action">১৪. অভিযোগ তদন্ত</a>
                            <a href="#section-15" class="list-group-item list-group-item-action">১৫. সুনাম রক্ষা</a>
                            <a href="#prohibited" class="list-group-item list-group-item-action">Strictly Prohibited</a>
                            <a href="#disciplinary" class="list-group-item list-group-item-action">Disciplinary Actions</a>
                            <a href="#declaration" class="list-group-item list-group-item-action">Officer Declaration</a>
                            <a href="#help" class="list-group-item list-group-item-action">Need Help?</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div id="section-1" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">১</span>
                            <h3>পেশাদার আচরণ (Professional Conduct)</h3>
                        </div>
                        <ul>
                            <li>প্রত্যেক গ্রাহকের সঙ্গে ভদ্র, সম্মানজনক ও পেশাদার আচরণ করতে হবে।</li>
                            <li>কোনো ধরনের হয়রানি, অশালীন ভাষা বা বৈষম্যমূলক আচরণ করা যাবে না।</li>
                            <li>সবসময় ব্যাংকের নীতিমালা ও পেশাগত নৈতিকতা অনুসরণ করতে হবে।</li>
                        </ul>
                    </div>

                    <div id="section-2" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">২</span>
                            <h3>পরিচয় যাচাই (Identity Verification)</h3>
                        </div>
                        <p class="text-secondary mb-2">
                            Loan Linker-এ যুক্ত হওয়ার আগে ব্যাংক অফিসারকে অবশ্যই পরিচয় যাচাই সম্পন্ন করতে হবে। যেমন:
                        </p>
                        <ul class="mb-2">
                            <li>Employee ID</li>
                            <li>Official Designation</li>
                            <li>Official Email (যদি থাকে)</li>
                            <li>ব্যাংকের পরিচয়পত্র বা অন্যান্য প্রয়োজনীয় প্রমাণ</li>
                        </ul>
                        <p class="text-secondary mb-0">ভুল তথ্য প্রদান করলে অ্যাকাউন্ট স্থায়ীভাবে বাতিল হতে পারে।</p>
                    </div>

                    <div id="section-3" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">৩</span>
                            <h3>কোনো ধরনের অবৈধ অর্থ গ্রহণ নিষিদ্ধ</h3>
                        </div>
                        <p class="text-secondary mb-2">ব্যাংকের নির্ধারিত ফি ছাড়া গ্রাহকের কাছ থেকে:</p>
                        <ul class="mb-2">
                            <li>ঘুষ</li>
                            <li>কমিশন</li>
                            <li>ব্যক্তিগত সার্ভিস চার্জ</li>
                            <li>প্রসেসিং ফি</li>
                            <li>দ্রুত অনুমোদনের নামে অর্থ</li>
                        </ul>
                        <p class="text-secondary mb-0">গ্রহণ করা সম্পূর্ণ নিষিদ্ধ।</p>
                    </div>

                    <div id="section-4" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">৪</span>
                            <h3>মিথ্যা প্রতিশ্রুতি দেওয়া যাবে না</h3>
                        </div>
                        <p class="text-secondary mb-2">নিম্নোক্ত ধরনের প্রতিশ্রুতি দেওয়া যাবে না:</p>
                        <ul class="mb-2">
                            <li>১০০% Loan Approval</li>
                            <li>Guaranteed Credit Card</li>
                            <li>নিশ্চিত Loan</li>
                            <li>দ্রুত Approval-এর নিশ্চয়তা</li>
                        </ul>
                        <p class="text-secondary mb-0">Loan Approval সম্পূর্ণভাবে সংশ্লিষ্ট ব্যাংকের নিয়ম ও যোগ্যতার
                            ভিত্তিতে হবে।</p>
                    </div>

                    <div id="section-5" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">৫</span>
                            <h3>গ্রাহকের তথ্যের গোপনীয়তা</h3>
                        </div>
                        <p class="text-secondary mb-2">গ্রাহকের তথ্য শুধুমাত্র অফিসিয়াল ব্যাংকিং কাজের জন্য ব্যবহার করা
                            যাবে। কোনো অবস্থাতেই</p>
                        <ul class="mb-2">
                            <li>বিক্রি করা</li>
                            <li>অন্যকে দেওয়া</li>
                            <li>ব্যক্তিগত কাজে ব্যবহার করা</li>
                        </ul>
                        <p class="text-secondary mb-0">যাবে না।</p>
                    </div>

                    <div id="section-6" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">৬</span>
                            <h3>অফিসিয়াল যোগাযোগ বজায় রাখা</h3>
                        </div>
                        <p class="text-secondary mb-2">সম্ভব হলে যোগাযোগ করতে হবে</p>
                        <ul class="mb-2">
                            <li>ব্যাংক শাখায়</li>
                            <li>অফিসিয়াল ফোনে</li>
                            <li>অফিসিয়াল ইমেইলে</li>
                        </ul>
                        <p class="text-secondary mb-0">ব্যক্তিগত বা অনিরাপদ মাধ্যমে সংবেদনশীল তথ্য আদান-প্রদান নিরুৎসাহিত
                            করা হয়।</p>
                    </div>

                    <div id="section-7" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">৭</span>
                            <h3>OTP ও Password কখনো চাইবেন না</h3>
                        </div>
                        <p class="text-secondary mb-2">কোনো পরিস্থিতিতেই গ্রাহকের</p>
                        <ul class="mb-2">
                            <li>OTP</li>
                            <li>ATM PIN</li>
                            <li>Password</li>
                            <li>CVV</li>
                            <li>Internet Banking Password</li>
                        </ul>
                        <p class="text-secondary mb-0">চাওয়া যাবে না।</p>
                    </div>

                    <div id="section-8" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">৮</span>
                            <h3>সঠিক তথ্য প্রদান</h3>
                        </div>
                        <p class="text-secondary mb-0">Loan, Credit Card, Interest Rate, Charges, Eligibility এবং প্রয়োজনীয়
                            ডকুমেন্ট সম্পর্কে সঠিক তথ্য প্রদান করতে হবে।</p>
                    </div>

                    <div id="section-9" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">৯</span>
                            <h3>গ্রাহকের সিদ্ধান্তকে সম্মান করা</h3>
                        </div>
                        <p class="text-secondary mb-0">গ্রাহক অন্য ব্যাংকের সেবা গ্রহণ করলে কোনো ধরনের চাপ, হুমকি বা
                            অসৌজন্যমূলক আচরণ করা যাবে না।</p>
                    </div>

                    <div id="section-10" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">১০</span>
                            <h3>দ্রুত সাড়া প্রদান</h3>
                        </div>
                        <p class="text-secondary mb-0">গ্রাহকের আবেদন পাওয়ার পর যুক্তিসঙ্গত সময়ের মধ্যে যোগাযোগ করার চেষ্টা
                            করতে হবে এবং আবেদন সম্পর্কে নিয়মিত আপডেট দিতে হবে।</p>
                    </div>

                    <div id="section-11" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">১১</span>
                            <h3>ভুয়া আবেদন রিপোর্ট করা</h3>
                        </div>
                        <p class="text-secondary mb-0">যদি কোনো আবেদন সন্দেহজনক বা জাল মনে হয়, তাহলে Loan Linker-কে অবহিত
                            করতে হবে এবং ব্যাংকের অভ্যন্তরীণ নীতিমালা অনুসরণ করতে হবে।</p>
                    </div>

                    <div id="section-12" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">১২</span>
                            <h3>স্বার্থের সংঘাত এড়ানো</h3>
                        </div>
                        <p class="text-secondary mb-0">ব্যক্তিগত লাভের উদ্দেশ্যে গ্রাহককে বিভ্রান্ত করা, নির্দিষ্ট পণ্য
                            চাপিয়ে দেওয়া বা ভুল তথ্য দেওয়া যাবে না।</p>
                    </div>

                    <div id="section-13" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">১৩</span>
                            <h3>আইন ও ব্যাংকের নীতিমালা অনুসরণ</h3>
                        </div>
                        <p class="text-secondary mb-2">প্রত্যেক অফিসারকে:</p>
                        <ul class="mb-2">
                            <li>বাংলাদেশ ব্যাংকের নির্দেশনা</li>
                            <li>নিজ নিজ ব্যাংকের নীতিমালা</li>
                            <li>প্রযোজ্য আইন</li>
                        </ul>
                        <p class="text-secondary mb-0">অনুসরণ করতে হবে।</p>
                    </div>

                    <div id="section-14" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">১৪</span>
                            <h3>অভিযোগ তদন্তে সহযোগিতা</h3>
                        </div>
                        <p class="text-secondary mb-0">গ্রাহকের বিরুদ্ধে বা অফিসারের বিরুদ্ধে অভিযোগ এলে প্রয়োজনীয় তথ্য
                            দিয়ে Loan Linker-এর তদন্তে সহযোগিতা করতে হবে।</p>
                    </div>

                    <div id="section-15" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="bocc-number">১৫</span>
                            <h3>প্ল্যাটফর্মের সুনাম রক্ষা</h3>
                        </div>
                        <p class="text-secondary mb-0">Loan Linker-এর নাম ব্যবহার করে কোনো প্রতারণা, বিভ্রান্তিকর প্রচারণা
                            বা অনৈতিক কার্যক্রম করা যাবে না।</p>
                    </div>

                    <div id="prohibited" class="card bocc-prohibited p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-slash-circle-fill text-danger"></i>
                            <h4 class="fw-bold mb-0">নিষিদ্ধ কার্যক্রম (Strictly Prohibited)</h4>
                        </div>
                        <ul>
                            <li>ব্যক্তিগত বিকাশ/নগদ/মোবাইল ব্যাংকিং অ্যাকাউন্টে টাকা গ্রহণের অনুরোধ।</li>
                            <li>অনুমোদনের নিশ্চয়তা দিয়ে অর্থ দাবি।</li>
                            <li>ভুয়া পরিচয় ব্যবহার।</li>
                            <li>অন্য অফিসারের পরিচয় ব্যবহার।</li>
                            <li>গ্রাহকের তথ্য তৃতীয় পক্ষের কাছে বিক্রি বা শেয়ার।</li>
                            <li>জাল কাগজপত্র তৈরি বা উৎসাহ দেওয়া।</li>
                            <li>Loan Linker-এর বাইরে গোপন কমিশনভিত্তিক চুক্তি করা।</li>
                            <li>প্ল্যাটফর্ম ব্যবহার করে প্রতারণামূলক কার্যক্রম পরিচালনা।</li>
                        </ul>
                    </div>

                    <div id="disciplinary" class="card bocc-note p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-journal-check text-info"></i>
                            <h4 class="fw-bold mb-0">শাস্তিমূলক ব্যবস্থা (Disciplinary Actions)</h4>
                        </div>
                        <p class="text-secondary mb-2">নিয়ম ভঙ্গ করলে Loan Linker প্রয়োজন অনুযায়ী-</p>
                        <ul>
                            <li>মৌখিক বা লিখিত সতর্কবার্তা প্রদান।</li>
                            <li>সাময়িকভাবে অ্যাকাউন্ট স্থগিত করা।</li>
                            <li>স্থায়ীভাবে প্ল্যাটফর্ম থেকে অপসারণ।</li>
                            <li>সংশ্লিষ্ট ব্যাংক কর্তৃপক্ষকে অবহিত করা (প্রয়োজন হলে)।</li>
                            <li>আইনগত ব্যবস্থা গ্রহণ।</li>
                        </ul>
                    </div>

                    <div id="declaration" class="card bocc-section p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-file-earmark-text text-success"></i>
                            <h4 class="fw-bold mb-0">Officer Declaration</h4>
                        </div>
                        <p class="text-secondary mb-2">Loan Linker-এ নিবন্ধনের মাধ্যমে আমি ঘোষণা করছি যে-</p>
                        <ul class="declaration-points mb-0">
                            <li>আমি উপরের সকল আচরণবিধি মেনে চলব।</li>
                            <li>গ্রাহকের সর্বোচ্চ স্বার্থকে গুরুত্ব দেব।</li>
                            <li>কোনো ধরনের প্রতারণা, অবৈধ অর্থ লেনদেন বা অনৈতিক কার্যক্রমে জড়িত হব না।</li>
                            <li>Loan Linker এবং আমার প্রতিষ্ঠানের সুনাম বজায় রাখতে সর্বোচ্চ পেশাদারিত্বের সঙ্গে দায়িত্ব পালন
                                করব।</li>
                        </ul>
                    </div>

                    <div id="help" class="card bocc-help bocc-section p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-headset text-info"></i>
                            <h4 class="fw-bold mb-0">Need Help?</h4>
                        </div>
                        <p class="text-secondary mb-3">যদি আপনার কোনো প্রশ্ন, অভিযোগ বা পরামর্শ থাকে, আমাদের সঙ্গে যোগাযোগ
                            করুন।</p>
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
