<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FoodListingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Public routes (NO login required)
Route::get('/', [FoodListingController::class, 'index'])->name('home');
Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');

// Auth routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (login required)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/approve-user/{id}', [AdminController::class, 'approveUser'])->name('approve-user');
        Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');
        Route::delete('/delete-listing/{id}', [AdminController::class, 'deleteFoodListing'])->name('delete-listing');
    });

    // Bakery routes
    Route::prefix('food')->name('food.')->group(function () {
        Route::get('/my-listings', [FoodListingController::class, 'myListings'])->name('my-listings');
        Route::get('/create', [FoodListingController::class, 'create'])->name('create');
        Route::post('/', [FoodListingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [FoodListingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FoodListingController::class, 'update'])->name('update');
        Route::delete('/{id}', [FoodListingController::class, 'destroy'])->name('destroy');
    });

    // User reservation routes
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::post('/', [ReservationController::class, 'store'])->name('store');
        Route::get('/bakery', [ReservationController::class, 'bakeryReservations'])->name('bakery');
        Route::post('/{id}/complete', [ReservationController::class, 'complete'])->name('complete');
    });

    // Survey routes
    Route::prefix('surveys')->name('surveys.')->group(function () {
        Route::get('/create/{reservationId}', [SurveyController::class, 'create'])->name('create');
        Route::post('/', [SurveyController::class, 'store'])->name('store');
    });
});

// --- PRIVREMENA RUTA ZA DIJAGNOSTIKU (OBRISATI NAKON FIX-A) ---
Route::get('/debug-login', function () {
    $email = 'admin@primer.com';
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return "Korisnik sa emailom {$email} nije pronadjen u bazi.";
    }

    // Proveravamo da li rec 'password' odgovara hešu koji je trenutno u bazi
    $check = Hash::check('password', $user->password);
    
    return [
        'info' => 'Dijagnostika logina',
        'user_found' => true,
        'email' => $user->email,
        'password_matches_word_password' => $check,
        'hash_in_db' => $user->password,
        'app_key_from_config' => config('app.key'),
        'session_driver' => config('session.driver'),
    ];
});