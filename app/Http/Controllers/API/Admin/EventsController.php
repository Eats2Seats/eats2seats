<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $events = Event::query();

        $events->filter([
            'title' => $request['filter']['title'] ?? null,
            'start' => $request['filter']['start'] ?? null,
            'end' => $request['filter']['end'] ?? null,
            'published_at' => $request['filter']['published_at'] ?? null,
        ]);

        if ($request['sort_priority']) {
            collect($request['sort_priority'])->each(function ($sort) use ($request, $events) {
                $events->orderBy($sort, $request['sort'][$sort]);
            });
        }

        return Inertia::render('Admin/Test', [
            'events' => [
                'pagination' => $events->paginate(15),
                'filter' => [
                    'title' => [
                        'value' => $request['filter']['title'] ?? null,
                    ],
                    'start' => [
                        'value' => $request['filter']['start'] ?? null,
                    ],
                    'end' => [
                        'value' => $request['filter']['end'] ?? null,
                    ],
                    'published_at' => [
                        'value' => $request['filter']['published_at'] ?? null,
                    ],
                ],
                'sort' => [
                    'priority' => $request['sort_priority'] ?? [],
                    'direction' => [
                        'title' => $request['sort']['title'] ?? null,
                        'start' => $request['sort']['start'] ?? null,
                        'end' => $request['sort']['end'] ?? null,
                        'published_at' => $request['sort']['published_at'] ?? null,
                    ],
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
