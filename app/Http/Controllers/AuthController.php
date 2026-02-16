<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

   public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:bakery,user',
        'bakery_name' => 'required_if:role,bakery',
        'address' => 'required_if:role,bakery',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'bakery_name' => $request->bakery_name,
        'address' => $request->address,
        'is_approved' => false,
    ]);

    return redirect()->route('login')->with('success', 'Registracija uspešna! Sačekajte odobrenje administratora.');
}
    
    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        if (!$user->is_approved && $user->role !== 'guest') {
            Auth::logout();
            return back()->withErrors(['email' => 'Vaš nalog još uvek nije odobren.']);
        }

        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Uneti podaci se ne poklapaju sa našim zapisima.',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}