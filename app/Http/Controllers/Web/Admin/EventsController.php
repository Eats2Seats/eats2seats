<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\Venue;
use App\Queries\Admin\EventsTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $events = Event::query();

        return Inertia::render('Admin/Event/Show', [
            'events' => [
                'pagination' => $events->paginate($request['events']['rows'] ?? null)->withQueryString(),
                'filter' => [
                    'title' => [
                        'value' => $request['events']['filter']['title'] ?? null,
                        'options' => null,
                    ],
                    'start' => [
                        'value' => $request['events']['filter']['start'] ?? null,
                        'options' => null,
                    ],
                    'end' => [
                        'value' => $request['events']['filter']['end'] ?? null,
                        'options' => null,
                    ],
                    'published_at' => [
                        'value' => $request['events']['filter']['published_at'] ?? null,
                        'options' => null,
                    ],
                ],
                'sort' => [
                    'priority' => $request['events']['sort_priority'] ?? [],
                    'fields' => [
                        'title' => $request['events']['sort']['title'] ?? null,
                        'start' => $request['events']['sort']['start'] ?? null,
                        'end' => $request['events']['sort']['end'] ?? null,
                        'published_at' => $request['events']['sort']['published_at'] ?? null,
                    ]
                ],
                'display' => [
                    'columns' => [
                        'title' => $request['events']['hide']['title'] ?? false,
                        'start' => $request['events']['hide']['start'] ?? false,
                        'end' => $request['events']['hide']['end'] ?? false,
                        'published_at' => $request['events']['hide']['published_at'] ?? false,
                    ],
                    'rows' => $request['events']['rows'] ?? 15,
                ],
            ],
        ]);
    }

    public function edit(Request $request): \Inertia\Response
    {
        $eventsUID = 'events';

        $events = Event::query();

        $events->filter([
            'title' => $request[$eventsUID]['filter']['title'] ?? null,
            'start' => $request[$eventsUID]['filter']['start'] ?? null,
            'end' => $request[$eventsUID]['filter']['end'] ?? null,
            'published_at' => $request[$eventsUID]['filter']['published_at'] ?? null,
        ]);

        if ($request[$eventsUID]['sort_priority'] ?? null) {
            collect($request[$eventsUID]['sort_priority'])->each(function ($sort) use ($request, $events, $eventsUID) {
                $events->orderBy($sort, $request[$eventsUID]['sort'][$sort]);
            });
        }

        return Inertia::render('Admin/Test', [
            'events' => [
                'uid' => fn () => $eventsUID,
                'pagination' => $events->paginate($request[$eventsUID]['display_row'] ?? 15)
                    ->appends($request->all()),
                'filter' => fn () => [
                    'title' => [
                        'value' => $request[$eventsUID]['filter']['title'] ?? null,
                    ],
                    'start' => [
                        'value' => $request[$eventsUID]['filter']['start'] ?? null,
                    ],
                    'end' => [
                        'value' => $request[$eventsUID]['filter']['end'] ?? null,
                    ],
                    'published_at' => [
                        'value' => $request[$eventsUID]['filter']['published_at'] ?? null,
                    ],
                ],
                'sort' => fn () => [
                    'priority' => $request[$eventsUID]['sort_priority'] ?? [],
                    'direction' => [
                        'title' => $request[$eventsUID]['sort']['title'] ?? null,
                        'start' => $request[$eventsUID]['sort']['start'] ?? null,
                        'end' => $request[$eventsUID]['sort']['end'] ?? null,
                        'published_at' => $request[$eventsUID]['sort']['published_at'] ?? null,
                    ],
                ],
                'display' => fn () => [
                    'column' => [
                        'title' => [
                            'value' => true,
                            'default' => true,
                        ],
                        'start' => [
                            'value' => $request[$eventsUID]['display_column']['start'] ?? true,
                            'default' => true,
                        ],
                        'end' => [
                            'value' => $request[$eventsUID]['display_column']['end'] ?? true,
                            'default' => true,
                        ],
                        'published_at' => [
                            'value' => $request[$eventsUID]['display_column']['published_at'] ?? true,
                            'default' => true,
                        ],
                    ],
                    'row' => [
                        'value' => $request[$eventsUID]['display_row'] ?? 15,
                        'default' => 15,
                    ]
                ]
            ],
        ]);
    }
}
