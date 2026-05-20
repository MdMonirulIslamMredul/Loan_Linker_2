<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $types = ServiceType::with('serviceCategory')->orderBy('id')->paginate(10);
        return view('super-admin.service-types.index', compact('types'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('name')->get();
        return view('super-admin.service-types.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_types')->where(function ($query) use ($request) {
                    return $query->where('service_category_id', $request->service_category_id);
                }),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('service_types')->where(function ($query) use ($request) {
                    return $query->where('service_category_id', $request->service_category_id);
                }),
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name'], '_');
        $validated['is_active'] = $request->has('is_active');

        ServiceType::create($validated);

        return Redirect::route('super-admin.service-types.index')
            ->with('success', 'Service type created successfully.');
    }

    public function edit(ServiceType $serviceType)
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('name')->get();
        return view('super-admin.service-types.edit', compact('serviceType', 'categories'));
    }

    public function update(Request $request, ServiceType $serviceType)
    {
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_types')->ignore($serviceType->id)->where(function ($query) use ($request) {
                    return $query->where('service_category_id', $request->service_category_id);
                }),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('service_types')->ignore($serviceType->id)->where(function ($query) use ($request) {
                    return $query->where('service_category_id', $request->service_category_id);
                }),
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name'], '_');
        $validated['is_active'] = $request->has('is_active');

        $serviceType->update($validated);

        return Redirect::route('super-admin.service-types.index')
            ->with('success', 'Service type updated successfully.');
    }

    public function destroy(ServiceType $serviceType)
    {
        if ($serviceType->newLoanApplications()->count() > 0) {
            return Redirect::route('super-admin.service-types.index')
                ->with('error', 'Cannot delete service type with associated applications.');
        }

        $serviceType->delete();

        return Redirect::route('super-admin.service-types.index')
            ->with('success', 'Service type deleted successfully.');
    }
}
