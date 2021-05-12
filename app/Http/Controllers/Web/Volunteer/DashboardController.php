<?php

namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request): \Inertia\Response
    {
        return Inertia::render('Volunteer/Dashboard', [
            'user' => Auth::user(),
            'reservation' => Reservation::claimedBy(Auth::user())
                ->with([
                    'event',
                    'event.venue'
                ])
                ->get()
                ->where('event.end', '>=', Carbon::now())
                ->transform(function ($reservation) {
                    $reservation->start_date = Carbon::parse($reservation->event->start)->isoFormat('MMM Do');
                    $reservation->start_time = Carbon::parse($reservation->event->start)->isoFormat('h:mm a');
                    $reservation->end_date = Carbon::parse($reservation->event->end)->isoFormat('MMM Do');
                    $reservation->end_time = Carbon::parse($reservation->event->end)->isoFormat('h:mm a');
                    return $reservation;
                })
                ->first(),
        ]);
    }
}
