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

Route::middleware(['auth:sanctum', 'verified', 'documents.approved'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

/*
 * Auth Routes
 */
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})
    ->middleware('guest')
    ->name('auth.login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})
    ->middleware('guest')
    ->name('auth.register');

Route::get('/pending-approval', function () {
    return Inertia::render('Auth/PendingApproval');
})
    ->middleware(['auth:sanctum', 'verified'])
    ->name('pending.approval');

/**
 * Volunteer Routes
 */
Route::prefix('volunteer')->group(function () {
    Route::prefix('events')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Volunteer\EventsController::class, 'index'])
            ->name('volunteer.events.index');
        Route::get('/{id}', [\App\Http\Controllers\Web\Volunteer\EventsController::class, 'show'])
            ->name('volunteer.events.show');
    });
    Route::prefix('reservations')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Volunteer\ReservationsController::class, 'index'])
            ->name('volunteer.reservations.index');
        Route::get('/{id}', [\App\Http\Controllers\Web\Volunteer\ReservationsController::class, 'show'])
            ->name('volunteer.reservations.show');
        Route::get('/claim/{event}/{stand}/{positionType}', [\App\Http\Controllers\Web\Volunteer\ReservationsController::class, 'edit'])
            ->name('volunteer.reservations.claim');
        Route::put('/{id}', [\App\Http\Controllers\Web\Volunteer\ReservationsController::class, 'update'])
            ->name('volunteer.reservations.update');
        Route::delete('/{id}', [\App\Http\Controllers\Web\Volunteer\ReservationsController::class, 'delete'])
            ->name('volunteer.reservations.delete');
    });
});

/**
 * Admin Routes
 */
Route::prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Web\Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Admin\UsersController::class, 'index'])
            ->name('admin.users.index');
    });
    Route::prefix('venues')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Admin\VenuesController::class, 'index'])
            ->name('admin.venues.index');
        Route::get('/{id}', [\App\Http\Controllers\Web\Admin\VenuesController::class, 'show'])
            ->name('admin.venues.show');
        Route::get('/create', [\App\Http\Controllers\Web\Admin\VenuesController::class, 'create'])
            ->name('admin.venues.create');
        Route::get('/{id}/edit', [\App\Http\Controllers\Web\Admin\VenuesController::class, 'edit'])
            ->name('admin.venues.edit');
    });
    Route::prefix('stands')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Admin\StandsController::class, 'index'])
            ->name('admin.stands.index');
        Route::get('/{id}', [\App\Http\Controllers\Web\Admin\StandsController::class, 'show'])
            ->name('admin.stands.show');
        Route::get('/create', [\App\Http\Controllers\Web\Admin\StandsController::class, 'create'])
            ->name('admin.stands.create');
        Route::get('/{id}/edit', [\App\Http\Controllers\Web\Admin\StandsController::class, 'edit'])
            ->name('admin.stands.edit');
    });
    Route::prefix('events')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Admin\EventsController::class, 'index'])
            ->name('admin.events.index');
        Route::get('/{id}', [\App\Http\Controllers\Web\Admin\EventsController::class, 'show'])
            ->name('admin.events.show');
        Route::get('/create', [\App\Http\Controllers\Web\Admin\EventsController::class, 'create'])
            ->name('admin.events.create');
        Route::get('/{id}/edit', [\App\Http\Controllers\Web\Admin\EventsController::class, 'edit'])
            ->name('admin.events.edit');
    });
    Route::prefix('reservations')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Admin\ReservationsController::class, 'index'])
            ->name('admin.reservations.index');
    });

});
