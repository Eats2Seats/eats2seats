<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): \Inertia\Response
    {
        $user = Auth::user();

        $reservations = Reservation::claimedBy($user)->with(['event', 'event.venue'])->get();

        $nextReservation = $reservations->where('event.start', '>=', Carbon::now())
            ->sortBy('event.start')
            ->first();

        return Inertia::render('Dashboard', [
            'next' => [
                'id' => $nextReservation->id,
                'event' => [
                    'title' => $nextReservation->event->title,
                    'start' => $nextReservation->event->start,
                    'end' => $nextReservation->event->end,
                ],
                'venue' => [
                    'name' => $nextReservation->event->venue->name,
                    'street' => $nextReservation->event->venue->street,
                    'city' => $nextReservation->event->venue->city,
                    'state' => $nextReservation->event->venue->state,
                    'zip' => $nextReservation->event->venue->zip,
                ],
            ],
            'user' => $user,
        ]);
    }
}
