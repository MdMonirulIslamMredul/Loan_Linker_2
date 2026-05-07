<?php

namespace App\Http\Controllers;

use App\Models\ImageAdvertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageAdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = ImageAdvertisement::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('super-admin.image-advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('super-admin.image-advertisements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'link_url' => 'nullable|url|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('image_advertisements', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        ImageAdvertisement::create($validated);

        return redirect()->route('super-admin.image-advertisements.index')
            ->with('success', 'Image advertisement created successfully.');
    }

    public function edit(ImageAdvertisement $imageAdvertisement)
    {
        return view('super-admin.image-advertisements.edit', compact('imageAdvertisement'));
    }

    public function update(Request $request, ImageAdvertisement $imageAdvertisement)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'link_url' => 'nullable|url|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($imageAdvertisement->image && Storage::disk('public')->exists($imageAdvertisement->image)) {
                Storage::disk('public')->delete($imageAdvertisement->image);
            }
            $validated['image'] = $request->file('image')->store('image_advertisements', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $imageAdvertisement->update($validated);

        return redirect()->route('super-admin.image-advertisements.index')
            ->with('success', 'Image advertisement updated successfully.');
    }

    public function destroy(ImageAdvertisement $imageAdvertisement)
    {
        if ($imageAdvertisement->image && Storage::disk('public')->exists($imageAdvertisement->image)) {
            Storage::disk('public')->delete($imageAdvertisement->image);
        }

        $imageAdvertisement->delete();

        return redirect()->route('super-admin.image-advertisements.index')
            ->with('success', 'Image advertisement deleted successfully.');
    }
}
