<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\Venue;
use App\Queries\Admin\EventsTable;
use App\Queries\Admin\EventStandsTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class EventsController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function index (Request $request)
    {
        Validator::make($request->toArray(), [
            '*.filter.*' => ['nullable', 'string', 'max:255'],
            '*.sort_priority' => ['nullable', 'array'],
            '*.sort.*' => ['nullable', 'string', 'in:ASC,DESC'],
            '*.display_row' => ['nullable', 'integer'],
            '*.display_column.*' => ['nullable', 'string', 'in:true,false'],
        ])->validate();

        return Inertia::render('Admin/Event/Index', [
            'events' => EventsTable::generateResponse('events', 15, $request->toArray()),
        ]);
    }

    public function show (Request $request, $id)
    {
        Validator::make($request->toArray(), [
            '*.filter.*' => ['nullable', 'string', 'max:255'],
            '*.sort_priority' => ['nullable', 'array'],
            '*.sort.*' => ['nullable', 'string', 'in:ASC,DESC'],
            '*.display_row' => ['nullable', 'integer'],
            '*.display_column.*' => ['nullable', 'string', 'in:true,false'],
        ])->validate();

        $event = Event::with('venue')->findOrFail($id);

        return Inertia::render('Admin/Event/Show', [
            'event' => $event,
            'stands' => EventStandsTable::generateResponse('stands', 15, $request->all(), $event),
            'reservations' => [],
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Admin/Event/Create', [
            'venues' => Venue::with('stands')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $event = Event::create([
            'venue_id' => $request['venue'],
            'title' => $request['title'],
            'start' => Carbon::parse($request['start_date'] . ' ' . $request['start_time']),
            'end' => Carbon::parse($request['end_date'] . ' ' . $request['end_time']),
            'published_at' => now(),
        ]);

        foreach ($request['stands'] as $stand) {
            for ($i = 0; $i < intval($stand['default_positions']); $i++) {
                Reservation::create([
                    'event_id' => $event->id,
                    'stand_id' => $stand['id'],
                    'user_id' => null,
                    'stand_name' => $stand['default_name'],
                    'position_type' => 'Food Sales',
                ]);
            }
        }

        return Redirect::route('admin.events.index');
    }

    public function edit(Request $request, $id)
    {
        return Inertia::render('Admin/Event/Edit', [
            'event' => Event::with('venue')->findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        Event::findOrFail($id)
            ->update([
                'title' => $request['title'],
                'start' => Carbon::parse($request['start_date'] . ' ' . $request['start_time']),
                'end' => Carbon::parse($request['end_date'] . ' ' . $request['end_time']),
            ]);
        return Redirect::route('admin.events.index');
    }

    public function delete()
    {

    }
}
