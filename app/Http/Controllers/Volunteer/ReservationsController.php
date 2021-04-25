<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): \Inertia\Response
    {
        $reservation = Reservation::claimedBy(Auth::user())
            ->with([
                'event',
                'event.venue'
            ])
            ->get();

        $reservationsList = Reservation::claimedBy(Auth::user())
            ->select('reservations.*')
            ->leftJoin('events', 'reservations.event_id', '=', 'events.id')
            ->orderBy('events.start', 'DESC')
            ->filter($request->only('position_type'))
            ->with('event')
            ->whereHas('event', function (Builder $query) use ($request) {
                $query->filter([
                    'title' => $request['event_title'],
                    'start' => $request['event_start'],
                    'end' => $request['event_end'],
                ]);
            })
            ->with('event.venue')
            ->whereHas('event.venue', function (Builder $query) use ($request) {
                $query->filter([
                    'name' => $request['venue_name']
                ]);
            })
            ->paginate(5)
            ->through(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'event_title' => $reservation->event->title,
                    'event_start' => $reservation->event->start,
                    'event_end' => $reservation->event->end,
                    'venue_name' => $reservation->event->venue->name,
                    'position_type' => $reservation->position_type,
                ];
            })
            ->appends([
                'event_title' => $request['event_title'],
                'event_start' => $request['event_start'],
                'event_end' => $request['event_end'],
                'venue_name' => $request['venue_name'],
                'position_type' => $request['position_type'],
            ]);

        $reservationListOptions = Reservation::claimedBy(Auth::user())
            ->with(['event', 'event.venue'])
            ->get();

        return Inertia::render('Volunteer/Reservation/Index', [
            'filters' => [
                'fields' => [
                    'event_title' => $request['event_title'] ?: null,
                    'event_start' => $request['event_start'] ?: null,
                    'event_end' => $request['event_end'] ?: null,
                    'venue_name' => $request['venue_name'] ?: null,
                    'position_type' => $request['position_type'] ?: null,
                ],
                'options' => [
                    'venue_name' => $reservationListOptions->pluck('event.venue.name')
                        ->unique(),
                    'position_type' => $reservationListOptions->pluck('position_type')
                        ->unique(),
                ]
            ],
            'next' => $reservation->where('event.end', '>=', Carbon::now())
                ->transform(function ($reservation) {
                    return [
                        'id' => $reservation->id,
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
                    ];
                })
                ->first(),
            'reservations' => $reservationsList,
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id): \Inertia\Response
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

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, $event, $stand, $positionType): \Inertia\Response
    {
        $reservation = Reservation::where('event_id', $event)
            ->where('stand_id', $stand)
            ->where('position_type', $positionType)
            ->with(['event', 'event.venue'])
            ->unclaimed()
            ->firstOrFail();

        Gate::authorize('viewAny', $reservation);

        return Inertia::render('Volunteer/Reservation/Edit', [
            'reservation' => [
                'id' => $reservation->id,
                'stand_name' => $reservation->stand_name,
                'stand_location' => $reservation->stand->location,
                'position_type' => $reservation->position_type
            ],
            'event' => [
                'id' => $reservation->event->id,
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
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $reservation = Reservation::findOrFail($id);

        Gate::authorize('update', [$reservation, Auth::id()]);

        $reservation->update([
            'user_id' => Auth::id(),
        ]);

        return redirect('/volunteer/reservations/' . $id);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $reservation = Reservation::findOrFail($id);

        Gate::authorize('delete', $reservation);

        $reservation->update([
            'user_id' => null,
        ]);

        return redirect('/volunteer/reservations');
    }
}
