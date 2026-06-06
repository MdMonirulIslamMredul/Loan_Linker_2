<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\District;
use App\Models\Loan;
use App\Models\LoanCategory;
use App\Models\User;
use App\Models\CustomerDocument;
use App\Models\CustomerMessage;
use App\Models\CustomerRating;
use App\Models\OfficerDocument;
use App\Models\BankOfficerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    /**
     * Display the super admin dashboard.
     */
    public function dashboard()
    {
        $banks = Bank::withCount('branches', 'users')->get();
        return view('super-admin.dashboard', compact('banks'));
    }

    /**
     * Show the form for creating a new bank.
     */
    public function createBank()
    {
        return view('super-admin.banks.create');
    }

    /**
     * Store a newly created bank in storage.
     */
    public function storeBank(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:banks',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoName = time() . '_logo_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('uploads/bank-logos'), $logoName);
            $validated['logo'] = 'uploads/bank-logos/' . $logoName;
        }

        if ($request->hasFile('banner')) {
            $bannerName = time() . '_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/bank-banners'), $bannerName);
            $validated['banner'] = 'uploads/bank-banners/' . $bannerName;
        }

        Bank::create($validated);

        return redirect()->route('super-admin.dashboard')->with('success', 'Bank created successfully.');
    }

    /**
     * Show the form for creating a new bank admin.
     */
    public function createBankAdmin()
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.bank-admins.create', compact('banks'));
    }

    /**
     * Store a newly created bank admin in storage.
     */
    public function storeBankAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'bank_id' => 'required|exists:banks,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'bank_admin',
            'bank_id' => $validated['bank_id'],
        ]);

        return redirect()->route('super-admin.dashboard')->with('success', 'Bank Admin created successfully.');
    }

    /**
     * Display a listing of all bank admins.
     */
    public function listBankAdmins()
    {
        $bankAdmins = User::with('bank')->where('role', 'bank_admin')->paginate(10);
        return view('super-admin.bank-admins.index', compact('bankAdmins'));
    }

    /**
     * Show the form for editing a bank admin.
     */
    public function editBankAdmin(User $user)
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.bank-admins.edit', compact('user', 'banks'));
    }

    /**
     * Update the specified bank admin in storage.
     */
    public function updateBankAdmin(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'bank_id' => 'required|exists:banks,id',
            'is_active' => 'nullable',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->bank_id = $validated['bank_id'];
        $user->is_active = $request->boolean('is_active');

        // Only update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('super-admin.bank-admins.index')->with('success', 'Bank Admin updated successfully.');
    }

    /**
     * Display a listing of all banks.
     */
    public function listBanks()
    {
        $banks = Bank::withCount('branches', 'users')->get();
        return view('super-admin.banks.index', compact('banks'));
    }

    /**
     * Show the form for editing a bank.
     */
    public function editBank(Bank $bank)
    {
        return view('super-admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified bank in storage.
     */
    public function updateBank(Request $request, Bank $bank)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:banks,code,' . $bank->id,
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $logoName = time() . '_logo_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('uploads/bank-logos'), $logoName);
            $validated['logo'] = 'uploads/bank-logos/' . $logoName;
        }

        if ($request->hasFile('banner')) {
            $bannerName = time() . '_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/bank-banners'), $bannerName);
            $validated['banner'] = 'uploads/bank-banners/' . $bannerName;
        }

        $bank->update($validated);

        return redirect()->route('super-admin.banks.index')->with('success', 'Bank updated successfully.');
    }

    /**
     * Remove the specified bank from storage.
     */
    public function destroyBank(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('super-admin.banks.index')->with('success', 'Bank deleted successfully.');
    }

    /**
     * Show the form for creating a new branch.
     */
    public function createBranch()
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.branches.create', compact('banks'));
    }

    /**
     * Store a newly created branch in storage.
     */
    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        Branch::create($validated);

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Display a listing of all branches.
     */
    public function listBranches()
    {
        $branches = Branch::with('bank')->withCount('users')->get();
        return view('super-admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for editing a branch.
     */
    public function editBranch(Branch $branch)
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.branches.edit', compact('branch', 'banks'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function updateBranch(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
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

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroyBranch(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('super-admin.branches.index')->with('success', 'Branch deleted successfully.');
    }

    /**
     * Show the form for creating a new branch admin.
     */
    public function createBranchAdmin()
    {
        $banks = Bank::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        return view('super-admin.branch-admins.create', compact('banks', 'branches'));
    }

    /**
     * Store a newly created branch admin in storage.
     */
    public function storeBranchAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Get the bank_id from the selected branch
        $branch = Branch::findOrFail($validated['branch_id']);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'branch_admin',
            'bank_id' => $branch->bank_id,
            'branch_id' => $validated['branch_id'],
            'is_access' => null,
            'access_mes' => null,
        ]);

        return redirect()->route('super-admin.dashboard')->with('success', 'Branch Admin created successfully.');
    }

    /**
     * Display a listing of all branch admins.
     */
    public function listBranchAdmins(Request $request)
    {
        $filterQuery = User::where('role', 'branch_admin');

        if ($request->has('is_access')) {
            if ($request->input('is_access') === '0') {
                $filterQuery->where(function ($query) {
                    $query->where('is_access', false)
                          ->orWhereNull('is_access');
                });
            } elseif ($request->input('is_access') === '1') {
                $filterQuery->where('is_access', true);
            }
        }

        if ($request->filled('bank_id')) {
            $filterQuery->where('bank_id', $request->input('bank_id'));
        }

        if ($request->filled('district_id')) {
            $filterQuery->where('c_district_id', $request->input('district_id'));
        }

        if ($request->filled('created_from')) {
            $filterQuery->whereDate('created_at', '>=', $request->input('created_from'));
        }

        if ($request->filled('created_to')) {
            $filterQuery->whereDate('created_at', '<=', $request->input('created_to'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $filterQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $branchAdmins = (clone $filterQuery)
            ->with('branch', 'bank')
            ->paginate(10)
            ->appends($request->query());

        $stats = [
            'total' => (clone $filterQuery)->count(),
            'access_granted' => (clone $filterQuery)->where('is_access', true)->count(),
            'no_access' => (clone $filterQuery)->where(function ($query) {
                $query->where('is_access', false)
                      ->orWhereNull('is_access');
            })->count(),
            'inactive' => (clone $filterQuery)->where('is_active', false)->count(),
        ];

        $banks = Bank::where('is_active', true)->orderBy('name')->get();
        $districts = District::orderBy('name')->get();

        return view('super-admin.branch-admins.index', compact('branchAdmins', 'stats', 'banks', 'districts'));
    }

    /**
     * Show the form for editing a branch admin.
     */
    public function editBranchAdmin(User $user)
    {
        $banks = Bank::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        return view('super-admin.branch-admins.edit', compact('user', 'banks', 'branches'));
    }

    /**
     * Display the specified branch admin details.
     */
    public function showBranchAdmin(User $user)
    {
        if (!$user->isBranchAdmin()) {
            abort(404);
        }

        $user->load([
            'bank',
            'branch',
            'bankOfficial',
            'officerDocument',
            'contactDivision',
            'contactDistrict',
            'permanentDivision',
            'permanentDistrict',
        ]);

        if (! $user->view) {
            $user->view = true;
            $user->save();
        }

        return view('super-admin.branch-admins.show', ['admin' => $user]);
    }

    /**
     * Update branch admin access status.
     */
    public function updateBranchAdminAccess(Request $request, User $user)
    {
        if (!$user->isBranchAdmin()) {
            abort(404);
        }

        $validated = $request->validate([
            'is_access' => ['required', 'in:0,1'],
            'access_mes' => 'nullable|required_if:is_access,0|string|max:1000',
        ]);

        $user->is_access = $validated['is_access'] === '1';
        $user->access_mes = $validated['is_access'] === '0' ? $validated['access_mes'] : null;
        $user->save();

        return redirect()->route('super-admin.branch-admins.index', $user)
            ->with('success', 'Branch admin access updated successfully.');
    }

    /**
     * Update the specified branch admin in storage.
     */
    public function updateBranchAdmin(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'bank_id' => 'required|exists:banks,id',
            'is_active' => 'nullable',
            'picture' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'nid' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'office_id' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'visiting_card' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->branch_id = $request->input('branch_id', $user->branch_id);
        $user->bank_id = $validated['bank_id'];
        $user->is_active = $request->boolean('is_active');

        // Only update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $officerDocument = $user->officerDocument;
        $officerDocumentChanged = false;

        foreach (['picture', 'nid', 'office_id', 'visiting_card'] as $field) {
            if ($request->hasFile($field)) {
                if (!$officerDocument) {
                    $officerDocument = new OfficerDocument();
                }

                if ($officerDocument->{$field}) {
                    Storage::disk('public')->delete($officerDocument->{$field});
                }

                $officerDocument->{$field} = $request->file($field)->store('officer_documents', 'public');
                $officerDocumentChanged = true;
            }
        }

        if ($officerDocumentChanged) {
            $officerDocument->save();
            $user->officer_document_id = $officerDocument->id;
        }

        $user->save();

        return redirect()->route('super-admin.branch-admins.index')->with('success', 'Branch Admin updated successfully.');
    }

    /**
     * Display a listing of all loans.
     */
    public function listLoans()
    {
        $loans = Loan::with('branch.bank', 'category')->orderBy('created_at', 'desc')->get();
        return view('super-admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function createLoan()
    {
        $banks = Bank::where('is_active', true)->orderBy('name')->get();
        $branches = Branch::with('bank')->get();
        $categories = LoanCategory::where('is_active', true)->orderBy('name')->get();
        return view('super-admin.loans.create', compact('banks', 'branches', 'categories'));
    }

    /**
     * Display a listing of customers.
     */
    public function listCustomers(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('c_district_id')) {
            $query->where('c_district_id', $request->c_district_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(10);
        $districts = District::orderBy('name')->get();

        return view('super-admin.customers.index', compact('customers', 'districts'));
    }

    /**
     * Display the specified customer details.
     */
    public function showCustomer(User $user)
    {
        if (!$user->isCustomer()) {
            abort(404);
        }

        $user->load(['bank', 'branch', 'contactDivision', 'contactDistrict', 'permanentDivision', 'permanentDistrict', 'customerDocument', 'customerFinancial']);

        return view('super-admin.customers.show', ['customer' => $user]);
    }

    /**
     * Update the specified customer's active status.
     */
    public function updateCustomerStatus(Request $request, User $user)
    {
        if (!$user->isCustomer()) {
            abort(404);
        }

        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->is_active = $validated['is_active'];
        $user->save();

        $statusLabel = $user->is_active ? 'activated' : 'deactivated';

        return redirect()->route('super-admin.customers.show', $user->id)
            ->with('success', "Customer account has been {$statusLabel}.");
    }

    /**
     * Update the customer's uploaded documents.
     */
    public function updateCustomerDocuments(Request $request, User $user)
    {
        if (!$user->isCustomer()) {
            abort(404);
        }

        $validated = $request->validate([
            'picture' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'nid' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'office_id' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'visiting_card' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'pay_slip' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'bank_statements' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'trade_license' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'tin_certificate' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'lend_document' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'other_document' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
        ]);

        $customerDocument = $user->customerDocument ?? new CustomerDocument();
        $updated = false;

        foreach ([
            'picture',
            'nid',
            'office_id',
            'visiting_card',
            'pay_slip',
            'bank_statements',
            'trade_license',
            'tin_certificate',
            'lend_document',
            'other_document',
        ] as $field) {
            if ($request->hasFile($field)) {
                $updated = true;

                if ($customerDocument->$field) {
                    Storage::disk('public')->delete($customerDocument->$field);
                }

                $customerDocument->$field = $request->file($field)->store('customer_documents', 'public');
            }
        }

        if (! $updated) {
            return redirect()->route('super-admin.customers.show', $user->id)
                ->with('info', 'No documents were uploaded.');
        }

        $customerDocument->save();

        $user->customer_document_id = $customerDocument->id;
        $user->save();

        return redirect()->route('super-admin.customers.show', $user->id)
            ->with('success', 'Customer documents updated successfully.');
    }

    /**
     * Display the ratings index for super admin.
     */
    public function ratingsIndex(Request $request)
    {
        $search = trim($request->query('search', ''));
        $searchTarget = $request->query('search_target', '');

        $ratingsQuery = CustomerRating::with(['customer', 'branchAdmin', 'newLoanApplication']);

        if ($search) {
            $like = '%' . $search . '%';

            if ($searchTarget === 'customer') {
                $ratingsQuery->whereHas('customer', function ($query) use ($like) {
                    $query->where('name', 'like', $like)
                          ->orWhere('email', 'like', $like)
                          ->orWhere('phone', 'like', $like);
                });
            } elseif ($searchTarget === 'branch_admin') {
                $ratingsQuery->whereHas('branchAdmin', function ($query) use ($like) {
                    $query->where('name', 'like', $like)
                          ->orWhere('email', 'like', $like)
                          ->orWhere('phone', 'like', $like);
                });
            } else {
                $ratingsQuery->where(function ($query) use ($like) {
                    $query->whereHas('customer', function ($query) use ($like) {
                        $query->where('name', 'like', $like)
                              ->orWhere('email', 'like', $like)
                              ->orWhere('phone', 'like', $like);
                    })->orWhereHas('branchAdmin', function ($query) use ($like) {
                        $query->where('name', 'like', $like)
                              ->orWhere('email', 'like', $like)
                              ->orWhere('phone', 'like', $like);
                    });
                });
            }
        }

        $ratingCount = (clone $ratingsQuery)->count();
        $averageRating = $ratingCount ? (clone $ratingsQuery)->avg('rating') : null;
        $ratings = $ratingsQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('super-admin.ratings.index', compact('ratings', 'ratingCount', 'averageRating', 'search', 'searchTarget'));
    }

    /**
     * Display the bank officer ratings index for super admin.
     */
    public function bankOfficerRatingsIndex(Request $request)
    {
        $search = trim($request->query('search', ''));

        $ratingsQuery = BankOfficerRating::with(['customer', 'officer', 'newLoanApplication']);

        if ($search) {
            $like = '%' . $search . '%';
            $ratingsQuery->where(function ($query) use ($like) {
                $query->whereHas('officer', function ($query) use ($like) {
                    $query->where('name', 'like', $like)
                          ->orWhere('email', 'like', $like)
                          ->orWhere('phone', 'like', $like);
                })->orWhereHas('customer', function ($query) use ($like) {
                    $query->where('name', 'like', $like)
                          ->orWhere('email', 'like', $like)
                          ->orWhere('phone', 'like', $like);
                });
            });
        }

        $ratingCount = (clone $ratingsQuery)->count();
        $averageRating = $ratingCount ? (clone $ratingsQuery)->avg('rating') : null;
        $ratings = $ratingsQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('super-admin.ratings.bank-officer-index', compact('ratings', 'ratingCount', 'averageRating', 'search'));
    }

    /**
     * Show detailed ratings for a specific customer or branch admin.
     */
    public function ratingUserDetails(Request $request, string $type, User $user)
    {
        if ($type === 'customer') {
            abort_if($user->role !== 'customer', 404);
            $ratingsQuery = CustomerRating::with(['branchAdmin', 'newLoanApplication'])->where('customer_id', $user->id);
        } elseif ($type === 'branch_admin') {
            abort_if($user->role !== 'branch_admin', 404);
            $ratingsQuery = CustomerRating::with(['customer', 'newLoanApplication'])->where('branch_admin_id', $user->id);
        } elseif ($type === 'bank_officer') {
            abort_if($user->role !== 'branch_admin', 404);
            $ratingsQuery = BankOfficerRating::with(['customer', 'newLoanApplication'])->where('officer_id', $user->id);
        } else {
            abort(404);
        }

        $ratingCount = (clone $ratingsQuery)->count();
        $averageRating = $ratingCount ? (clone $ratingsQuery)->avg('rating') : null;
        $ratings = $ratingsQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('super-admin.ratings.user-details', compact('type', 'user', 'ratings', 'ratingCount', 'averageRating'));
    }

    /**
     * Reset a customer's password to a default value.
     */
    public function resetCustomerPassword(User $user)
    {
        // ensure we're resetting a customer
        if ($user->role !== 'customer') {
            return back()->withErrors(['error' => 'Only customer accounts can have passwords reset here.']);
        }

        $default = '12345678';
        $user->password = \Illuminate\Support\Facades\Hash::make($default);
        $user->save();

        return back()->with('success', 'Customer password has been reset to the default.');
    }


    /**
     * Display customer messages for admin.
     */
    public function customerMessages()
    {
        $messages = CustomerMessage::orderBy('created_at', 'desc')->paginate(10);
        return view('super-admin.customer_messages.index', compact('messages'));
    }

    /**
     * Show a single customer message.
     */
    public function showCustomerMessage(CustomerMessage $message)
    {
        // mark as read when opened
        if (! $message->is_read) {
            $message->is_read = true;
            $message->save();
        }

        return view('super-admin.customer_messages.show', compact('message'));
    }

    /**
     * Toggle message read status
     */
    public function markMessageRead(Request $request, CustomerMessage $message)
    {
        $message->is_read = ! $message->is_read;
        $message->save();

        return back()->with('success', 'Message status updated.');
    }

    /**
     * Show change password form for super-admin.
     */
    public function editPassword()
    {
        return view('super-admin.change-password');
    }

    /**
     * Update password for authenticated super-admin.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (! \Illuminate\Support\Facades\Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        $user->save();

        return redirect()->route('super-admin.dashboard')->with('success', 'Password updated successfully.');
    }

    /**
     * Store a newly created loan in storage.
     */
    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
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

        $validated['is_active'] = $request->has('is_active');

        Loan::create($validated);

        return redirect()->route('super-admin.loans.index')
            ->with('success', 'Loan created successfully.');
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function editLoan(Loan $loan)
    {
        $branches = Branch::with('bank')->get();
        $categories = LoanCategory::where('is_active', true)->orderBy('name')->get();
        return view('super-admin.loans.edit', compact('loan', 'branches', 'categories'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function updateLoan(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
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

        return redirect()->route('super-admin.loans.index')
            ->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroyLoan(Loan $loan)
    {
        // Delete banner if exists
        if ($loan->banner && file_exists(public_path($loan->banner))) {
            unlink(public_path($loan->banner));
        }

        $loan->delete();

        return redirect()->route('super-admin.loans.index')
            ->with('success', 'Loan deleted successfully.');
    }
}
