<?php

namespace App\Http\Controllers;

use App\Models\FoodListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodListingController extends Controller
{
    public function index()
{
    // Delete expired listings (older than 2 days)
    FoodListing::where('created_at', '<', now()->subDays(2))->delete();

    $listings = FoodListing::where('is_available', true)
                          ->where('quantity', '>', 0)
                          ->orderBy('created_at', 'desc')
                          ->get();
    return view('food.index', compact('listings'));
}

    public function myListings()
    {
        if (!auth()->user()->isBakery()) {
            abort(403);
        }

        $listings = FoodListing::where('user_id', auth()->id())
                              ->orderBy('created_at', 'desc')
                              ->get();
        return view('food.my-listings', compact('listings'));
    }

    public function create()
    {
        if (!auth()->user()->isBakery()) {
            abort(403);
        }
        return view('food.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isBakery()) {
            abort(403);
        }

        $request->validate([
            'food_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pickup_address' => 'required|string|max:500',
            'quantity' => 'required|integer|min:1',
            'made_at' => 'required|date',
            'ingredients' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('food_images', 'public');
        }

        FoodListing::create([
            'user_id' => auth()->id(),
            'food_name' => $request->food_name,
            'image' => $imagePath,
            'bakery_name' => auth()->user()->bakery_name,
            'pickup_address' => $request->pickup_address,
            'quantity' => $request->quantity,
            'original_quantity' => $request->quantity,
            'made_at' => $request->made_at,
            'ingredients' => $request->ingredients,
        ]);

        return redirect()->route('food.my-listings')->with('success', 'Food listing created successfully!');
    }

    public function edit($id)
    {
        $listing = FoodListing::findOrFail($id);
        
        if (!auth()->user()->isBakery() || $listing->user_id !== auth()->id()) {
            abort(403);
        }

        return view('food.edit', compact('listing'));
    }

    public function update(Request $request, $id)
{
    $listing = FoodListing::findOrFail($id);
    
    if (!auth()->user()->isBakery() || $listing->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'quantity' => 'required|integer|min:0',
        'is_available' => 'required|boolean',
    ]);

    $listing->update([
        'quantity' => $request->quantity,
        'is_available' => $request->is_available,
    ]);

    // If quantity is 0, automatically set to not available
    if ($request->quantity == 0) {
        $listing->update(['is_available' => false]);
    }

    return redirect()->route('food.my-listings')->with('success', 'Food listing updated successfully!');
}

    public function destroy($id)
    {
        $listing = FoodListing::findOrFail($id);
        
        if (!auth()->user()->isBakery() || $listing->user_id !== auth()->id()) {
            abort(403);
        }

        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }

        $listing->delete();

        return redirect()->route('food.my-listings')->with('success', 'Food listing deleted successfully!');
    }
}