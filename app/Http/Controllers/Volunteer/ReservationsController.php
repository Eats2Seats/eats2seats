<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ReservationsController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['event', 'event.venue'])->get();

        $nextReservation = $reservations->where('event.start', '>=', Carbon::now())
            ->sortBy('event.start')
            ->first();

        return Inertia::render('Volunteer/Reservation/Index', [
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
            'reservations' => $reservations->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'event_title' => $reservation->event->title,
                    'event_date' => $reservation->event->start,
                    'venue_name' => $reservation->event->venue->name,
                    'position_type' => $reservation->position_type,
                ];
            }),
        ]);
    }

    public function show($id)
    {
        $reservation = Reservation::with(['event', 'event.venue', 'stand'])->findOrFail($id);

        Gate::authorize('view', $reservation);

        return Inertia::render('Volunteer/Reservation/Show', [
            'event' => [
                'title' => $reservation->event->title,
                'start' => $reservation->event->start,
                'end' => $reservation->event->end,
            ],
            'venue' => [
                'name' => $reservation->event->venue->name,
                'street' => $reservation->event->venue->street,
                'city' => $reservation->event->venue->city,
                'state' => $reservation->event->venue->state,
                'zip' => $reservation->event->venue->zip,
            ],
            'reservation' => [
                'id' => $reservation->id,
                'stand_name' => $reservation->stand_name,
                'stand_location' => $reservation->stand->location,
                'position_type' => $reservation->position_type,
            ],
        ]);
    }
}
