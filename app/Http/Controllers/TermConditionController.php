<?php

namespace App\Http\Controllers;

use App\Models\TermCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermConditionController extends Controller
{
    public function index()
    {
        $terms = TermCondition::orderByDesc('updated_at')->paginate(10);

        return view('super-admin.terms-conditions.index', compact('terms'));
    }

    public function create()
    {
        return view('super-admin.terms-conditions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        DB::transaction(function () use ($data) {
            if ($data['is_active']) {
                TermCondition::where('is_active', true)->update(['is_active' => false]);
            }

            TermCondition::create($data);
        });

        return redirect()->route('super-admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions entry created successfully.');
    }

    public function edit(TermCondition $termsCondition)
    {
        return view('super-admin.terms-conditions.edit', compact('termsCondition'));
    }

    public function update(Request $request, TermCondition $termsCondition)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        DB::transaction(function () use ($termsCondition, $data) {
            if ($data['is_active']) {
                TermCondition::where('is_active', true)
                    ->where('id', '!=', $termsCondition->id)
                    ->update(['is_active' => false]);
            }

            $termsCondition->update($data);
        });

        return redirect()->route('super-admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions entry updated successfully.');
    }

    public function destroy(TermCondition $termsCondition)
    {
        $termsCondition->delete();

        return redirect()->route('super-admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions entry deleted successfully.');
    }

    public function show()
    {
        $terms = TermCondition::where('is_active', true)->latest()->first();

        return view('terms', compact('terms'));
    }
}
