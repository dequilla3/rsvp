<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Models\Guest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'guestCount' => Guest::count(),
        'guests' => Guest::latest()->get(['id', 'name', 'created_at']),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
