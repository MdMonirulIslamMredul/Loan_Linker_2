@extends('layouts.branch-admin')

@section('title', 'Bank Officer Dashboard')
@section('dashboard-title', 'Bank Officer Dashboard')

@section('content')


<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        @php
        $user = auth()->user();
        $leadBalance = $user->lead_balance ?? 0;
        @endphp


        @if(auth()->user()->is_access)
        <div class="row g-2">
            <div class="col-md-3">
                <a href="{{ route('branch-admin.packages.history') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 rounded-4 hover-lift">
                        <div class="card-body text-center p-2">
                            <div class="mb-2">
                                <span class="badge bg-primary rounded-pill py-1 px-2 shadow-sm">
                                    <i class="bi bi-wallet2 fs-6"></i>
                                </span>
                            </div>
                            <div class="text-uppercase text-muted small mb-1">Lead Balance</div>
                            <div class="fs-4 fw-bold mb-1">{{ number_format($leadBalance) }}</div>
                            @if($user->package_expiry_date)
                            <div class="text-muted" style="font-size: 0.75rem;">
                                Expires After: {{ $user->package_expiry_date->format('d M, Y') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('branch-admin.new-applications.unlocked') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 rounded-4 bg-success bg-opacity-10 hover-lift">
                        <div class="card-body text-center p-2">
                            <div class="mb-2">
                                <span class="badge bg-success rounded-pill py-1 px-2 shadow-sm">
                                    <i class="bi bi-unlock-fill fs-6"></i>
                                </span>
                            </div>
                            <div class="text-uppercase text-success small mb-1">Available</div>
                            <div class="fs-4 fw-bold text-success">{{ $unlockedCount ?? 0 }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('branch-admin.new-applications.locked') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 rounded-4 bg-warning bg-opacity-10 hover-lift">
                        <div class="card-body text-center p-2">
                            <div class="mb-2">
                                <span class="badge bg-warning rounded-pill py-1 px-2 shadow-sm text-dark">
                                    <i class="bi bi-lock-fill fs-6"></i>
                                </span>
                            </div>
                            <div class="text-uppercase text-warning small mb-1">New (Locked)</div>
                            <div class="fs-4 fw-bold text-warning">{{ $lockedCount ?? 0 }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('branch-admin.new-applications.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 rounded-4 bg-info bg-opacity-10 hover-lift">
                        <div class="card-body text-center p-2">
                            <div class="mb-2">
                                <span class="badge bg-info rounded-pill py-1 px-2 shadow-sm">
                                    <i class="bi bi-file-earmark-text fs-6"></i>
                                </span>
                            </div>
                            <div class="text-uppercase text-info small mb-1">New Loan Requests (last 7 days)</div>
                            <div class="fs-4 fw-bold text-info">{{ $newRequestsCount }}</div>
                            <div class="small mt-1 text-muted">View new customer requests</div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>




<!-- Loan Applications Section -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Recent Loan Applications (last 7 days)</h4>
            <a href="{{ route('branch-admin.new-applications.index') }}" class="btn btn-sm btn-outline-primary">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if ($newApplications->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
            <p class="text-muted mt-3 mb-0">No new loan applications in last 7 days.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Tenure</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Location</th>
                        {{-- <th>Status</th> --}}
                        <th>Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newApplications as $application)
                    @php
                    $canView = false;
                    if ($user->isSuperAdmin() || $user->isBankAdmin()) {
                    $canView = true;
                    } else {
                    $canView = \App\Models\LeadAccess::where('officer_id', $user->id)
                    ->where('newloan_id', $application->id)
                    ->exists();
                    }
                    @endphp
                    <tr>
                        <td><strong>#{{ $application->id }}</strong></td>
                        <td>{{ optional($application->customer)->name ?? 'Guest' }}</td>
                        <td>{{ $canView ? (optional($application->customer)->email ?? 'N/A') : 'Locked' }}</td>
                        <td><strong>৳{{ number_format($application->expected_amount, 2) }}</strong></td>
                        <td>{{ $application->tenure_months }} months</td>
                        <td class="text-capitalize">{{ optional($application->serviceCategory)->name ?? 'N/A' }}</td>
                        <td class="text-capitalize">{{ optional($application->serviceType)->name ?? 'N/A' }}</td>
                        {{-- <td>
                                        @if ($application->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($application->status === 'review')
                                            <span class="badge bg-info">Review</span>
                                        @elseif($application->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($application->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($application->status ?? 'Unknown') }}</span>
                        @endif
                        </td> --}}
                        <td class="text-capitalize">
                            <strong>{{ optional($application->customer->contactDistrict)->name ?? 'N/A' }}</strong>
                            @if(optional($application->customer->contactUpazila)->name)
                            , {{ optional($application->customer->contactUpazila)->name }}
                            @endif
                            @if(optional($application->customer->contactThana)->name)
                            , {{ optional($application->customer->contactThana)->name }}
                            @endif
                        </td>
                        <td>{{ $application->created_at->format('d M, Y') }}</td>
                        <td>
                            @if ($canView)
                            <a href="{{ route('branch-admin.new-applications.show', $application) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i>View
                            </a>
                            @else
                            @if ((int) ($user->lead_balance ?? 0) > 0)
                            <form action="{{ route('branch-admin.new-applications.unlock', $application) }}" method="POST" class="d-inline unlock-form">
                                @csrf
                                <button type="button" class="btn btn-sm btn-outline-primary unlock-confirm-btn">
                                    <i class="bi bi-unlock me-1"></i>Unlock to View (1)
                                </button>
                            </form>
                            @else
                            <a href="{{ route('branch-admin.packages.gallery') }}" class="btn btn-sm btn-outline-secondary" title="Purchase leads to view">
                                <i class="bi bi-cart me-1"></i>Buy Leads
                            </a>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($newApplications->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-center">
                {{ $newApplications->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="card-title mb-0"><i class="bi bi-shield-check me-2"></i>Bank Officer Code of Conduct</h5>
        <p class="mb-0 small opacity-75">Loan Linker - Smart Connection Between Customer & Bank</p>
    </div>
    <div class="card-body p-4">
        <div class="mb-4">
            <h6 class="fw-bold text-primary mb-2">ভূমিকা:</h6>
            <p class="text-muted small">
                Loan Linker-এর লক্ষ্য হলো গ্রাহক এবং Verified Bank Officer-এর মধ্যে একটি নিরাপদ, স্বচ্ছ ও পেশাদার সংযোগ তৈরি করা।<br>
                Loan Linker-এ নিবন্ধিত প্রত্যেক ব্যাংক অফিসার নিম্নোক্ত আচরণবিধি মেনে চলতে সম্মত থাকবেন।
            </p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <h6 class="fw-bold text-dark"><i class="bi bi-1-circle-fill text-primary me-2"></i>১. পেশাদার আচরণ (Professional Conduct)</h6>
                <ul class="text-muted small">
                    <li>প্রত্যেক গ্রাহকের সঙ্গে ভদ্র, সম্মানজনক ও পেশাদার আচরণ করতে হবে।</li>
                    <li>কোনো ধরনের হয়রানি, অশালীন ভাষা বা বৈষম্যমূলক আচরণ করা যাবে সামাজিক ও ব্যক্তিগত ক্ষেত্রে।</li>
                    <li>সবসময় ব্যাংকের নীতিমালা ও পেশাগত নৈতিকতা অনুসরণ করতে হবে।</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="fw-bold text-dark"><i class="bi bi-2-circle-fill text-primary me-2"></i>২. পরিচয় যাচাই (Identity Verification)</h6>
                <p class="text-muted small mb-1">Loan Linker-এ যুক্ত হওয়ার আগে ব্যাংক অফিসারকে অবশ্যই পরিচয় যাচাই সম্পন্ন করতে হবে। যেমন:</p>
                <ul class="text-muted small mb-1">
                    <li>Employee ID, Official Designation</li>
                    <li>Official Email (যদি থাকে) ও ব্যাংকের পরিচয়পত্র বা অন্যান্য প্রয়োজনীয় প্রমাণ</li>
                </ul>
                <div class="text-danger small fw-medium"><i class="bi bi-exclamation-triangle-fill me-1"></i>ভুল তথ্য প্রদান করলে অ্যাকাউন্ট স্থায়ীভাবে বাতিল হতে পারে।</div>
            </div>

            <div class="col-md-6">
                <h6 class="fw-bold text-dark"><i class="bi bi-3-circle-fill text-primary me-2"></i>৩. কোনো ধরনের অবৈধ অর্থ গ্রহণ নিষিদ্ধ</h6>
                <p class="text-muted small mb-1">ব্যাংকের নির্ধারিত ফি ছাড়া গ্রাহকের কাছ থেকে:</p>
                <ul class="text-muted small mb-1">
                    <li>ঘুষ, কমিশন, ব্যক্তিগত সার্ভিস চার্জ</li>
                    <li>প্রসেসিং ফি বা দ্রুত অনুমোদনের নামে অর্থ</li>
                </ul>
                <div class="text-danger small fw-medium">গ্রহণ করা সম্পূর্ণ নিষিদ্ধ।</div>
            </div>

            <div class="col-md-6">
                <h6 class="fw-bold text-dark"><i class="bi bi-4-circle-fill text-primary me-2"></i>৪. মিথ্যা প্রতিশ্রুতি দেওয়া যাবে না</h6>
                <p class="text-muted small mb-1">নিম্নোক্ত ধরনের প্রতিশ্রুতি দেওয়া যাবে না:</p>
                <ul class="text-muted small mb-1">
                    <li>১০০% Loan Approval, Guaranteed Credit Card</li>
                    <li>নিশ্চিত Loan বা দ্রুত Approval-এর নিশ্চয়তা</li>
                </ul>
                <div class="text-info small fw-medium"><i class="bi bi-info-circle-fill me-1"></i>Loan Approval সম্পূর্ণভাবে সংশ্লিষ্ট ব্যাংকের নিয়ম ও যোগ্যতার ভিত্তিতে হবে।</div>
            </div>
        </div>

        <div class="accordion mb-4" id="codeOfConductAccordion">
            <div class="accordion-item border-0 shadow-sm">
                <h2 class="accordion-header" id="headingMoreRules">
                    <button class="accordion-button collapsed bg-light fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMoreRules" aria-expanded="false" aria-controls="collapseMoreRules">
                        আরও নিয়মাবলি দেখুন (৫ - ১৫)
                    </button>
                </h2>
                <div id="collapseMoreRules" class="accordion-collapse collapse" aria-labelledby="headingMoreRules" data-bs-parent="#codeOfConductAccordion">
                    <div class="accordion-body bg-white">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-5-circle text-primary me-2"></i>৫. গ্রাহকের তথ্যের গোপনীয়তা</h6>
                                <p class="text-muted small">গ্রাহকের তথ্য শুধুমাত্র অফিসিয়াল ব্যাংকিং কাজের জন্য ব্যবহার করা যাবে। কোনো অবস্থাতেই বিক্রি করা, অন্যকে দেওয়া বা ব্যক্তিগত কাজে ব্যবহার করা যাবে না।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-6-circle text-primary me-2"></i>৬. অফিসিয়াল যোগাযোগ বজায় রাখা</h6>
                                <p class="text-muted small">সম্ভব হলে ব্যাংক শাখায়, অফিসিয়াল ফোনে বা অফিসিয়াল ইমেইলে যোগাযোগ করতে হবে। ব্যক্তিগত বা অনিরাপদ মাধ্যমে সংবেদনশীল তথ্য আদান-প্রদান নিরুৎসাহিত করা হয়।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-danger"><i class="bi bi-7-circle text-danger me-2"></i>৭. OTP ও Password কখনো চাইবেন না</h6>
                                <p class="text-muted small">কোনো পরিস্থিতিতেই গ্রাহকের OTP, ATM PIN, Password, CVV বা Internet Banking Password চাওয়া যাবে না।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-8-circle text-primary me-2"></i>৮. সঠিক তথ্য প্রদান</h6>
                                <p class="text-muted small">Loan, Credit Card, Interest Rate, Charges, Eligibility এবং প্রয়োজনীয় ডকুমেন্ট সম্পর্কে সঠিক তথ্য প্রদান করতে হবে।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-9-circle text-primary me-2"></i>৯. গ্রাহকের সিদ্ধান্তকে সম্মান করা</h6>
                                <p class="text-muted small">গ্রাহক অন্য ব্যাংকের সেবা গ্রহণ করলে কোনো ধরনের চাপ, হুমকি বা অসৌজন্যমূলক আচরণ করা যাবে না।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-10-circle text-primary me-2"></i>১০. দ্রুত সাড়া প্রদান</h6>
                                <p class="text-muted small">গ্রাহকের আবেদন পাওয়ার পর যুক্তিসঙ্গত সময়ের মধ্যে যোগাযোগ করার চেষ্টা করতে হবে এবং আবেদন সম্পর্কে নিয়মিত আপডেট দিতে হবে।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-11-circle text-primary me-2"></i>১১. ভুয়া আবেদন রিপোর্ট করা</h6>
                                <p class="text-muted small">যদি কোনো আবেদন সন্দেহজনক বা জাল মনে হয়, তাহলে Loan Linker-কে অবহিত করতে হবে এবং ব্যাংকের অভ্যন্তরীণ নীতিমালা অনুসরণ করতে হবে।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-12-circle text-primary me-2"></i>১২. স্বার্থের সংঘাত এড়ানো</h6>
                                <p class="text-muted small">ব্যক্তিগত লাভের উদ্দেশ্যে গ্রাহককে বিভ্রান্ত করা, নির্দিষ্ট পণ্য চাপিয়ে দেওয়া বা ভুল তথ্য দেওয়া যাবে না।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-13-circle text-primary me-2"></i>১৩. আইন ও ব্যাংকের নীতিমালা অনুসরণ</h6>
                                <p class="text-muted small">প্রত্যেক অফিসারকে বাংলাদেশ ব্যাংকের নির্দেশনা, নিজ নিজ ব্যাংকের নীতিমালা এবং প্রযোজ্য আইন অনুসরণ করতে হবে।</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark"><i class="bi bi-14-circle text-primary me-2"></i>১৪. অভিযোগ তদন্তে সহযোগিতা</h6>
                                <p class="text-muted small">গ্রাহকের বিরুদ্ধে বা অফিসারের বিরুদ্ধে অভিযোগ এলে প্রয়োজনীয় তথ্য দিয়ে Loan Linker-এর তদন্তে সহযোগিতা করতে হবে।</p>
                            </div>
                            <div class="col-md-12">
                                <h6 class="fw-bold text-dark"><i class="bi bi-15-circle text-primary me-2"></i>১৫. প্ল্যাটফর্মের সুনাম রক্ষা</h6>
                                <p class="text-muted small mb-0">Loan Linker-এর নাম ব্যবহার করে কোনো প্রতারণা, বিভ্রান্তিকর প্রচারণা বা অনৈতিক কার্যক্রম করা যাবে না।</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card border-danger bg-danger bg-opacity-10 h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold text-danger mb-3"><i class="bi bi-x-octagon-fill me-2"></i>নিষিদ্ধ কার্যক্রম (Strictly Prohibited)</h6>
                        <ul class="text-danger small mb-0">
                            <li class="mb-1">ব্যক্তিগত বিকাশ/নগদ/মোবাইল ব্যাংকিং অ্যাকাউন্টে টাকা গ্রহণের অনুরোধ।</li>
                            <li class="mb-1">অনুমোদনের নিশ্চয়তা দিয়ে অর্থ দাবি।</li>
                            <li class="mb-1">ভুয়া পরিচয় বা অন্য অফিসারের পরিচয় ব্যবহার।</li>
                            <li class="mb-1">গ্রাহকের তথ্য তৃতীয় পক্ষের কাছে বিক্রি বা শেয়ার।</li>
                            <li class="mb-1">জাল কাগজপত্র তৈরি বা উৎসাহ দেওয়া।</li>
                            <li class="mb-1">Loan Linker-এর বাইরে গোপন কমিশনভিত্তিক চুক্তি করা।</li>
                            <li>প্ল্যাটফর্ম ব্যবহার করে প্রতারণামূলক কার্যক্রম পরিচালনা।</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-warning bg-warning bg-opacity-10 h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold text-warning-emphasis mb-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>শাস্তিমূলক ব্যবস্থা (Disciplinary Actions)</h6>
                        <p class="text-warning-emphasis small fw-medium mb-2">নিয়ম ভঙ্গ করলে Loan Linker প্রয়োজন অনুযায়ী—</p>
                        <ul class="text-warning-emphasis small mb-0">
                            <li class="mb-1">মৌখিক বা লিখিত সতর্কবার্তা প্রদান।</li>
                            <li class="mb-1">সাময়িকভাবে অ্যাকাউন্ট স্থগিত করা।</li>
                            <li class="mb-1">স্থায়ীভাবে প্ল্যাটফর্ম থেকে অপসারণ।</li>
                            <li class="mb-1">সংশ্লিষ্ট ব্যাংক কর্তৃপক্ষকে অবহিত করা (প্রয়োজন হলে)।</li>
                            <li>আইনগত ব্যবস্থা গ্রহণ।</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-success bg-success bg-opacity-10 mb-4 shadow-sm">
            <div class="card-body text-center p-4">
                <h6 class="fw-bold text-success fs-5"><i class="bi bi-check-circle-fill me-2"></i>Officer Declaration</h6>
                <p class="text-success small fw-medium mb-3">Loan Linker-এ নিবন্ধনের মাধ্যমে আমি ঘোষণা করছি যে—</p>
                <ul class="text-success small text-start d-inline-block mb-0" style="max-width: 600px;">
                    <li class="mb-1">আমি উপরের সকল আচরণবিধি মেনে চলব।</li>
                    <li class="mb-1">গ্রাহকের সর্বোচ্চ স্বার্থকে গুরুত্ব দেব।</li>
                    <li class="mb-1">কোনো ধরনের প্রতারণা, অবৈধ অর্থ লেনদেন বা অনৈতিক কার্যক্রমে জড়িত হব না।</li>
                    <li>Loan Linker এবং আমার প্রতিষ্ঠানের সুনাম বজায় রাখতে সর্বোচ্চ পেশাদারিত্বের সঙ্গে দায়িত্ব পালন করব।</li>
                </ul>
            </div>
        </div>

        <div class="alert alert-info d-flex align-items-center mb-0 shadow-sm border-0 bg-info bg-opacity-10" role="alert">
            <i class="bi bi-headset fs-1 text-info me-4 d-none d-md-block"></i>
            <div>
                <h6 class="alert-heading fw-bold text-info-emphasis fs-5 mb-2">Need Help?</h6>
                <div class="small text-info-emphasis">
                    যদি আপনার কোনো প্রশ্ন, অভিযোগ বা পরামর্শ থাকে, আমাদের সঙ্গে যোগাযোগ করুন।<br>
                    <div class="mt-2 d-flex flex-wrap gap-3">
                        <span><i class="bi bi-envelope-fill me-1"></i> <strong>Email:</strong> <a href="mailto:care@loanlinker.xyz" class="text-decoration-none">care@loanlinker.xyz</a></span>
                        <span><i class="bi bi-telephone-fill me-1"></i> <strong>Hotline:</strong> +880 9697-322750</span>
                        <span><i class="bi bi-globe me-1"></i> <strong>Website:</strong> <a href="https://www.loanlinker.xyz" target="_blank" class="text-decoration-none">www.loanlinker.xyz</a></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@elseif(auth()->user()->is_access === null)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="alert alert-warning mb-0">
            <h5 class="alert-heading">Approval Pending , Please update your profile with Bank Official Information and upload your genuine Officer Documents </h5>
            <p>Your account is awaiting approval from the admin. Please wait while your access request is reviewed.</p>
            <p class="mb-0">If you have already submitted your documents, no further action is required.</p>
        </div>
    </div>
</div>
@else
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="alert alert-danger mb-0">
            <h5 class="alert-heading">Access Denied</h5>
            <p>Your access request has been rejected.</p>
            @if(auth()->user()->access_mes)
            <p class="mb-0"><strong>Reason:</strong> {{ auth()->user()->access_mes }}</p>
            @else
            <p class="mb-0">No rejection note was provided. Contact admin for more details.</p>
            @endif
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="unlockConfirmModal" tabindex="-1" aria-labelledby="unlockConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unlockConfirmModalLabel">Confirm Unlock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to unlock this application?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="unlockConfirmYes">Yes</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let activeUnlockForm = null;
        const unlockModalElement = document.getElementById('unlockConfirmModal');
        const unlockButtons = document.querySelectorAll('.unlock-confirm-btn');
        const confirmYesButton = document.getElementById('unlockConfirmYes');
        let unlockModal = null;

        if (typeof bootstrap !== 'undefined' && unlockModalElement) {
            unlockModal = new bootstrap.Modal(unlockModalElement);
        }

        unlockButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                activeUnlockForm = this.closest('form.unlock-form');
                if (unlockModal) {
                    unlockModal.show();
                } else if (activeUnlockForm) {
                    activeUnlockForm.submit();
                }
            });
        });

        if (confirmYesButton) {
            confirmYesButton.addEventListener('click', function() {
                if (activeUnlockForm) {
                    activeUnlockForm.submit();
                }
            });
        }
    });
</script>
@endpush
@endsection