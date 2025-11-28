<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FoodListing;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $pendingUsers = User::where('is_approved', false)
                            ->whereIn('role', ['bakery', 'user'])
                            ->get();
        return view('admin.index', compact('pendingUsers'));
    }

    public function approveUser($id)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);
        return back()->with('success', 'User approved successfully!');
    }

    public function deleteUser($id)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function deleteFoodListing($id)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $listing = FoodListing::findOrFail($id);
        if ($listing->image) {
            @unlink(public_path('storage/' . $listing->image));
        }
        $listing->delete();
        return back()->with('success', 'Food listing deleted successfully!');
    }
}