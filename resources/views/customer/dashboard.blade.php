@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h3>Welcome, {{ $user->name }}</h3>

            <div class="mb-4">
                <a href="{{ route('customer.new_application.create') }}" class="btn btn-primary">Create New Loan Application</a>
            </div>

            @if (is_null($user->customer_financial_id) || is_null($user->customer_document_id))
                <div class="mb-4 d-flex flex-column gap-3">
                    @if (is_null($user->customer_financial_id))
                        <div class="alert alert-warning border-start border-warning border-4 shadow-sm mb-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" role="alert">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-warning bg-opacity-25 text-warning-emphasis p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; min-width: 42px;">
                                    <i class="bi bi-currency-dollar fs-5 text-warning-emphasis"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading fw-bold mb-1 text-dark">Financial Information Required</h6>
                                    <p class="mb-0 small text-muted">Please add your financial information to complete your profile and expedite loan processing.</p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('customer.financial') }}" class="btn btn-warning btn-sm text-nowrap fw-semibold">
                                    <i class="bi bi-plus-circle me-1"></i> Add Financial Info
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (is_null($user->customer_document_id))
                        <div class="alert alert-info border-start border-info border-4 shadow-sm mb-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" role="alert">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-info bg-opacity-25 text-info-emphasis p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; min-width: 42px;">
                                    <i class="bi bi-folder2-open fs-5 text-info-emphasis"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading fw-bold mb-1 text-dark">Customer Documents Required</h6>
                                    <p class="mb-0 small text-muted">Please upload your required documents (NID, photo, income proof, etc.) to complete your account setup.</p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('customer.documents') }}" class="btn btn-info btn-sm text-nowrap fw-semibold text-white">
                                    <i class="bi bi-upload me-1"></i> Upload Documents
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <p class="display-6 mb-0">{{ $totalApplications ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                  <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Reviewing</h5>
                            <p class="display-6 mb-0 text-warning">{{ $reviewApplications ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Approved</h5>
                            <p class="display-6 mb-0 text-success">{{ $approvedApplications ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Rejected</h5>
                            <p class="display-6 mb-0 text-danger">{{ $rejectedApplications ?? 0 }}</p>
                        </div>
                    </div>
                </div>
              
            </div>

            <h5 class="mb-3">Recent Applications</h5>
            @if (isset($recentApplications) && $recentApplications->count() > 0)
                <div class="table-responsive mb-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Request</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentApplications as $app)
                                <tr>
                                    <td>{{ $app->id }}</td>  
                                    <td>{{ ucfirst(str_replace('_', ' ', optional($app->serviceType)->name ?? $app->service_type)) }}</td>
                                    <td>৳{{ number_format($app->expected_amount, 2) }}</td>
                                    @php
                                        $dashboardStatus = $app->status;
                                        $latestLeadAccess = $app->leadAccesses->sortByDesc('updated_at')->first();
                                        if ($latestLeadAccess && $latestLeadAccess->application_status) {
                                            $dashboardStatus = $latestLeadAccess->application_status;
                                        }
                                        $canEditApplication = $app->isEditableByCustomer();
                                        $canDeleteApplication = $app->status === 'pending';
                                    @endphp
                                    <td>{{ ucfirst(str_replace('_', ' ', $dashboardStatus === 'active' ? 'Submitted' : ($dashboardStatus ?? 'pending'))) }}</td>
                                    <td>{{ $app->additional_notes ?? '-' }}</td>
                                    <td>{{ $app->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('customer.application.show', $app->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        @if ($canEditApplication)
                                            <a href="{{ route('customer.application.edit', $app->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        @endif
                                        @if ($canDeleteApplication)
                                            <a href="{{ route('customer.application.delete', $app->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
                                        @endif
                                        @if ($app->lead_accesses_count > 0)
                                            <div class="d-flex flex-column align-items-start">
                                                <a href="{{ route('customer.new_application.officer_details', ['newApplication' => $app, 'officer' => null]) }}" class="btn btn-sm btn-outline-success mb-1">
                                                    Officer Details
                                                    <span class="d-block small text-dark">{{ $app->lead_accesses_count }} Officer(s) Unlocked</span>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('customer.applications') }}" class="btn btn-outline-primary">View all applications</a>
            @else
                <p class="text-muted">You have no recent applications.</p>
            @endif

            <hr class="my-5">

            <!-- Security Guidelines Section -->
            <div class="mt-5 pt-4">
                <!-- Header Alert -->
                <div class="alert alert-warning border-2 border-warning" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-shield-exclamation fs-4"></i>
                        <div>
                            <h5 class="alert-heading mb-0">🛡️ গুরুত্বপূর্ণ নিরাপত্তা নির্দেশিকা</h5>
                            <small class="text-dark fw-semibold">আপনার নিরাপত্তা আমাদের অগ্রাধিকার</small>
                        </div>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="card-text mb-0">
                            <strong>Loan Linker</strong> শুধুমাত্র গ্রাহক এবং Verified Bank Officer-এর মধ্যে একটি ডিজিটাল সংযোগ তৈরি করে। নিরাপদ সেবা নিশ্চিত করতে অনুগ্রহ করে নিচের নির্দেশনাগুলো অনুসরণ করুন।
                        </p>
                    </div>
                </div>

                <!-- Guidelines Grid -->
                <div class="row g-3 mb-4">
                    <!-- Guideline 1 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-danger mb-3">
                                    <i class="bi bi-exclamation-circle me-2"></i>১. কোনো অবৈধ লেনদেন করবেন না
                                </h6>
                                <p class="card-text small text-muted">কোনো ব্যাংক অফিসার বা তৃতীয় পক্ষকে ব্যক্তিগতভাবে নগদ টাকা, বিকাশ, নগদ, রকেট বা অন্য কোনো মাধ্যমে অর্থ প্রদান করবেন না। সকল ব্যাংক ফি শুধুমাত্র সংশ্লিষ্ট ব্যাংকের নির্ধারিত নিয়মে পরিশোধ করুন।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 2 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-danger mb-3">
                                    <i class="bi bi-lock me-2"></i>২. ব্যক্তিগত ও গোপন তথ্য শেয়ার করবেন না
                                </h6>
                                <p class="card-text small text-muted">কোনো অবস্থাতেই আপনার ATM/PIN, OTP, CVV, Internet Banking Password, Mobile Banking Password বা অন্য কোনো গোপন তথ্য কারও সাথে শেয়ার করবেন না।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 3 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-info mb-3">
                                    <i class="bi bi-geo-alt me-2"></i>৩. নিরাপদ স্থানে সাক্ষাৎ করুন
                                </h6>
                                <p class="card-text small text-muted">যদি কোনো ব্যাংক অফিসার ব্যাংকের বাইরে দেখা করার অনুরোধ করেন, তাহলে নিজের নিরাপত্তা নিশ্চিত করুন। সম্ভব হলে ব্যাংক শাখা বা জনসমাগমপূর্ণ স্থানে সাক্ষাৎ করুন এবং প্রয়োজনে পরিচিত কাউকে বিষয়টি জানান।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 4 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-hand-thumbs-up me-2"></i>৪. অনুমোদনের আগে প্রসেসিং বন্ধ করবেন না
                                </h6>
                                <p class="card-text small text-muted">আপনার রিকোয়েস্ট একাধিক Verified Bank Officer গ্রহণ করে থাকলে, চূড়ান্ত অনুমোদন পাওয়ার পর অনুগ্রহ করে অন্য অফিসারদের ভদ্রভাবে জানিয়ে দিন।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 5 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-success mb-3">
                                    <i class="bi bi-check-circle me-2"></i>৫. অফিসারের পরিচয় যাচাই করুন
                                </h6>
                                <p class="card-text small text-muted">যোগাযোগের আগে নিশ্চিত করুন যে তিনি Loan Linker-এর Verified Bank Officer এবং সংশ্লিষ্ট ব্যাংকের বৈধ প্রতিনিধি।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 6 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-warning mb-3">
                                    <i class="bi bi-pencil-square me-2"></i>৬. কোনো ফাঁকা ফর্মে স্বাক্ষর করবেন না
                                </h6>
                                <p class="card-text small text-muted">সব নথি ভালোভাবে পড়ে এবং বুঝে তবেই স্বাক্ষর করুন।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 7 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-dark mb-3">
                                    <i class="bi bi-info-circle me-2"></i>৭. Loan Linker অনুমোদনের নিশ্চয়তা দেয় না
                                </h6>
                                <p class="card-text small text-muted">Loan বা Credit Card অনুমোদনের সম্পূর্ণ সিদ্ধান্ত সংশ্লিষ্ট ব্যাংকের নিজস্ব নীতিমালা, যোগ্যতা যাচাই এবং ক্রেডিট মূল্যায়নের উপর নির্ভরশীল।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 8 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-danger mb-3">
                                    <i class="bi bi-file-earmark-text me-2"></i>৮. ভুল তথ্য প্রদান করবেন না
                                </h6>
                                <p class="card-text small text-muted">আবেদনের সময় সঠিক ও সত্য তথ্য প্রদান করুন। ভুল তথ্য আবেদন বাতিল বা ভবিষ্যতে ব্যাংকিং জটিলতার কারণ হতে পারে।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 9 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-danger mb-3">
                                    <i class="bi bi-exclamation-triangle me-2"></i>৯. প্রতারণামূলক কার্যকলাপ রিপোর্ট করুন
                                </h6>
                                <p class="card-text small text-muted">কোনো অফিসার যদি সন্দেহজনক আচরণ করেন বা প্রতারণার চেষ্টা করেন, সঙ্গে সঙ্গে Loan Linker Support-এ রিপোর্ট করুন।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 10 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-info mb-3">
                                    <i class="bi bi-archive me-2"></i>১০. যোগাযোগের রেকর্ড সংরক্ষণ করুন
                                </h6>
                                <p class="card-text small text-muted">সম্ভব হলে গুরুত্বপূর্ণ মেসেজ, ইমেইল বা প্রয়োজনীয় নথির কপি সংরক্ষণ করুন। ভবিষ্যতে প্রয়োজন হলে এগুলো কাজে আসতে পারে।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 11 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-success mb-3">
                                    <i class="bi bi-chat-dots me-2"></i>১১. অফিসিয়াল যোগাযোগ মাধ্যম ব্যবহার করুন
                                </h6>
                                <p class="card-text small text-muted">Loan Linker-এর Website, App, অফিসিয়াল WhatsApp, Email বা Hotline-এর মাধ্যমে যোগাযোগ করুন। <strong>Email: care@loanlinker.xyz | Hotline: +880-969-732-2750</strong></p>
                            </div>
                        </div>
                    </div>

                    <!-- Guideline 12 -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-shield-lock me-2"></i>১২. নিরাপত্তা আপনার দায়িত্বও
                                </h6>
                                <p class="card-text small text-muted">কোনো আর্থিক সিদ্ধান্ত নেওয়ার আগে শর্তাবলি, সুদের হার, চার্জ ও অন্যান্য নিয়ম ভালোভাবে পড়ে বুঝে নিন।</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disclaimer Alert -->
                <div class="alert alert-danger border-2 border-danger" role="alert">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-exclamation-triangle-fill fs-5 mt-1"></i>
                        <div>
                            <h5 class="alert-heading mb-2">⚠️ গুরুত্বপূর্ণ ঘোষণা (Disclaimer)</h5>
                            <p class="mb-0 small">
                                <strong>Loan Linker</strong> কোনো ব্যাংক বা আর্থিক প্রতিষ্ঠানের বিকল্প নয়। আমরা শুধুমাত্র গ্রাহক ও Verified Bank Officer-এর মধ্যে একটি নিরাপদ ডিজিটাল সংযোগ তৈরি করি। Loan, Credit Card বা অন্য কোনো আর্থিক পণ্যের অনুমোদন, শর্তাবলি, সুদের হার এবং বিতরণ সম্পূর্ণভাবে সংশ্লিষ্ট ব্যাংক বা আর্থিক প্রতিষ্ঠানের নীতিমালার উপর নির্ভরশীল।
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Support Contact Card -->
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-3">প্রয়োজনে আমাদের সাথে যোগাযোগ করুন</h6>
                        <p class="card-text mb-2">
                            <a href="mailto:{{ $aboutSettings->contact_email }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-envelope me-1"></i>ইমেইল করুন
                            </a>
                        </p>
                        <p class="text-muted small">আমরা আপনার সুরক্ষা এবং সন্তুষ্টির জন্য প্রতিশ্রুতিবদ্ধ।</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
