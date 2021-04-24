<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $nextEvent = Event::published()
            ->where('start', '>=', Carbon::now())
            ->available()
            ->orderBy('start', 'ASC')
            ->with('venue')
            ->first();

        $eventsList = Event::published()
            ->where('start', '>=', Carbon::now())
            ->filter($request->only([
                'title', 'start', 'end'
            ]))
            ->available()
            ->orderBy('start', 'ASC')
            ->select([
                'id', 'title', 'start', 'end', 'published_at',
            ])
            ->paginate(5)
            ->appends([
                'title' => $request['title'],
                'start' => $request['start'],
                'end' => $request['end'],
            ]);

        return Inertia::render('Volunteer/Event/Index', [
            'filters' => [
                'fields' => [
                    'title' => $request['title'] ?: null,
                    'start' => $request['start'] ?: null,
                    'end' => $request['end'] ?: null,
                ],
            ],
            'next' => [
                'id' => $nextEvent->id,
                'title' => $nextEvent->title,
                'start' => $nextEvent->start,
                'end' => $nextEvent->end,
                'venue' => [
                    'name' => $nextEvent->venue->name,
                    'street' => $nextEvent->venue->street,
                    'city' => $nextEvent->venue->city,
                    'state' => $nextEvent->venue->state,
                    'zip' => $nextEvent->venue->zip,
                ],
            ],
            'events' => $eventsList,
        ]);
    }

    public function show(Request $request, $id): \Inertia\Response
    {
        $event = Event::with([
            'venue',
            'reservations',
        ])
            ->published()
            ->findOrFail($id);

        return Inertia::render('Volunteer/Event/Show', [
            'filters' => [
                'fields' => [
                    'affiliation' => $request['affiliation'] ?: null,
                    'position_type' => $request['position_type'] ?: null,
                ],
                'options' => [
                    'position_type' => $event->reservations
                        ->pluck('position_type')
                        ->unique(),
                ]
            ],
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
            'positions' => $event->reservations()
                ->unclaimed()
                ->filter($request->only([
                    'position_type'
                ]))
                ->groupBy('event_id', 'stand_id', 'stand_name', 'position_type')
                ->select([
                    'event_id',
                    'stand_id',
                    'stand_name',
                    'position_type',
                    DB::raw('count(*) as remaining'),
                ])
                ->paginate(5)
                ->appends([
                    'affiliation' => $request['affiliation'],
                    'position_type' => $request['position_type'],
                ]),
        ]);
    }
}
