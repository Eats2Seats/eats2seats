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
        Route::get('/', [\App\Http\Controllers\Volunteer\EventsController::class, 'index'])
            ->name('volunteer.events.index');
        Route::get('/{id}', [\App\Http\Controllers\Volunteer\EventsController::class, 'show'])
            ->name('volunteer.events.show');
    });
    Route::prefix('reservations')->group(function () {
        Route::get('/', [\App\Http\Controllers\Volunteer\ReservationsController::class, 'index'])
            ->name('volunteer.reservations.index');
        Route::get('/{id}', [\App\Http\Controllers\Volunteer\ReservationsController::class, 'show'])
            ->name('volunteer.reservations.show');
        Route::get('/claim/{event}/{stand}/{positionType}', [\App\Http\Controllers\Volunteer\ReservationsController::class, 'edit'])
            ->name('volunteer.reservations.claim');
        Route::put('/{id}', [\App\Http\Controllers\Volunteer\ReservationsController::class, 'update'])
            ->name('volunteer.reservations.update');
        Route::delete('/{id}', [\App\Http\Controllers\Volunteer\ReservationsController::class, 'delete'])
            ->name('volunteer.reservations.delete');
    });
});

/**
 * Admin Routes
 */
Route::prefix('admin')->group(function () {
    Route::prefix('venues')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\VenuesController::class, 'index'])
            ->name('admin.venues.index');
    });
});
