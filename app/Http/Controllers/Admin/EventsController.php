<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class EventsController extends Controller
{
    public function index (Request $request)
    {
        Validator::make($request->all(), [
            'filter_title' => ['nullable', 'string', 'max:255'],
            'filter_start' => ['nullable', 'string', 'max:255'],
            'filter_end' => ['nullable', 'string', 'max:255'],
            'filter_published_at' => ['nullable', 'string', 'max:255'],
            'filter_venue_name' => ['nullable', 'string', 'max:255'],
            'sort_title' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_start' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_end' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_published_at' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_venue_name' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort' => ['nullable', 'array', 'distinct', 'in:title,start,end,published_at,venue_name'],
        ])->validate();

        $events = Event::query();

        $events->filter([
            'title' => $request['filter_title'],
            'start' => $request['filter_start'],
            'end' => $request['filter_end'],
            'published_at' => $request['filter_published_at'],
        ])
            ->whereHas('venue', function (Builder $query) use ($request) {
                $query->filter([
                    'name' => $request['filter_venue_name'],
                ]);
            });

        $events->join('venues', 'events.venue_id', '=', 'venues.id')
            ->select([
                'events.id',
                'events.venue_id',
                'events.title',
                'events.start',
                'events.end',
                'events.published_at',
                'venues.name as venue_name',
            ]);

        if ($request['sort']) {
            collect($request['sort'])->each(function ($sort) use ($request, $events) {
                $events->orderBy($sort, $request['sort_'.$sort]);
            });
        }

        return Inertia::render('Admin/Event/Index', [
            'events' => $events->paginate(10)->appends($request->all()),
            'event_constraints' => [
                'fields' => [
                    'title' => [
                        'filter_value' => $request['filter_title'] ?: null,
                        'sort_value' => $request['sort_title'] ?: null,
                    ],
                    'start' => [
                        'filter_value' => $request['filter_start'] ?: null,
                        'sort_value' => $request['sort_start'] ?: null,
                    ],
                    'end' => [
                        'filter_value' => $request['filter_end'] ?: null,
                        'sort_value' => $request['sort_end'] ?: null,
                    ],
                    'published_at' => [
                        'filter_value' => $request['filter_published_at'] ?: null,
                        'sort_value' => $request['sort_published_at'] ?: null,
                    ],
                    'venue_name' => [
                        'filter_value' => $request['filter_venue_name'] ?: null,
                        'filter_options' => Event::with('venue')->get()->pluck('venue.name')
                            ->unique(),
                        'sort_value' => $request['sort_venue_name'] ?: null,
                    ],
                ],
                'sort' => $request['sort'] ?: [],
            ],
        ]);
    }
}
