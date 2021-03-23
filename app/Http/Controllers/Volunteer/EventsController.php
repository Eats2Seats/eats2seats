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
            'event' => $event,
            'venue' => $event->venue,
        ]);
    }
}
