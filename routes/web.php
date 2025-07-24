<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function (Request $request) {
   $user = $request->user();
    // Debugging line to check user object
    // For Stripe Cashier
    $balance = $user->balance(); // Or $user->balance if you store it, or use Stripe API

    return Inertia::render('Dashboard', [
       // 'balance' => $balance,
        // ...other props
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/billing', function (Request $request) {
    $request->user()->createOrGetStripeCustomer();
    return $request->user()->redirectToBillingPortal(route('dashboard'));
})->middleware(['auth'])->name('billing');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
