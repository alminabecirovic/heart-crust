<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Reservation;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with(['user', 'reservation.foodListing'])
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('surveys.index', compact('surveys'));
    }

    public function create($reservationId)
    {
        if (!auth()->user()->isUser()) {
            abort(403);
        }

        $reservation = Reservation::findOrFail($reservationId);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->status !== 'completed') {
            return back()->withErrors(['error' => 'You can only survey completed reservations.']);
        }

        if ($reservation->survey) {
            return back()->withErrors(['error' => 'You have already submitted a survey for this reservation.']);
        }

        return view('surveys.create', compact('reservation'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isUser()) {
            abort(403);
        }

        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'food_quality' => 'required|in:good,bad',
            'staff_friendliness' => 'required|in:friendly,unfriendly',
            'comment' => 'nullable|string|max:1000',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->survey) {
            return back()->withErrors(['error' => 'You have already submitted a survey for this reservation.']);
        }

        Survey::create([
            'user_id' => auth()->id(),
            'reservation_id' => $request->reservation_id,
            'food_quality' => $request->food_quality,
            'staff_friendliness' => $request->staff_friendliness,
            'comment' => $request->comment,
        ]);

        return redirect()->route('surveys.index')->with('success', 'Survey submitted successfully!');
    }
}