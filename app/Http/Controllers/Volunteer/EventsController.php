<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EventsController extends Controller
{
    public function show($id): \Inertia\Response
    {
        $event = Event::published()->with(['venue', 'tickets'])->findOrFail($id);

        $reservation = $event->tickets()->claimedBy(Auth::user())->first();

        return Inertia::render('Volunteer/Event/Show', [
            'event' => [
                'is_registered' => $reservation ? true : false,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
            ],
            'venue' => [
                'name' => $event->venue->name,
                'street' => $event->venue->street,
                'city' => $event->venue->city,
                'state' => $event->venue->state,
                'zip' => $event->venue->zip,
            ],
            'reservation' => function () use ($reservation) {
                if (!$reservation) return null;
                return [
                    'stand_name' => $reservation->stand_name,
                    'position_type' => $reservation->position_type,
                ];
            },
        ]);
    }
}
