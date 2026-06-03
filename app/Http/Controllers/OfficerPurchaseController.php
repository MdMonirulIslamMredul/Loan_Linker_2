<?php

namespace App\Http\Controllers;

use App\Models\LeadPackage;
use App\Models\PackageOrder;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class OfficerPurchaseController extends Controller
{
    public function gallery()
    {
        $packages = LeadPackage::whereIn('type', ['regular', 'premium'])->orderBy('price')->get();

        return view('branch-admin.packages.gallery', compact('packages'));
    }

    /**
     * Show purchase/payment form for a package
     */
    public function showPurchaseForm(LeadPackage $leadPackage)
    {
        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('branch-admin.packages.purchase', compact('leadPackage', 'paymentMethods'));
    }

    public function purchase(Request $request, LeadPackage $leadPackage)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'txn_number' => 'nullable|string|max:255',
            'phone' => 'required|string|max:30',
            'bank_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:255',
            'screenshot' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($validated['payment_method_id']);

        // Conditional validation: if Bank selected require bank fields, otherwise require txn_number
        if (strtolower($paymentMethod->name) === 'bank') {
            $request->validate([
                'bank_name' => 'required|string|max:255',
                'account_no' => 'required|string|max:255',
            ]);
        } else {
            $request->validate([
                'txn_number' => 'required|string|max:255',
            ]);
        }

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('package-payments', 'public');
        }

        $order = PackageOrder::create([
            'user_id' => $user->id,
            'lead_package_id' => $leadPackage->id,
            'price' => $leadPackage->price,
            'number_of_leads' => $leadPackage->number_of_leads,
            'status' => 'pending',
            'payment_method' => $paymentMethod->name,
            'payment_method_id' => $paymentMethod->id,
            'txn_number' => $request->input('txn_number') ?? null,
            'bank_name' => $request->input('bank_name') ?? null,
            'account_no' => $request->input('account_no') ?? null,
            'phone' => $validated['phone'],
            'screenshot' => $screenshotPath,
        ]);

        return redirect()->route('branch-admin.packages.history')->with('success', 'Package purchase requested. Awaiting admin approval.');
    }

    public function history(Request $request)
    {
        $user = auth()->user();

        $query = PackageOrder::with('leadPackage')
            ->where('user_id', $user->id);

        // Filter by package id (selected by package name in UI)
        if ($request->filled('package_id')) {
            $query->where('lead_package_id', $request->package_id);
        }

        // Date range filters
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $packages = LeadPackage::orderBy('name')->get();

        return view('branch-admin.packages.history', compact('orders', 'packages'));
    }
}
