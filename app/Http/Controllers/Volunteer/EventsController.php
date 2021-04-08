<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Inertia\Inertia;

class EventsController extends Controller
{
    public function index(): \Inertia\Response
    {
        $events = Event::published()->available()->where('start', '>=', Carbon::now())->get();

        $nextEvent = $events->where('start', '>=', Carbon::now())
            ->sortBy('start')
            ->first();

        return Inertia::render('Volunteer/Event/Index', [
            'next' => [
                'id' => $nextEvent->id,
                'event' => [
                    'title' => $nextEvent->title,
                    'start' => $nextEvent->start,
                    'end' => $nextEvent->end,
                ],
                'venue' => [
                    'name' => $nextEvent->venue->name,
                    'street' => $nextEvent->venue->street,
                    'city' => $nextEvent->venue->city,
                    'state' => $nextEvent->venue->state,
                    'zip' => $nextEvent->venue->zip,
                ],
            ],
            'events' => $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                ];
            })
        ]);
    }

    public function show($id): \Inertia\Response
    {
        $event = Event::published()->with([
            'venue',
            'reservations' => function ($query) {
                $query->unclaimed();
            },
            'reservations.stand',
        ])->findOrFail($id);

        return Inertia::render('Volunteer/Event/Show', [
            'event' => [
                'id' => $event->id,
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
            'reservations' => $event->reservations->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'stand_name' => $reservation->stand_name,
                    'position_type' => $reservation->position_type,
                    'location' => $reservation->stand->location,
                ];
            }),
        ]);
    }
}
