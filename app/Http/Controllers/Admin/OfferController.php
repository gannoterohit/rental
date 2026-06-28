<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::latest()->get();
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_text' => 'nullable|string|max:50',
            'target_audience' => 'required|in:user,owner,both',
            'banner_color' => 'required|string|max:7',
            'placement' => 'required|string|in:top_nav,home_hero,dashboard,sidebar,popup',
            'type' => 'required|string|in:text_only,image_only,both',
            'link_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('offers', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Offer::create($validated);

        return redirect()->route('admin.offers.index')->with('success', 'Offer created successfully!');
    }

    public function edit(Offer $offer)
    {
        return view('admin.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_text' => 'nullable|string|max:50',
            'target_audience' => 'required|in:user,owner,both',
            'banner_color' => 'required|string|max:7',
            'placement' => 'required|string|in:top_nav,home_hero,dashboard,sidebar,popup',
            'type' => 'required|string|in:text_only,image_only,both',
            'link_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($offer->image_path) {
                Storage::disk('public')->delete($offer->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('offers', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $offer->update($validated);

        return redirect()->route('admin.offers.index')->with('success', 'Offer updated successfully!');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->image_path) {
            Storage::disk('public')->delete($offer->image_path);
        }
        $offer->delete();
        return redirect()->route('admin.offers.index')->with('success', 'Offer deleted successfully!');
    }

    public function toggleActive(Offer $offer)
    {
        $offer->update(['is_active' => !$offer->is_active]);
        return back()->with('success', 'Offer status updated!');
    }
}
