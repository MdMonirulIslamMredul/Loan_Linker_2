<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanApplication;
use App\Models\NewLoanApplication;
use App\Models\LeadAccess;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\LoanCategory;
use App\Models\ServiceCategory;
use App\Models\District;
use App\Models\CustomerRating;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoanApplicationController extends Controller
{
    /**
     * Show the application form for a loan.
     */
    public function create(Loan $loan)
    {
        $loan->load(['branch.bank']);
        return view('loan-application-form', compact('loan'));
    }

    /**
     * Store a new loan application.
     */
    public function store(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'nid_number' => 'required|string|max:50',
            'present_address' => 'required|string',
            'permanent_address' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|string|max:255',
            'loan_amount' => 'required|numeric|min:0',
            'tenure_months' => 'required|integer|min:1',
            'employment_type' => 'required|in:employed,self-employed,business,professional,student',
            'company_name' => 'nullable|string|max:255',
            'purpose_of_loan' => 'required|string',
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        // Handle document uploads
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $document) {
                $path = $document->store('loan-applications', 'public');
                $documentPaths[] = $path;
            }
        }

        $validated['loan_id'] = $loan->id;
        $validated['documents'] = $documentPaths;
        $validated['status'] = 'pending';

        // Attach the authenticated customer if available
        if (auth()->check()) {
            $validated['customer_id'] = auth()->id();
        }

        LoanApplication::create($validated);

        return redirect()->route('loans.show', $loan)->with('success', 'Your loan application has been submitted successfully! We will contact you soon.');
    }

    /**
     * Display all loan applications (for super admin).
     */
    public function index(Request $request)
    {
        $query = LoanApplication::with(['loan.branch.bank'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by loan name
        if ($request->filled('loan_name')) {
            $query->whereHas('loan', function ($q) use ($request) {
                $q->where('loan_name', 'like', '%' . $request->loan_name . '%');
            });
        }

        // Filter by bank
        if ($request->filled('bank_id')) {
            $bankId = $request->bank_id;
            $query->whereHas('loan', function ($q) use ($bankId) {
                $q->whereHas('branch', function ($q2) use ($bankId) {
                    $q2->where('bank_id', $bankId);
                });
            });
        }

        // Filter by branch
        if ($request->filled('branch_id')) {
            $query->whereHas('loan', function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->whereHas('loan', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Date range filters
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->paginate(10);

        // Provide filter lists
        $banks = Bank::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        $categories = LoanCategory::where('is_active', true)->orderBy('name')->get();

        return view('super-admin.applications.index', compact('applications', 'banks', 'branches', 'categories'));
    }

    /**
     * Display loan applications for a specific branch (for branch admin).
     */
    public function branchApplications(Request $request)
    {
        $branchId = auth()->user()->branch_id;

        $query = LoanApplication::with(['loan.branch.bank'])
            ->whereHas('loan', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                    ->where('branch_admin_id', auth()->id());
            })
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by loan (specific loan)
        if ($request->filled('loan_id')) {
            $query->where('loan_id', $request->loan_id);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            $query->whereHas('loan', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Filter by access (locked/unlocked) for branch officers
        if ($request->filled('access')) {
            $access = $request->access;
            $userId = auth()->id();

            if ($access === 'unlocked') {
                $query->whereExists(function ($q) use ($userId) {
                    $q->select(DB::raw(1))
                        ->from('lead_accesses')
                        ->whereColumn('lead_accesses.application_id', 'loan_applications.id')
                        ->where('lead_accesses.officer_id', $userId);
                });
            } elseif ($access === 'locked') {
                $query->whereNotExists(function ($q) use ($userId) {
                    $q->select(DB::raw(1))
                        ->from('lead_accesses')
                        ->whereColumn('lead_accesses.application_id', 'loan_applications.id')
                        ->where('lead_accesses.officer_id', $userId);
                });
            }
        }

        $applications = $query->paginate(10);

        // Provide loans and categories for filters
        $loans = Loan::where('branch_id', $branchId)
            ->where('branch_admin_id', auth()->id())
            ->get();
        $categories = LoanCategory::where('is_active', true)->get();

        return view('branch-admin.applications.index', compact('applications', 'loans', 'categories'));
    }

    public function branchNewApplications(Request $request)
    {
        $query = NewLoanApplication::with(['customer.contactDistrict'])
            ->whereHas('customer', function ($customerQuery) {
                $customerQuery->where('is_active', true);
            })
            ->where('status', 'active')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_category_id')) {
            $query->where('service_category_id', $request->service_category_id);
        } elseif ($request->filled('service_category')) {
            $query->where('service_category', $request->service_category);
        }

        if ($request->filled('service_type_id')) {
            $query->where('service_type_id', $request->service_type_id);
        } elseif ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('bank_id')) {
            $bankId = (int) $request->bank_id;
            $query->whereJsonContains('bank_ids', $bankId);
        }

        if ($request->filled('district_id')) {
            $districtId = (int) $request->district_id;
            $query->whereHas('customer', function ($customerQuery) use ($districtId) {
                $customerQuery->where('c_district_id', $districtId);
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->paginate(10);

        $banks = Bank::orderBy('name')->get();
        $serviceCategories = ServiceCategory::with('serviceTypes')->where('is_active', true)->orderBy('name')->get();
        $districts = District::orderBy('name')->get();

        return view('branch-admin.new-applications.index', compact('applications', 'banks', 'serviceCategories', 'districts'));
    }

    public function branchUnlockedNewApplications(Request $request)
    {
        $user = auth()->user();

        $unlockedIds = \App\Models\LeadAccess::where('officer_id', $user->id)
            ->whereNotNull('newloan_id')
            ->pluck('newloan_id');

        $query = NewLoanApplication::with(['customer.contactDistrict'])
            ->whereIn('id', $unlockedIds)
            // ->whereHas('customer', function ($customerQuery) {
            //     $customerQuery->where('is_active', true);
            // })
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_category_id')) {
            $query->where('service_category_id', $request->service_category_id);
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->paginate(10);
        $banks = Bank::orderBy('name')->get();
        $serviceCategories = ServiceCategory::with('serviceTypes')->where('is_active', true)->orderBy('name')->get();

        return view('branch-admin.new-applications.unlocked', compact('applications', 'banks', 'serviceCategories'));
    }

    public function branchLockedNewApplications(Request $request)
    {
        $user = auth()->user();

        $unlockedIds = \App\Models\LeadAccess::where('officer_id', $user->id)
            ->whereNotNull('newloan_id')
            ->pluck('newloan_id');

        $query = NewLoanApplication::with(['customer.contactDistrict'])
            ->whereNotIn('id', $unlockedIds)
            ->whereHas('customer', function ($customerQuery) {
                $customerQuery->where('is_active', true);
            })
            ->where('status', 'active')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_category_id')) {
            $query->where('service_category_id', $request->service_category_id);
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->paginate(10);
        $banks = Bank::orderBy('name')->get();
        $serviceCategories = ServiceCategory::with('serviceTypes')->where('is_active', true)->orderBy('name')->get();

        return view('branch-admin.new-applications.locked', compact('applications', 'banks', 'serviceCategories'));
    }

    public function newApplications(Request $request)
    {
        $query = NewLoanApplication::with('customer')
            ->whereHas('customer', function ($customerQuery) {
                $customerQuery->where('is_active', true);
            })
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_category')) {
            $query->where('service_category', $request->service_category);
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('bank_id')) {
            $bankId = (int) $request->bank_id;
            $query->whereJsonContains('bank_ids', $bankId);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->paginate(10);

        $banks = Bank::orderBy('name')->get();

        return view('super-admin.new-applications.index', compact('applications', 'banks'));
    }

    public function branchNewApplicationShow(NewLoanApplication $newApplication)
    {
        $newApplication->load([
            'customer.customerDocument',
            'customer.customerFinancial',
            'customerRatings',
            'serviceCategory',
            'serviceType',
        ]);

        if (! $newApplication->customer || ! $newApplication->customer->is_active) {
            return redirect()->route('branch-admin.new-applications.index')
                ->with('error', 'This request is not available.');
        }

        $user = auth()->user();
        $hasAccess = false;
        $officerAccess = null;

        if ($user->isSuperAdmin() || $user->isBankAdmin()) {
            $hasAccess = true;
        } else {
            $officerAccess = \App\Models\LeadAccess::where('officer_id', $user->id)
                ->where('newloan_id', $newApplication->id)
                ->first();
            $hasAccess = (bool) $officerAccess;
        }

        $customerAverageRating = null;
        $customerRatingCount = 0;
        $customerAverageStars = 0;

        if ($newApplication->customer?->id) {
            $customerRatingCount = CustomerRating::where('customer_id', $newApplication->customer->id)->count();
            if ($customerRatingCount) {
                $customerAverageRating = CustomerRating::where('customer_id', $newApplication->customer->id)->avg('rating');
                $customerAverageStars = (int) round($customerAverageRating);
            }
        }

        $banks = Bank::orderBy('name')->get();

        return view('branch-admin.new-applications.show', compact(
            'newApplication',
            'banks',
            'hasAccess',
            'customerAverageRating',
            'customerRatingCount',
            'customerAverageStars',
            'officerAccess'
        ));
    }

    public function branchCustomerRatings(NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'branch_admin') {
            abort(403, 'Unauthorized.');
        }

        $newApplication->load(['customer']);
        $customer = $newApplication->customer;

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found for this request.');
        }

        $customerRatings = CustomerRating::with(['branchAdmin', 'newLoanApplication'])
            ->where('customer_id', $customer->id)
            ->orderByDesc('created_at')
            ->get();

        $customerRatingCount = $customerRatings->count();
        $customerAverageRating = $customerRatingCount ? $customerRatings->avg('rating') : null;
        $customerAverageStars = $customerAverageRating ? (int) round($customerAverageRating) : 0;

        return view('branch-admin.new-applications.customer-ratings', compact(
            'newApplication',
            'customer',
            'customerRatings',
            'customerRatingCount',
            'customerAverageRating',
            'customerAverageStars'
        ));
    }

    public function storeCustomerRating(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'branch_admin') {
            abort(403, 'Unauthorized.');
        }

        $hasAccess = \App\Models\LeadAccess::where('officer_id', $user->id)
            ->where('newloan_id', $newApplication->id)
            ->exists();

        if (! $hasAccess) {
            return redirect()->back()->with('error', 'You must unlock this request before rating the customer.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        CustomerRating::updateOrCreate(
            [
                'branch_admin_id' => $user->id,
                'new_loan_application_id' => $newApplication->id,
            ],
            [
                'customer_id' => $newApplication->customer_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return redirect()->back()->with('success', 'Customer rating saved successfully.');
    }

    public function newApplicationShow(NewLoanApplication $newApplication)
    {
        $newApplication->load(['customer', 'leadAccesses.officer']);

        if (! $newApplication->customer || ! $newApplication->customer->is_active) {
            return redirect()->route('super-admin.new-applications.index')
                ->with('error', 'This request is not available.');
        }
        if (! $newApplication->admin_view) {
            $newApplication->admin_view = true;
            $newApplication->save();
        }
        $banks = Bank::orderBy('name')->get();

        return view('super-admin.new-applications.show', compact('newApplication', 'banks'));
    }

    public function updateNewLoanApplicationStatus(Request $request, NewLoanApplication $newApplication)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,pending,review,approved,rejected',
        ]);

        $user = auth()->user();

        if ($user->isBranchAdmin()) {
            $updated = LeadAccess::where('newloan_id', $newApplication->id)
                ->where('officer_id', $user->id)
                ->update(['application_status' => $validated['status']]);

            if (! $updated) {
                return redirect()->back()->with('error', 'You do not have access to update this request status.');
            }

            return redirect()->back()->with('success', 'Request status updated successfully for your unlocked lead.');
        }

        $newApplication->update(['status' => $validated['status']]);

        // Persist the current request status in all lead access records for this request.
        LeadAccess::where('newloan_id', $newApplication->id)
            ->update(['application_status' => $validated['status']]);

        return redirect()->back()->with('success', 'Request status updated successfully!');
    }

    //add new logic for branch admin to update new loan application status to review, approved, rejected , status will be update in lead_acces table only for branch officer who have access to that lead

    public function branch_show(LoanApplication $application)
    {
        $application->load(['loan.branch.bank']);

        $user = auth()->user();
        // super-admin and bank-admin can always view
        if ($user->isSuperAdmin() || $user->isBankAdmin()) {
            return view('branch-admin.applications.show', compact('application'));
        }

        // check lead access for officer
        $hasAccess = \App\Models\LeadAccess::where('officer_id', $user->id)
            ->where('application_id', $application->id)
            ->exists();

        if (! $hasAccess) {
            return redirect()->route('branch-admin.applications.index')
                ->with('error', 'You do not have access to view this application. Purchase or unlock the lead first.');
        }

        return view('branch-admin.applications.show', compact('application'));
    }

    /**
     * Display a single loan application.
     */
    public function show(LoanApplication $application)
    {
        $application->load(['loan.branch.bank']);
        return view('super-admin.applications.show', compact('application'));
    }

    /**
     * Update application status.
     */
    public function updateStatus(Request $request, LoanApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }
}
