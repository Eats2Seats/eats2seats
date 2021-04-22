<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Volunteer/Event/Index', [
            'filters' => $request->all(),
            'next' => Event::published()
                ->where('start', '>=', Carbon::now())
                ->available()
                ->orderBy('start', 'ASC')
                ->with('venue')
                ->first(),
            'events' => Event::published()
                ->where('start', '>=', Carbon::now())
                ->filter()
                ->available()
                ->orderBy('start', 'ASC')
                ->paginate(5)
                ->appends([
                    'title' => $request['title'],
                    'start' => $request['start'],
                    'end' => $request['end'],
                ]),
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
