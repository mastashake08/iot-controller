<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function (Request $request) {
   $user = $request->user();

    // For Stripe Cashier
    $balance = $user->balance(); // Or $user->balance if you store it, or use Stripe API

    return Inertia::render('Dashboard', [
        'balance' => $balance,
        // ...other props
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
