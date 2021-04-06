<?php

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
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/sam', function () {
   return Inertia::render('Development/Sam');
});
Route::get('/qintian', function () {
    return Inertia::render('Development/Qintian');
});
Route::get('/deven', function () {
    return Inertia::render('Development/Deven');
});

/**
 * Volunteer Routes
 */
Route::prefix('volunteer')->group(function () {
    Route::prefix('events')->group(function () {
        Route::get('/', [\App\Http\Controllers\Volunteer\EventsController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Volunteer\EventsController::class, 'show']);
    });
    Route::prefix('reservations')->group(function () {
        Route::get('/', [\App\Http\Controllers\Volunteer\ReservationsController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Volunteer\ReservationsController::class, 'show']);
    });
});
