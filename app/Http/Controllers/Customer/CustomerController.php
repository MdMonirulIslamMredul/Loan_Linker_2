<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Bank;
use App\Models\CustomerDocument;
use App\Models\CustomerFinancial;
use App\Models\LoanApplication;
use App\Models\NewLoanApplication;
use App\Models\User;

class CustomerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        // Application stats for dashboard
        $totalApplications = NewLoanApplication::where('customer_id', $user->id)->count();
        $approvedApplications = NewLoanApplication::where('customer_id', $user->id)->where('status', 'approved')->count();
        $rejectedApplications = NewLoanApplication::where('customer_id', $user->id)->where('status', 'rejected')->count();
        $pendingApplications = NewLoanApplication::where('customer_id', $user->id)->whereIn('status', ['pending', 'review'])->count();

        $recentApplications = NewLoanApplication::where('customer_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact(
            'user',
            'totalApplications',
            'approvedApplications',
            'rejectedApplications',
            'pendingApplications',
            'recentApplications'
        ));
    }

    public function createNewApplication()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $banks = Bank::orderBy('name')->get();

        return view('customer.new-application.create', compact('banks'));
    }

    /**
     * Show customer profile.
     */
    public function profile()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        return view('customer.profile', compact('user'));
    }

    /**
     * Show edit profile form.
     */
    public function editProfile()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        return view('customer.edit-profile', compact('user'));
    }

    /**
     * Show change password form.
     */
    public function editPassword()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        return view('customer.change-password', compact('user'));
    }

    /**
     * List customer's new loan requests.
     */
    public function applications(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $applications = NewLoanApplication::with(['customer', 'leadAccesses.officer'])
            ->where('customer_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('customer.new-application.index', compact('applications'));
    }

    public function newApplicationOfficerDetails(Request $request, NewLoanApplication $newApplication, User $officer = null)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer' || $newApplication->customer_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $query = $newApplication->leadAccesses()->with(['officer.bankOfficial', 'officer.officerDocument']);

        if ($officer) {
            $query->where('officer_id', $officer->id);
        }

        $unlocks = $query->get();

        if ($unlocks->isEmpty()) {
            return redirect()->route('customer.applications')
                ->with('error', 'No officer details found.');
        }

        return view('customer.new-application.officer_details', compact('newApplication', 'unlocks', 'officer'));
    }

    public function storeNewApplication(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $payload = $request->all();
        $payload['bank_ids'] = array_values(array_filter($request->input('bank_ids', [])));

        $data = Validator::make($payload, [
            'expected_amount' => ['required', 'numeric', 'min:0'],
            'tenure_months' => ['required', 'integer', 'min:1'],
            'service_category' => ['required', 'in:credit_card,loan'],
            'service_type' => ['required', 'in:visa_credit_card,personal_loan'],
            'bank_ids' => ['required', 'array', 'min:1', 'max:5'],
            'bank_ids.*' => ['required', 'exists:banks,id'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ])->validate();

        $data['customer_id'] = $user->id;
        $data['status'] = 'pending';

        NewLoanApplication::create($data);

        return redirect()->route('customer.dashboard')->with('success', 'Your loan request has been submitted successfully.');
    }

    public function showNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer' || $newApplication->customer_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $banks = Bank::whereIn('id', $newApplication->bank_ids ?? [])->get()->keyBy('id');

        return view('customer.new-application.show', compact('newApplication', 'banks'));
    }

    public function editNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer' || $newApplication->customer_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        if ($newApplication->status !== 'pending') {
            return redirect()->route('customer.applications')->with('error', 'Only pending applications can be edited.');
        }

        $banks = Bank::orderBy('name')->get();

        return view('customer.new-application.edit', compact('newApplication', 'banks'));
    }

    public function updateNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer' || $newApplication->customer_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        if ($newApplication->status !== 'pending') {
            return redirect()->route('customer.applications')->with('error', 'Only pending applications can be updated.');
        }

        $payload = $request->all();
        $payload['bank_ids'] = array_values(array_filter($request->input('bank_ids', [])));

        $data = Validator::make($payload, [
            'expected_amount' => ['required', 'numeric', 'min:0'],
            'tenure_months' => ['required', 'integer', 'min:1'],
            'service_category' => ['required', 'in:credit_card,loan'],
            'service_type' => ['required', 'in:visa_credit_card,personal_loan'],
            'bank_ids' => ['required', 'array', 'min:1', 'max:5'],
            'bank_ids.*' => ['required', 'exists:banks,id'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ])->validate();

        $newApplication->update($data);

        return redirect()->route('customer.application.show', $newApplication->id)->with('success', 'Application updated successfully.');
    }

    public function deleteNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer' || $newApplication->customer_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        if ($newApplication->status !== 'pending') {
            return redirect()->route('customer.applications')->with('error', 'Only pending applications can be deleted.');
        }

        $newApplication->delete();

        return redirect()->route('customer.applications')->with('success', 'Application deleted successfully.');
    }

    /**
     * Update customer profile (name, email, phone).
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $user->fill($data);
        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Change customer password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Password changed successfully.');
    }

    public function documents()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $customerDocument = $user->customerDocument;

        return view('customer.documents', compact('customerDocument'));
    }

    public function storeDocuments(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $data = $request->validate([
            'picture' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'nid' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'office_id' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'visiting_card' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'pay_slip' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'bank_statements' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'trade_license' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'lend_document' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'other_document' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
        ]);

        $customerDocument = $user->customerDocument ?? new CustomerDocument();

        foreach ([
            'picture',
            'nid',
            'office_id',
            'visiting_card',
            'pay_slip',
            'bank_statements',
            'trade_license',
            'lend_document',
            'other_document',
        ] as $field) {
            if ($request->hasFile($field)) {
                if ($customerDocument->$field) {
                    Storage::disk('public')->delete($customerDocument->$field);
                }

                $customerDocument->$field = $request->file($field)->store('customer_documents', 'public');
            }
        }

        $customerDocument->save();

        $user->customer_document_id = $customerDocument->id;
        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Documents uploaded successfully.');
    }

    public function financial()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $customerFinancial = $user->customerFinancial;

        return view('customer.financial', compact('customerFinancial'));
    }

    public function storeFinancial(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $data = $request->validate([
            'salary_by_bank' => ['nullable', 'numeric'],
            'salary_by_hand' => ['nullable', 'numeric'],
            'monthly_bank_transaction' => ['nullable', 'numeric'],
            'existing_loans_credit_cards' => ['nullable', 'string', 'max:2000'],
        ]);

        $customerFinancial = $user->customerFinancial ?? new CustomerFinancial();
        $customerFinancial->fill($data);
        $customerFinancial->save();

        $user->customer_financial_id = $customerFinancial->id;
        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Financial information saved successfully.');
    }
}
