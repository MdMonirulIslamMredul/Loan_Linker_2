<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Loan;
use App\Models\LoanCategory;
use App\Models\LoanApplication;

class BankAdminController extends Controller
{
    /**
     * Display the bank admin dashboard.
     */
    public function dashboard()
    {
        $bankId = Auth::user()->bank_id;
        $branches = Branch::where('bank_id', $bankId)->withCount('users')->get();
        return view('bank-admin.dashboard', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     */
    public function createBranch()
    {
        return view('bank-admin.branches.create');
    }

    /**
     * Store a newly created branch in storage.
     */
    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        $validated['bank_id'] = Auth::user()->bank_id;

        Branch::create($validated);

        return redirect()->route('bank-admin.dashboard')->with('success', 'Branch created successfully.');
    }

    /**
     * Show the form for creating a new branch admin.
     */
    public function createBranchAdmin()
    {
        $bankId = Auth::user()->bank_id;
        $branches = Branch::where('bank_id', $bankId)->where('is_active', true)->get();
        return view('bank-admin.branch-admins.create', compact('branches'));
    }

    /**
     * Store a newly created branch admin in storage.
     */
    public function storeBranchAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Verify the branch belongs to the bank admin's bank
        $branch = Branch::findOrFail($validated['branch_id']);
        if ($branch->bank_id !== Auth::user()->bank_id) {
            return back()->withErrors(['branch_id' => 'Invalid branch selected.']);
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'branch_admin',
            'bank_id' => Auth::user()->bank_id,
            'branch_id' => $validated['branch_id'],
        ]);

        return redirect()->route('bank-admin.dashboard')->with('success', 'Branch Admin created successfully.');
    }

    /**
     * Display a listing of all branches.
     */
    public function listBranches()
    {
        $bankId = Auth::user()->bank_id;
        $branches = Branch::where('bank_id', $bankId)->withCount('users')->get();
        return view('bank-admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for editing a branch.
     */
    public function editBranch(Branch $branch)
    {
        // Verify the branch belongs to the bank admin's bank
        if ($branch->bank_id !== Auth::user()->bank_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('bank-admin.branches.edit', compact('branch'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function updateBranch(Request $request, Branch $branch)
    {
        // Verify the branch belongs to the bank admin's bank
        if ($branch->bank_id !== Auth::user()->bank_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'is_active' => 'boolean',
        ]);

        $branch->update($validated);

        return redirect()->route('bank-admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroyBranch(Branch $branch)
    {
        // Verify the branch belongs to the bank admin's bank
        if ($branch->bank_id !== Auth::user()->bank_id) {
            abort(403, 'Unauthorized action.');
        }

        $branch->delete();
        return redirect()->route('bank-admin.branches.index')->with('success', 'Branch deleted successfully.');
    }

    /**
     * Display a listing of all branch admins.
     */
    public function listBranchAdmins()
    {
        $bankId = Auth::user()->bank_id;
        $branchAdmins = User::with('branch')->where('role', 'branch_admin')->where('bank_id', $bankId)->get();
        return view('bank-admin.branch-admins.index', compact('branchAdmins'));
    }

    /**
     * List loans for this bank (across branches).
     */
    public function indexLoans()
    {
        $bankId = Auth::user()->bank_id;
        $loans = Loan::with('branch')
            ->whereHas('branch', function ($q) use ($bankId) {
                $q->where('bank_id', $bankId);
            })->latest()->paginate(15);

        return view('bank-admin.loans.index', compact('loans'));
    }

    public function createLoan()
    {
        $bankId = Auth::user()->bank_id;
        $branches = Branch::where('bank_id', $bankId)->where('is_active', true)->get();
        $categories = LoanCategory::where('is_active', true)->get();
        return view('bank-admin.loans.create', compact('branches', 'categories'));
    }

    public function storeLoan(Request $request)
    {
        $bankId = Auth::user()->bank_id;

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'category_id' => 'nullable|exists:loan_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'interest_rate' => 'nullable|numeric',
            'processing_fee' => 'nullable|numeric',
            'min_amount' => 'nullable|numeric',
            'max_amount' => 'nullable|numeric',
            'min_tenure_months' => 'nullable|integer',
            'max_tenure_months' => 'nullable|integer',
            'is_active' => 'boolean',
            'banner' => 'nullable|image|max:2048',
        ]);

        $branch = Branch::findOrFail($validated['branch_id']);
        if ($branch->bank_id !== $bankId) {
            return back()->withErrors(['branch_id' => 'Invalid branch for your bank.']);
        }

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('loans', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Loan::create($validated);

        return redirect()->route('bank-admin.loans.index')->with('success', 'Loan created successfully.');
    }

    public function editLoan(Loan $loan)
    {
        $bankId = Auth::user()->bank_id;
        if ($loan->branch->bank_id !== $bankId) abort(403);
        $branches = Branch::where('bank_id', $bankId)->where('is_active', true)->get();
        $categories = LoanCategory::where('is_active', true)->get();
        return view('bank-admin.loans.edit', compact('loan', 'branches', 'categories'));
    }

    public function updateLoan(Request $request, Loan $loan)
    {
        $bankId = Auth::user()->bank_id;
        if ($loan->branch->bank_id !== $bankId) abort(403);

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'category_id' => 'nullable|exists:loan_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'interest_rate' => 'nullable|numeric',
            'processing_fee' => 'nullable|numeric',
            'min_amount' => 'nullable|numeric',
            'max_amount' => 'nullable|numeric',
            'min_tenure_months' => 'nullable|integer',
            'max_tenure_months' => 'nullable|integer',
            'is_active' => 'boolean',
            'banner' => 'nullable|image|max:2048',
        ]);

        $branch = Branch::findOrFail($validated['branch_id']);
        if ($branch->bank_id !== $bankId) {
            return back()->withErrors(['branch_id' => 'Invalid branch for your bank.']);
        }

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('loans', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $loan->update($validated);

        return redirect()->route('bank-admin.loans.index')->with('success', 'Loan updated successfully.');
    }

    public function destroyLoan(Loan $loan)
    {
        $bankId = Auth::user()->bank_id;
        if ($loan->branch->bank_id !== $bankId) abort(403);
        $loan->delete();
        return redirect()->route('bank-admin.loans.index')->with('success', 'Loan deleted successfully.');
    }

    /**
     * Bank-level loan applications listing.
     */
    public function applications(Request $request)
    {
        $bankId = Auth::user()->bank_id;

        $query = LoanApplication::with(['loan.branch.bank'])
            ->whereHas('loan', function ($q) use ($bankId) {
                $q->whereHas('branch', function ($q2) use ($bankId) {
                    $q2->where('bank_id', $bankId);
                });
            })->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by branch (loan's branch)
        if ($request->filled('branch_id')) {
            $branchId = $request->branch_id;
            $query->whereHas('loan', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        // Filter by loan category
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

        $applications = $query->paginate(15);

        // Provide branches and categories for filters
        $branches = Branch::where('bank_id', $bankId)->where('is_active', true)->get();
        $categories = LoanCategory::where('is_active', true)->get();

        return view('bank-admin.applications.index', compact('applications', 'branches', 'categories'));
    }

    public function showApplication(LoanApplication $application)
    {
        $bankId = Auth::user()->bank_id;
        if ($application->loan->branch->bank_id !== $bankId) abort(403);
        $application->load(['loan.branch.bank']);
        return view('bank-admin.applications.show', compact('application'));
    }

    public function updateApplicationStatus(Request $request, LoanApplication $application)
    {
        $bankId = Auth::user()->bank_id;
        if ($application->loan->branch->bank_id !== $bankId) abort(403);

        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }
}
