<?php

namespace App\Http\Controllers;

use App\Models\LoanCategory;
use Illuminate\Http\Request;

class LoanCategoryController extends Controller
{
    /**
     * Display a listing of loan categories.
     */
    public function index()
    {
        $categories = LoanCategory::orderBy('id')->paginate(10);
        return view('super-admin.loan-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new loan category.
     */
    public function create()
    {
        return view('super-admin.loan-categories.create');
    }

    /**
     * Store a newly created loan category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:loan_categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        LoanCategory::create($validated);

        return redirect()->route('super-admin.loan-categories.index')
            ->with('success', 'Loan category created successfully.');
    }

    /**
     * Show the form for editing the specified loan category.
     */
    public function edit(LoanCategory $loanCategory)
    {
        return view('super-admin.loan-categories.edit', compact('loanCategory'));
    }

    /**
     * Update the specified loan category in storage.
     */
    public function update(Request $request, LoanCategory $loanCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:loan_categories,name,' . $loanCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $loanCategory->update($validated);

        return redirect()->route('super-admin.loan-categories.index')
            ->with('success', 'Loan category updated successfully.');
    }

    /**
     * Remove the specified loan category from storage.
     */
    public function destroy(LoanCategory $loanCategory)
    {
        // Check if the category has any loans associated
        if ($loanCategory->loans()->count() > 0) {
            return redirect()->route('super-admin.loan-categories.index')
                ->with('error', 'Cannot delete category with associated loans.');
        }

        $loanCategory->delete();

        return redirect()->route('super-admin.loan-categories.index')
            ->with('success', 'Loan category deleted successfully.');
    }
}
