<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankOfficial;
use App\Models\Division;
use App\Models\District;
use App\Models\LeadAccess;
use App\Models\Loan;
use App\Models\LoanCategory;
use App\Models\NewLoanApplication;
use App\Models\OfficerDocument;
use App\Models\CustomerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

        // $newApplications = NewLoanApplication::where('status', 'pending')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);

           
        $newApplications = NewLoanApplication::with(['serviceCategory', 'serviceType', 'customer.contactDistrict'])
            ->whereIn('status', ['pending', 'active'])
            ->whereHas('customer', function ($customerQuery) {
                $customerQuery->where('is_active', true);
            })
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $newRequestsCount = NewLoanApplication::whereIn('status', ['pending', 'active'])
            ->whereHas('customer', function ($customerQuery) {
                $customerQuery->where('is_active', true);
            })
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $unlockedCount = LeadAccess::where('officer_id', $user->id)
            //  ->whereHas('newLoanApplication.customer', function ($customerQuery) {
            //     $customerQuery->where('is_active', true);
            //  })
            ->whereNotNull('newloan_id')
            ->count();

        $unlockedCount2 = LeadAccess::where('officer_id', $user->id)
            ->whereNotNull('newloan_id')
            ->whereHas('newLoanApplication', function ($query) {
                $query->where('status', 'active')
                    ->whereHas('customer', function ($customerQuery) {
                        $customerQuery->where('is_active', true);
                    });
            })
            ->count();

        $totalNewApplications = NewLoanApplication::where('status', 'active')
            ->whereHas('customer', function ($customerQuery) {
                $customerQuery->where('is_active', true);
            })->count();
        $lockedCount = max(0, $totalNewApplications - $unlockedCount2);

        // Get loan applications for this branch's loans
        $applications = \App\Models\LoanApplication::whereHas('loan', function ($query) use ($user) {
            $query->where('branch_id', $user->branch_id)
                ->where('branch_admin_id', $user->id);
        })
            ->with(['loan'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('branch-admin.dashboard', compact('branch', 'bank', 'applications', 'newApplications', 'newRequestsCount', 'unlockedCount', 'lockedCount'));
    }

    protected function getLocationData(): array
    {
        $divisions = Division::orderBy('name')->pluck('name', 'id')->toArray();
        $districts = District::orderBy('name')
            ->get()
            ->groupBy('division_id')
            ->map(function ($group) {
                return $group->pluck('name', 'id')->toArray();
            })
            ->toArray();

        return [
            'divisions' => $divisions,
            'districts' => $districts,
        ];
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
        $locationData = $this->getLocationData();
        $banks = Bank::where('is_active', true)->get();

        return view('branch-admin.edit-profile', [
            'user' => $user,
            'branches' => $branches,
            'divisions' => $locationData['divisions'],
            'districts' => $locationData['districts'],
            'banks' => $banks,  
        ]);
    }

    /**
     * Update branch-admin profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $locationData = $this->getLocationData();
        $divisions = $locationData['divisions'];
        $districts = $locationData['districts'];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email,' . $user->id,
            'email' => ['required', 'email', 'max:255', 'regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.(com)$/i', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'regex:/^01[0-9]{9}$/', Rule::unique('users', 'phone')->ignore($user->id)],
            'dob' => 'nullable|date',
            'nid_number' => 'nullable|string|max:255',
            'bank_id' => 'nullable|integer|exists:banks,id',
            'c_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'c_district_id' => ['required', 'integer'],
            'contact_address' => 'nullable|string|max:1000',
            'p_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'p_district_id' => ['required', 'integer'],
            'permanent_address' => 'nullable|string|max:1000',
            'education' => 'nullable|string|max:255',
            'profession' => 'nullable|string|max:255',
            'organization_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'date_of_joining' => 'nullable|date',
            'total_working_experience' => 'nullable|string|max:100',
        ]);

        if (! isset($districts[$validated['c_division_id']][$validated['c_district_id']])) {
            return back()->withErrors(['c_district_id' => 'The selected contact district does not belong to the selected division.'])->withInput();
        }

        if (! isset($districts[$validated['p_division_id']][$validated['p_district_id']])) {
            return back()->withErrors(['p_district_id' => 'The selected permanent district does not belong to the selected division.'])->withInput();
        }

        $user->fill($validated);
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
     * Show the bank official information form.
     */
    public function bankOfficial()
    {
        $user = Auth::user();
        $bankOfficial = $user->bankOfficial;
        $banks = Bank::orderBy('name')->get();

        return view('branch-admin.bank-official', compact('bankOfficial', 'banks'));
    }

    /**
     * Store bank official information.
     */
    public function storeBankOfficial(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255|exists:banks,name',
            'branch_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'office_id_number' => 'required|string|max:255',
            'date_of_joining' => 'required|date',
            'official_mobile_number' => 'required|string|max:50',
            'official_email' => 'required|email|max:255',
            'working_area' => 'required|string|max:255',
        ]);

        $bankOfficial = $user->bankOfficial ?? new BankOfficial();
        $bankOfficial->fill($validated);
        $bankOfficial->save();

        $bank = Bank::where('name', $validated['bank_name'])->first();
        if ($bank) {
            $user->bank_id = $bank->id;
        }

        $user->bank_official_id = $bankOfficial->id;
        $user->save();

        return redirect()->route('branch-admin.profile')->with('success', 'Bank official information saved successfully.');
    }

    /**
     * Show the officer document upload form.
     */
    public function officerDocument()
    {
        $user = Auth::user();
        $officerDocument = $user->officerDocument;

        return view('branch-admin.officer-document', compact('officerDocument'));
    }

    /**
     * Store officer document uploads.
     */
    public function storeOfficerDocument(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'picture' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'nid' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'office_id' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'visiting_card' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
        ]);

        $officerDocument = $user->officerDocument ?? new OfficerDocument();

        $documentFields = [
            'picture' => 'Picture',
            'nid' => 'NID',
            'office_id' => 'Office ID',
            'visiting_card' => 'Visiting Card',
        ];

        foreach ($documentFields as $field => $label) {
            if ($request->hasFile($field) && $officerDocument->{$field}) {
                return back()
                    ->withErrors([
                        $field => "The {$label} has already been uploaded and cannot be changed. Please contact admin to update this document.",
                    ])
                    ->withInput();
            }
        }

        foreach (array_keys($documentFields) as $field) {
            if ($request->hasFile($field) && !$officerDocument->{$field}) {
                $officerDocument->{$field} = $request->file($field)->store('officer_documents', 'public');
            }
        }

        $officerDocument->save();

        $user->officer_document_id = $officerDocument->id;
        $user->save();

        return redirect()->route('branch-admin.profile')->with('success', 'Officer documents saved successfully.');
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

    /**
     * Show branch admin rating history and available customer rating opportunities.
     */
    public function ratingsHistory()
    {
        $user = Auth::user();

        $ratings = CustomerRating::with(['customer', 'newLoanApplication'])
            ->where('branch_admin_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $ratingCount = $ratings->count();
        $averageRating = $ratingCount ? $ratings->avg('rating') : null;
        $averageStars = $averageRating ? (int) round($averageRating) : 0;

        $unlocks = \App\Models\LeadAccess::with(['newLoanApplication.customer'])
            ->where('officer_id', $user->id)
            ->whereNotNull('newloan_id')
            ->orderByDesc('created_at')
            ->get();

        $ratingKeys = $ratings->mapWithKeys(function ($rating) {
            return [sprintf('%s', $rating->new_loan_application_id) => true];
        });

        $pendingUnlocks = $unlocks->filter(function ($unlock) use ($ratingKeys) {
            return $unlock->newloan_id && ! isset($ratingKeys[$unlock->newloan_id]);
        });

        return view('branch-admin.ratings-history', compact(
            'ratings',
            'ratingCount',
            'averageRating',
            'averageStars',
            'pendingUnlocks'
        ));
    }
}
