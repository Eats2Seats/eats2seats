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
