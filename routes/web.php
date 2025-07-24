<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function (Request $request) {
   $user = $request->user();
    // Debugging line to check user object
    // For Stripe Cashier
    $balance = $user->balance(); // Or $user->balance if you store it, or use Stripe API

    return Inertia::render('Dashboard', [
       'balance' => str_replace('-', '', $balance), // Assuming balance is a string with a negative sign
        // ...other props
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/billing', function (Request $request) {
    $request->user()->createOrGetStripeCustomer();
    return $request->user()->redirectToBillingPortal(route('dashboard'));
})->middleware(['auth'])->name('billing');

Route::get('/checkout', function (Request $request) {
    $stripePriceId = env('STRIPE_PRICE_ID');
    $service_fee = env('STRIPE_SERVICE_FEE', 150);
    $user = $request->user();
    $quantity = 1;
    $paymentMethod = $user->defaultPaymentMethod();
    $user->invoicePrice($service_fee, 1);
    return $user->checkout([$stripePriceId => $quantity], [
        'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout-cancel'),
    ]);
})->name('checkout');
 
Route::get('/checkout/success', function (Request $request) {
     $sessionId = $request->get('session_id');
 
    if ($sessionId === null) {
        return;
    }
 
    $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
    $user = $request->user();
    $user->creditBalance($session->amount_total, 'Customer top-up.');
;    if ($session->payment_status !== 'paid') {
        return;
    }
 

    return view('checkout.success', [
        'session_id' => $sessionId,
    ]);

})->name('checkout-success');
Route::view('/checkout/cancel', 'checkout.cancel')->name('checkout-cancel');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
