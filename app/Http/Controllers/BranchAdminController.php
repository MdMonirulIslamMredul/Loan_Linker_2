<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BranchAdminController extends Controller
{
    /**
     * Display the branch admin dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $branch = $user->branch;
        $bank = $user->bank;

        // Get loan applications for this branch's loans
        $applications = \App\Models\LoanApplication::whereHas('loan', function ($query) use ($user) {
            $query->where('branch_id', $user->branch_id)
                ->where('branch_admin_id', $user->id);
        })
            ->with(['loan'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('branch-admin.dashboard', compact('branch', 'bank', 'applications'));
    }

    /**
     * Show branch-admin profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('branch-admin.profile', compact('user'));
    }

    /**
     * Show edit profile form.
     */
    public function editProfile()
    {
        $user = Auth::user();
        $branches = \App\Models\Branch::where('is_active', true)->get();
        return view('branch-admin.edit-profile', compact('user', 'branches'));
    }

    /**
     * Update branch-admin profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->save();

        return redirect()->route('branch-admin.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Show change password form for branch-admin.
     */
    public function editPassword()
    {
        return view('branch-admin.change-password');
    }

    /**
     * Update password for authenticated branch-admin.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('branch-admin.dashboard')->with('success', 'Password updated successfully.');
    }

    /**
     * Display a listing of the loans.
     */
    public function indexLoans()
    {
        $branchId = Auth::user()->branch_id;
        $loans = Loan::with('category')
            ->where('branch_id', $branchId)
            ->where('branch_admin_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('branch-admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function createLoan()
    {
        $categories = LoanCategory::where('is_active', true)->orderBy('name')->get();
        return view('branch-admin.loans.create', compact('categories'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:loan_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'details1' => 'nullable|string',
            'details2' => 'nullable|string',
            'details3' => 'nullable|string',
            'details4' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'processing_fee' => 'nullable|numeric|min:0|max:100',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'min_tenure_months' => 'nullable|integer|min:1',
            'max_tenure_months' => 'nullable|integer|min:1',
            'eligibility' => 'nullable|string',
            'features' => 'nullable|string',
            'documents_required' => 'nullable|string',
        ]);

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $bannerName = time() . '_loan_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/loan-banners'), $bannerName);
            $validated['banner'] = 'uploads/loan-banners/' . $bannerName;
        }

        $validated['branch_id'] = Auth::user()->branch_id;
        $validated['branch_admin_id'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        Loan::create($validated);

        return redirect()->route('branch-admin.loans.index')
            ->with('success', 'Loan created successfully.');
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function editLoan(Loan $loan)
    {
        // Check if loan belongs to branch admin's branch
        if ($loan->branch_id !== Auth::user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = LoanCategory::where('is_active', true)->orderBy('name')->get();
        return view('branch-admin.loans.edit', compact('loan', 'categories'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function updateLoan(Request $request, Loan $loan)
    {
        // Check if loan belongs to branch admin's branch
        if ($loan->branch_id !== Auth::user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:loan_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'details1' => 'nullable|string',
            'details2' => 'nullable|string',
            'details3' => 'nullable|string',
            'details4' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'processing_fee' => 'nullable|numeric|min:0|max:100',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'min_tenure_months' => 'nullable|integer|min:1',
            'max_tenure_months' => 'nullable|integer|min:1',
            'eligibility' => 'nullable|string',
            'features' => 'nullable|string',
            'documents_required' => 'nullable|string',
        ]);

        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($loan->banner && file_exists(public_path($loan->banner))) {
                unlink(public_path($loan->banner));
            }

            $bannerName = time() . '_loan_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/loan-banners'), $bannerName);
            $validated['banner'] = 'uploads/loan-banners/' . $bannerName;
        }

        $validated['is_active'] = $request->has('is_active');

        $loan->update($validated);

        return redirect()->route('branch-admin.loans.index')
            ->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroyLoan(Loan $loan)
    {
        // Check if loan belongs to branch admin's branch
        if ($loan->branch_id !== Auth::user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete banner if exists
        if ($loan->banner && file_exists(public_path($loan->banner))) {
            unlink(public_path($loan->banner));
        }

        $loan->delete();

        return redirect()->route('branch-admin.loans.index')
            ->with('success', 'Loan deleted successfully.');
    }
}
