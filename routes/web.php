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
    ->name('login');

Route::get('/forgot-password', function () {
    return Inertia::render('Auth/ForgotPassword');
})
    ->middleware('guest')
    ->name('password.request');

Route::get('/reset-password/{token}', function (Request $request, $token) {
    return Inertia::render('Auth/ResetPassword', [
        'token' => $token,
    ]);
})
    ->middleware('guest')
    ->name('password.reset');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})
    ->middleware('guest')
    ->name('register');

Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})
    ->middleware('auth:sanctum')
    ->name('verification.notice');

/**
 * Volunteer Routes
 */
Route::prefix('volunteer')
    ->middleware(['auth:sanctum', 'verified', 'documents.approved'])
    ->group(function () {
        Route::get('dashboard', function () {
            return response([], 200);
        })
            ->name('volunteer.dashboard');
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
        Route::prefix('user-documents')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Web\Volunteer\UserDocumentController::class, 'index'])
                    ->name('volunteer.user-documents.index')
                    ->withoutMiddleware('documents.approved');
                Route::get('/create', [\App\Http\Controllers\Web\Volunteer\UserDocumentController::class, 'create'])
                    ->name('volunteer.user-documents.create')
                    ->withoutMiddleware('documents.approved');
                Route::get('/{id}/{file}', \App\Http\Controllers\Web\Volunteer\DownloadUserDocument::class)
                    ->name('volunteer.user-documents.download')
                    ->withoutMiddleware('documents.approved');
                Route::post('/', [\App\Http\Controllers\Web\Volunteer\UserDocumentController::class, 'store'])
                    ->name('volunteer.user-documents.store')
                    ->withoutMiddleware('documents.approved');
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
    Route::prefix('user-documents') ->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Admin\UserDocumentsController::class, 'index'])
            ->name('admin.user-documents.index');
        Route::put('/{id}', [\App\Http\Controllers\Web\Admin\UserDocumentsController::class, 'update'])
            ->name('admin.user-documents.update');
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
