<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\LoanApplication;
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
        $totalApplications = LoanApplication::where('customer_id', $user->id)->count();
        $approvedApplications = LoanApplication::where('customer_id', $user->id)->where('status', 'approved')->count();
        $rejectedApplications = LoanApplication::where('customer_id', $user->id)->where('status', 'rejected')->count();
        $pendingApplications = LoanApplication::where('customer_id', $user->id)->whereIn('status', ['pending', 'under_review'])->count();

        $recentApplications = LoanApplication::with(['loan.branch.bank'])
            ->where('customer_id', $user->id)
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
     * List customer's loan applications.
     */
    public function applications(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $applications = LoanApplication::with(['loan.branch.bank'])
            ->where('customer_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('customer.applications', compact('applications'));
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
}
