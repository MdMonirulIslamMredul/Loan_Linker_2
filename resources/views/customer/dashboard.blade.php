@extends('layouts.customer')

@section('customer-content')
    <div class="card">
        <div class="card-body">
            <h3>Welcome, {{ $user->name }}</h3>

            <div class="mb-4">
                <a href="{{ route('customer.new_application.create') }}" class="btn btn-primary">Create New Loan Application</a>
            </div>

            <p class="text-muted">This is your customer dashboard. From here you can view your profile and loan applications.
            </p>

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
                                        $canEditApplication = in_array($dashboardStatus, ['pending', 'active'], true);
                                    @endphp
                                    <td>{{ ucfirst(str_replace('_', ' ', $dashboardStatus === 'active' ? 'Submitted' : ($dashboardStatus ?? 'pending'))) }}</td>
                                    <td>{{ $app->additional_notes ?? '-' }}</td>
                                    <td>{{ $app->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('customer.application.show', $app->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        @if ($canEditApplication)
                                            <a href="{{ route('customer.application.edit', $app->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        @endif
                                        <a href="{{ route('customer.application.delete', $app->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
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

            <hr>

            <p class="text-muted">Use the menu on the left to access your profile and loan applications. We are working on
                adding more features to your dashboard soon, so stay tuned!</p>
            <p class="text-muted">If you have any questions or need assistance, please contact us at <a
                    href="mailto:{{ $aboutSettings->contact_email }}">{{ $aboutSettings->contact_email }}</a>.</p>
            <p class="text-muted">Thank you for using Loan Linker to compare loan products from banks in Bangladesh. We are
                committed to helping you find the best loan options for your needs.</p>
            <p class="text-muted">We are continuously improving our service, so if you have any feedback or suggestions,
                please don't hesitate to reach out. Your input helps us make Loan Linker better for everyone.</p>
            <p class="text-muted">Remember to check your loan application status regularly and keep an eye on your email for
                updates from the banks. We wish you the best of luck in finding the right loan for you!</p>
            <p class="text-muted">Thank you for being a valued customer of Loan Linker. We look forward to serving you and
                helping you navigate the loan application process with ease and confidence.</p>
        </div>
    </div>
@endsection
