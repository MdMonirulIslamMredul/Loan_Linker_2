<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanApplication;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\LoanCategory;
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

        $applications = $query->paginate(15);

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

        $applications = $query->paginate(15);

        // Provide loans and categories for filters
        $loans = Loan::where('branch_id', $branchId)
            ->where('branch_admin_id', auth()->id())
            ->get();
        $categories = LoanCategory::where('is_active', true)->get();

        return view('branch-admin.applications.index', compact('applications', 'loans', 'categories'));
    }

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
            'status' => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }
}
