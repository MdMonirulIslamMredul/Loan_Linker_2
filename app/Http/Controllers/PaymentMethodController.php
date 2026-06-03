<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('name')->paginate(10);
        return view('super-admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('super-admin.payment-methods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('payment-methods', 'public');
        }

        PaymentMethod::create($validated);

        return redirect()->route('super-admin.payment-methods.index')
            ->with('success', 'Payment method added successfully.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('super-admin.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('payment-methods', 'public');
        }

        $paymentMethod->update($validated);

        return redirect()->route('super-admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('super-admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
