<?php

use App\Http\Controllers\GoogleController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/dashboard", function () {
    return view("dashboard");
})->name('dashboard');

// Route::middleware(['auth:sanctum', 'verified'])->get('/app', function () {
//     return view('app');
// })->name('app');

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/{any}', function () {
    return view('app');
})->where('any', '.*')->name('app');
