<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Inertia\Inertia;

class EventsController extends Controller
{
    public function show($id)
    {
        $event = Event::published()->findOrFail($id);

        return Inertia::render('Volunteer/Event/Show', [
            'title' => $event->title,
            'venue' => $event->venue,
            'start' => $event->start,
            'end' => $event->end,
        ]);
    }
}
