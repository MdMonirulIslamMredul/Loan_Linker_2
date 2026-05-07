<?php

namespace App\Http\Controllers;

use App\Models\HomepageCarousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageCarouselController extends Controller
{
    public function index()
    {
        $carousels = HomepageCarousel::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('super-admin.homepage-carousels.index', compact('carousels'));
    }

    public function create()
    {
        return view('super-admin.homepage-carousels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:1000',
            'button_name' => 'nullable|string|max:255',
            'button_url' => 'nullable|url|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('homepage_carousels', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        HomepageCarousel::create($validated);

        return redirect()->route('super-admin.homepage-carousels.index')
            ->with('success', 'Homepage carousel item created successfully.');
    }

    public function edit(HomepageCarousel $homepageCarousel)
    {
        return view('super-admin.homepage-carousels.edit', compact('homepageCarousel'));
    }

    public function update(Request $request, HomepageCarousel $homepageCarousel)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:1000',
            'button_name' => 'nullable|string|max:255',
            'button_url' => 'nullable|url|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($homepageCarousel->image && Storage::disk('public')->exists($homepageCarousel->image)) {
                Storage::disk('public')->delete($homepageCarousel->image);
            }
            $validated['image'] = $request->file('image')->store('homepage_carousels', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $homepageCarousel->update($validated);

        return redirect()->route('super-admin.homepage-carousels.index')
            ->with('success', 'Homepage carousel item updated successfully.');
    }

    public function destroy(HomepageCarousel $homepageCarousel)
    {
        if ($homepageCarousel->image && Storage::disk('public')->exists($homepageCarousel->image)) {
            Storage::disk('public')->delete($homepageCarousel->image);
        }

        $homepageCarousel->delete();

        return redirect()->route('super-admin.homepage-carousels.index')
            ->with('success', 'Homepage carousel item deleted successfully.');
    }
}
