<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Bank;
use App\Models\BankOfficerRating;
use App\Models\CustomerDocument;
use App\Models\CustomerFinancial;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\Thana;
use App\Models\LeadAccess;
use App\Models\LoanApplication;
use App\Models\NewLoanApplication;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use App\Models\CustomerFinancialLoan;
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

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        // Application stats for dashboard come from lead access statuses.
        $totalApplications = NewLoanApplication::where('customer_id', $user->id)->count();
        $approvedApplications = LeadAccess::whereHas('newLoanApplication', function ($query) use ($user) {
                $query->where('customer_id', $user->id);
            })->where('application_status', 'approved')->distinct()->count('newloan_id');
        $rejectedApplications = LeadAccess::whereHas('newLoanApplication', function ($query) use ($user) {
                $query->where('customer_id', $user->id);
            })->where('application_status', 'rejected')->distinct()->count('newloan_id');
        $pendingApplications = LeadAccess::whereHas('newLoanApplication', function ($query) use ($user) {
                $query->where('customer_id', $user->id);
            })->where('application_status', 'pending')->distinct()->count('newloan_id');
        $reviewApplications = LeadAccess::whereHas('newLoanApplication', function ($query) use ($user) {
                $query->where('customer_id', $user->id);
            })->where('application_status', 'review')->distinct()->count('newloan_id');

        $recentApplications = NewLoanApplication::with(['serviceType', 'leadAccesses'])
            ->withCount('leadAccesses')
            ->where('customer_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('customer.dashboard', compact(
            'user',
            'totalApplications',
            'approvedApplications',
            'rejectedApplications',
            'pendingApplications',
            'reviewApplications',
            'recentApplications'
        ));
    }

    public function createNewApplication()
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $banks = Bank::where('is_active', true)->orderBy('name')->get();
        $serviceCategories = ServiceCategory::with(['serviceTypes' => function ($query) {
            $query->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)->orderBy('name')->get();

        $requiredDocuments = [
            'picture' => 'Picture',
            'nid' => 'NID',
            // 'tin_certificate' => 'TIN Certificate',
            'pay_slip' => 'Pay Slip / Salary Certificate',
        ];

        $customerDocument = $user->customerDocument;
        $missingDocuments = collect($requiredDocuments)
            ->filter(fn ($label, $field) => !$customerDocument || !$customerDocument->{$field})
            ->toArray();

        return view('customer.new-application.create', compact('banks', 'serviceCategories', 'missingDocuments'));
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

        $upazilas = Upazila::orderBy('name')
            ->get()
            ->groupBy('district_id')
            ->map(function ($group) {
                return $group->pluck('name', 'id')->toArray();
            })
            ->toArray();

        $thanas = Thana::orderBy('name')
            ->get()
            ->groupBy('district_id')
            ->map(function ($group) {
                return $group->pluck('name', 'id')->toArray();
            })
            ->toArray();

        $upazilaToDistrict = Upazila::pluck('district_id', 'id')->toArray();

        return [
            'divisions' => $divisions,
            'districts' => $districts,
            'upazilas' => $upazilas,
            'thanas' => $thanas,
            'upazilaToDistrict' => $upazilaToDistrict,
        ];
    }

    /**
     * Show customer profile.
     */
    public function profile()
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $user->load([
            'contactDivision',
            'contactDistrict',
            'contactUpazila',
            'contactThana',
            'permanentDivision',
            'permanentDistrict',
            'permanentUpazila',
            'permanentThana',
        ]);

        return view('customer.profile', compact('user'));
    }

    /**
     * Show edit profile form.
     */
    public function editProfile()
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $locationData = $this->getLocationData();

        return view('customer.edit-profile', [
            'user' => $user,
            'divisions' => $locationData['divisions'],
            'districts' => $locationData['districts'],
            'upazilas' => $locationData['upazilas'],
            'thanas' => $locationData['thanas'],
            'upazilaToDistrict' => $locationData['upazilaToDistrict'],
        ]);
    }

    /**
     * Show change password form.
     */
    public function editPassword()
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
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

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $applications = NewLoanApplication::with(['customer', 'leadAccesses.officer'])
            ->where('customer_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('customer.new-application.index', compact('applications'));
    }

    public function newApplicationOfficerDetails(Request $request, NewLoanApplication $newApplication, User $officer = null)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer() || (int) $newApplication->customer_id !== (int) $user->id) {
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

        $officerIds = $unlocks->pluck('officer_id')->filter()->unique()->values();
        $officerRatingStats = BankOfficerRating::whereIn('officer_id', $officerIds)
            ->get()
            ->groupBy('officer_id')
            ->map(function ($ratings) {
                return [
                    'count' => $ratings->count(),
                    'avg' => $ratings->avg('rating'),
                    'stars' => (int) round($ratings->avg('rating')),
                ];
            });

        return view('customer.new-application.officer_details', compact('newApplication', 'unlocks', 'officer', 'officerRatingStats'));
    }

    public function ratings()
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $unlocks = LeadAccess::with(['newLoanApplication', 'officer.bankOfficial'])
            ->whereHas('newLoanApplication', function ($query) use ($user) {
                $query->where('customer_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->get();

        $givenRatings = BankOfficerRating::with(['newLoanApplication', 'officer'])
            ->where('customer_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $ratingKeys = $givenRatings->mapWithKeys(function ($rating) {
            return [sprintf('%s-%s', $rating->new_loan_application_id, $rating->officer_id) => true];
        });

        $pendingUnlocks = $unlocks->filter(function ($unlock) use ($ratingKeys) {
            return ! isset($ratingKeys[sprintf('%s-%s', $unlock->newloan_id, $unlock->officer_id)]);
        });

        return view('customer.ratings', compact('givenRatings', 'pendingUnlocks'));
    }

    public function storeNewApplication(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $payload = $request->all();
        $payload['bank_ids'] = array_values(array_filter($request->input('bank_ids', [])));

        $requiredDocuments = ['picture', 'nid', 'pay_slip'];
        $customerDocument = $user->customerDocument;

        if (!$customerDocument || collect($requiredDocuments)->contains(fn ($field) => !$customerDocument->{$field})) {
            return back()
                ->withErrors(['documents' => 'Please upload Picture, NID and Pay Slip before applying.'])
                ->withInput();
        }

        $validator = Validator::make($payload, [
            'expected_amount' => ['required', 'numeric', 'min:0'],
            'tenure_months' => ['nullable', 'integer', 'min:1'],
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'service_type_id' => ['required', 'exists:service_types,id'],
            'bank_ids' => ['array', 'max:5'],
            'bank_ids.*' => ['required', Rule::exists('banks', 'id')->where('is_active', true)],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $validator->sometimes('tenure_months', ['required'], function ($input) {
            $category = ServiceCategory::find($input->service_category_id);
            return $category && $category->slug !== 'credit_card';
        });

        $data = $validator->validate();

        $category = ServiceCategory::find($data['service_category_id']);
        $type = ServiceType::find($data['service_type_id']);

        if ($category && $category->slug === 'credit_card') {
            $data['tenure_months'] = null;
        }

        if (!$category || !$type || (int) $type->service_category_id !== (int) $category->id) {
            return back()->withErrors(['service_type_id' => 'The selected service type does not belong to the selected category.'])->withInput();
        }

        $data['service_category'] = $category->slug;
        $data['service_type'] = $type->slug;
        $data['customer_id'] = $user->id;
        $data['status'] = 'active'; // default to active for now, can be changed by admin later

        NewLoanApplication::create($data);

        return redirect()->route('customer.dashboard')->with('success', 'Your loan request has been submitted successfully.');
    }

    public function showNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer() || (int) $newApplication->customer_id !== (int) $user->id) {
            abort(403, 'Unauthorized.');
        }

        $newApplication->load(['customer', 'bankOfficerRatings', 'leadAccesses.officer']);

        $banks = Bank::whereIn('id', $newApplication->bank_ids ?? [])->get()->keyBy('id');

        return view('customer.new-application.show', compact('newApplication', 'banks'));
    }

    public function storeBankOfficerRating(Request $request, NewLoanApplication $newApplication, User $officer)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer() || (int) $newApplication->customer_id !== (int) $user->id) {
            abort(403, 'Unauthorized.');
        }

        $access = $newApplication->leadAccesses()->where('officer_id', $officer->id)->first();
        if (! $access) {
            return redirect()->back()->with('error', 'Officer details are not available for rating.');
        }

        $validated = $request->validate([
            'professionalism' => 'required|integer|min:1|max:5',
            'behavior' => 'required|integer|min:1|max:5',
            'response_time' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $rating = round(($validated['professionalism'] + $validated['behavior'] + $validated['response_time']) / 3, 1);

        BankOfficerRating::updateOrCreate(
            [
                'customer_id' => $user->id,
                'officer_id' => $officer->id,
                'new_loan_application_id' => $newApplication->id,
            ],
            [
                'rating' => $rating,
                'professionalism' => $validated['professionalism'],
                'behavior' => $validated['behavior'],
                'response_time' => $validated['response_time'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return redirect()->back()->with('success', 'Officer rating saved successfully.');
    }

    public function officerRatingHistory(Request $request, NewLoanApplication $newApplication, User $officer)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer() || (int) $newApplication->customer_id !== (int) $user->id) {
            abort(403, 'Unauthorized.');
        }

        $access = $newApplication->leadAccesses()->where('officer_id', $officer->id)->first();
        if (! $access) {
            return redirect()->back()->with('error', 'Officer details are not available.');
        }

        $officerRatings = BankOfficerRating::with(['customer', 'newLoanApplication'])
            ->where('officer_id', $officer->id)
            ->orderByDesc('created_at')
            ->get();

        $ratingCount = $officerRatings->count();
        $averageRating = $ratingCount ? $officerRatings->avg('rating') : null;
        $averageStars = $averageRating ? (int) round($averageRating) : 0;

        return view('customer.new-application.officer_ratings', compact(
            'newApplication',
            'officer',
            'officerRatings',
            'ratingCount',
            'averageRating',
            'averageStars'
        ));
    }

    public function editNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer() || (int) $newApplication->customer_id !== (int) $user->id) {
            abort(403, 'Unauthorized.');
        }

        if (! $newApplication->isEditableByCustomer()) {
            return redirect()->route('customer.applications')->with('error', 'Only applications that are pending or active without unlocks can be edited.');
        }

        $banks = Bank::where('is_active', true)->orderBy('name')->get();
        $serviceCategories = ServiceCategory::with(['serviceTypes' => function ($query) {
            $query->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)->orderBy('name')->get();

        return view('customer.new-application.edit', compact('newApplication', 'banks', 'serviceCategories'));
    }

    public function updateNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer() || (int) $newApplication->customer_id !== (int) $user->id) {
            abort(403, 'Unauthorized.');
        }

        if (! $newApplication->isEditableByCustomer()) {
            return redirect()->route('customer.applications')->with('error', 'Only applications that are pending or active without unlocks can be updated.');
        }

        $payload = $request->all();
        $payload['bank_ids'] = array_values(array_filter($request->input('bank_ids', [])));

        $validator = Validator::make($payload, [
            'expected_amount' => ['required', 'numeric', 'min:0'],
            'tenure_months' => ['nullable', 'integer', 'min:1'],
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'service_type_id' => ['required', 'exists:service_types,id'],
            'bank_ids' => ['array', 'max:5'],
            'bank_ids.*' => ['required', Rule::exists('banks', 'id')->where('is_active', true)],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $validator->sometimes('tenure_months', ['required'], function ($input) {
            $category = ServiceCategory::find($input->service_category_id);
            return $category && $category->slug !== 'credit_card';
        });

        $data = $validator->validate();

        $category = ServiceCategory::find($data['service_category_id']);
        $type = ServiceType::find($data['service_type_id']);

        if ($category && $category->slug === 'credit_card') {
            $data['tenure_months'] = null;
        }

        if (!$category || !$type || (int) $type->service_category_id !== (int) $category->id) {
            return back()->withErrors(['service_type_id' => 'The selected service type does not belong to the selected category.'])->withInput();
        }

        $data['service_category'] = $category->slug;
        $data['service_type'] = $type->slug;

        $newApplication->update($data);

        return redirect()->route('customer.application.show', $newApplication->id)->with('success', 'Application updated successfully.');
    }

    public function deleteNewApplication(Request $request, NewLoanApplication $newApplication)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer() || (int) $newApplication->customer_id !== (int) $user->id) {
            abort(403, 'Unauthorized.');
        }

        if ($newApplication->status !== 'pending') {
            return redirect()->route('customer.applications')->with('error', 'Only pending applications can be deleted.');
        }

        $newApplication->delete();

        return redirect()->route('customer.applications')->with('success', 'Application deleted successfully.');
    }

    /**
     * Update customer profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $locationData = $this->getLocationData();
        $divisions = $locationData['divisions'];
        $districts = $locationData['districts'];
        $thanas = $locationData['thanas'];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.(com)$/i', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'regex:/^01[0-9]{9}$/', Rule::unique('users')->ignore($user->id)],
            'dob' => ['nullable', 'date'],
            'c_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'c_district_id' => ['required', 'integer'],
            'c_thana_id' => ['required', 'integer'],
            'contact_address' => ['nullable', 'string', 'max:1000'],
            'p_division_id' => ['required', 'integer', Rule::in(array_keys($divisions))],
            'p_district_id' => ['required', 'integer'],
            'p_thana_id' => ['required', 'integer'],
            'permanent_address' => ['nullable', 'string', 'max:1000'],
            'education' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'date_of_joining' => ['nullable', 'date'],
            'total_working_experience' => ['nullable', 'string', 'max:100'],
        ]);

        if (! isset($districts[$data['c_division_id']][$data['c_district_id']])) {
            return back()->withErrors(['c_district_id' => 'The selected contact district does not belong to the selected division.'])->withInput();
        }

        if (! isset($districts[$data['p_division_id']][$data['p_district_id']])) {
            return back()->withErrors(['p_district_id' => 'The selected permanent district does not belong to the selected division.'])->withInput();
        }

        if (! isset($thanas[$data['c_district_id']][$data['c_thana_id']])) {
            return back()->withErrors(['c_thana_id' => 'The selected contact thana does not belong to the selected district.'])->withInput();
        }

        if (! isset($thanas[$data['p_district_id']][$data['p_thana_id']])) {
            return back()->withErrors(['p_thana_id' => 'The selected permanent thana does not belong to the selected district.'])->withInput();
        }

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

        if (!$user || !$user->isCustomer()) {
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

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $customerDocument = $user->customerDocument;

        return view('customer.documents', compact('customerDocument'));
    }

    public function storeDocuments(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
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
            'tin_certificate' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'lend_document' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
            'other_document' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,svg,pdf', 'max:5120'],
        ]);

        $customerDocument = $user->customerDocument ?? new CustomerDocument();

        $documentFields = [
            'picture' => 'Picture',
            'nid' => 'NID',
            'office_id' => 'Office ID',
            'visiting_card' => 'Visiting Card',
            'pay_slip' => 'Pay Slip / Salary Certificate',
            'bank_statements' => 'Bank Statements',
            'trade_license' => 'Trade License (for Business Loan)',
            'tin_certificate' => 'e-TIN Certificate',
            'lend_document' => 'Lend Document (for Home Loan)',
            'other_document' => 'Other Document',
        ];

        foreach ($documentFields as $field => $label) {
            if ($request->hasFile($field) && $customerDocument->$field) {
                return back()
                    ->withErrors([
                        $field => "The {$label} has already been uploaded and cannot be changed. Please contact admin to update this document.",
                    ])
                    ->withInput();
            }
        }

        foreach (array_keys($documentFields) as $field) {
            if ($request->hasFile($field) && !$customerDocument->$field) {
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

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $customerFinancial = $user->customerFinancial;
        $banks = Bank::where('is_active', true)->get();
        $serviceCategories = ServiceCategory::where('is_active', true)->get();
        $serviceTypes = ServiceType::where('is_active', true)->get();

        return view('customer.financial', compact('customerFinancial', 'banks', 'serviceCategories', 'serviceTypes'));
    }

    public function storeFinancial(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $validator = Validator::make($request->all(), [
            'salary_bank_id' => ['nullable', 'exists:banks,id'],
            'salary_by_bank' => ['nullable', 'numeric'],
            'salary_by_hand' => ['nullable', 'numeric'],
            'monthly_bank_transaction' => ['nullable', 'numeric'],
            'has_loan' => ['nullable', 'boolean'],
            'existing_loans_credit_cards' => ['nullable', 'string', 'max:2000'],
        ]);

        $data = $validator->validate();

        $customerFinancial = $user->customerFinancial ?? new CustomerFinancial();
        $customerFinancial->fill($data);
        $customerFinancial->save();

        if (empty($data['has_loan'])) {
            $customerFinancial->loans()->delete();
        }

        $user->customer_financial_id = $customerFinancial->id;
        $user->save();

        return redirect()->route('customer.financial')->with('success', 'Financial information saved successfully.');
    }

    public function updateHasLoan(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $validator = Validator::make($request->all(), [
            'has_loan' => ['required', 'boolean'],
        ]);

        $data = $validator->validate();

        $customerFinancial = $user->customerFinancial ?? new CustomerFinancial();
        $customerFinancial->has_loan = $data['has_loan'];
        $customerFinancial->save();

        if (empty($data['has_loan'])) {
            $customerFinancial->loans()->delete();
        }

        $user->customer_financial_id = $customerFinancial->id;
        $user->save();

        return response()->json([
            'success' => true,
            'has_loan' => (bool) $customerFinancial->has_loan,
        ]);
    }

    public function createFinancialLoan()
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $customerFinancial = $user->customerFinancial;
        $banks = Bank::where('is_active', true)->get();
        $serviceCategories = ServiceCategory::where('is_active', true)->get();
        $serviceTypes = ServiceType::where('is_active', true)->get();

        return view('customer.financial-loan-form', compact('customerFinancial', 'banks', 'serviceCategories', 'serviceTypes'));
    }

    public function storeFinancialLoan(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        $validator = Validator::make($request->all(), [
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'service_type_id' => ['required', 'exists:service_types,id'],
            'bank_id' => ['nullable', 'exists:banks,id'],
            'loan_amount' => ['required', 'numeric', 'min:0'],
            'tenure_months' => ['nullable', 'integer', 'min:1'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if ((int) $request->input('service_category_id') !== 1 && empty($request->input('tenure_months'))) {
                $validator->errors()->add('tenure_months', 'The tenure months field is required for non-credit-card loans.');
            }
        });

        $data = $validator->validate();

        $customerFinancial = $user->customerFinancial;

        if (!$customerFinancial) {
            $customerFinancial = new CustomerFinancial();
            $customerFinancial->has_loan = true;
            $customerFinancial->save();

            $user->customer_financial_id = $customerFinancial->id;
            $user->save();
        } else {
            $customerFinancial->has_loan = true;
            $customerFinancial->save();
        }

        $customerFinancial->loans()->create([
            'service_category_id' => $data['service_category_id'],
            'service_type_id' => $data['service_type_id'],
            'bank_id' => $data['bank_id'] ?? null,
            'loan_amount' => $data['loan_amount'],
            'tenure_months' => $data['tenure_months'] ?? null,
        ]);

        return redirect()->route('customer.financial')->with('success', 'Loan information added successfully.');
    }

    public function editFinancialLoan(CustomerFinancialLoan $loan)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        if ($loan->customer_financial_id !== ($user->customerFinancial?->id ?? null)) {
            abort(403, 'Unauthorized.');
        }

        $banks = Bank::where('is_active', true)->get();
        $serviceCategories = ServiceCategory::where('is_active', true)->get();
        $serviceTypes = ServiceType::where('is_active', true)->get();

        return view('customer.financial-loan-form', compact('loan', 'banks', 'serviceCategories', 'serviceTypes'));
    }

    public function updateFinancialLoan(Request $request, CustomerFinancialLoan $loan)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        if ($loan->customer_financial_id !== ($user->customerFinancial?->id ?? null)) {
            abort(403, 'Unauthorized.');
        }

        $validator = Validator::make($request->all(), [
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'service_type_id' => ['required', 'exists:service_types,id'],
            'bank_id' => ['nullable', 'exists:banks,id'],
            'loan_amount' => ['required', 'numeric', 'min:0'],
            'tenure_months' => ['nullable', 'integer', 'min:1'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if ((int) $request->input('service_category_id') !== 1 && empty($request->input('tenure_months'))) {
                $validator->errors()->add('tenure_months', 'The tenure months field is required for non-credit-card loans.');
            }
        });

        $data = $validator->validate();

        $loan->update([
            'service_category_id' => $data['service_category_id'],
            'service_type_id' => $data['service_type_id'],
            'bank_id' => $data['bank_id'] ?? null,
            'loan_amount' => $data['loan_amount'],
            'tenure_months' => $data['tenure_months'] ?? null,
        ]);

        return redirect()->route('customer.financial')->with('success', 'Loan information updated successfully.');
    }

    public function destroyFinancialLoan(CustomerFinancialLoan $loan)
    {
        $user = auth()->user();

        if (!$user || !$user->isCustomer()) {
            abort(403, 'Unauthorized.');
        }

        if ($loan->customer_financial_id !== ($user->customerFinancial?->id ?? null)) {
            abort(403, 'Unauthorized.');
        }

        $loan->delete();

        return redirect()->route('customer.financial')->with('success', 'Loan removed successfully.');
    }
}
