<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::orderBy('id')->paginate(10);
        return view('super-admin.service-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('super-admin.service-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name',
            'slug' => 'nullable|string|max:255|unique:service_categories,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name'], '_');
        $validated['is_active'] = $request->has('is_active');

        ServiceCategory::create($validated);

        return Redirect::route('super-admin.service-categories.index')
            ->with('success', 'Service category created successfully.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('super-admin.service-categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name,' . $serviceCategory->id,
            'slug' => 'nullable|string|max:255|unique:service_categories,slug,' . $serviceCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name'], '_');
        $validated['is_active'] = $request->has('is_active');

        $serviceCategory->update($validated);

        return Redirect::route('super-admin.service-categories.index')
            ->with('success', 'Service category updated successfully.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        if ($serviceCategory->serviceTypes()->count() > 0) {
            return Redirect::route('super-admin.service-categories.index')
                ->with('error', 'Cannot delete service category with associated service types.');
        }

        $serviceCategory->delete();

        return Redirect::route('super-admin.service-categories.index')
            ->with('success', 'Service category deleted successfully.');
    }
}
