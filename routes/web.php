<?php

use App\Models\BankService;
use App\Models\LawService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('auth.register.email.create'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/homepage', function () {
    return Inertia::render('Homepage');
})->name('homepage');

Route::middleware(['auth:sanctum', 'verified'])->get('/forms', function () {
    $user = auth()?->user();
    $lawRegistration = LawService::first()->lawRegistrations()->where('user_id', $user->id)->first();
    $paymentAccount = BankService::first()->paymentAccounts()->where('user_id', $user->id)->first();
    return Inertia::render('CourierForms', [
        'law_registration' => $lawRegistration?->toArray(),
        'payment_account' => $paymentAccount?->toArray()
    ]);
})->name('forms');
