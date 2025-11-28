<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\FoodListing;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->user()->isUser()) {
            abort(403);
        }

        $request->validate([
            'food_listing_id' => 'required|exists:food_listings,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $listing = FoodListing::findOrFail($request->food_listing_id);

        if ($listing->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough quantity available.']);
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'food_listing_id' => $request->food_listing_id,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        $listing->decrement('quantity', $request->quantity);

        if ($listing->quantity == 0) {
            $listing->update(['is_available' => false]);
        }

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully!');
    }

    public function index()
    {
        if (!auth()->user()->isUser()) {
            abort(403);
        }

        $reservations = Reservation::where('user_id', auth()->id())
                                  ->with('foodListing')
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        return view('reservations.index', compact('reservations'));
    }

    public function bakeryReservations()
    {
        if (!auth()->user()->isBakery()) {
            abort(403);
        }

        $reservations = Reservation::whereHas('foodListing', function($query) {
            $query->where('user_id', auth()->id());
        })->with(['foodListing', 'user'])
          ->orderBy('created_at', 'desc')
          ->get();

        return view('reservations.bakery', compact('reservations'));
    }

    public function complete($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if (!auth()->user()->isBakery()) {
            abort(403);
        }

        if ($reservation->foodListing->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->update(['status' => 'completed']);

        return back()->with('success', 'Reservation marked as completed!');
    }
}