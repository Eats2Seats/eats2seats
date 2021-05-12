<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stand;
use App\Models\Venue;
use App\Queries\Admin\StandsTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StandsController extends Controller
{
    public function index (Request $request): \Inertia\Response
    {
        Validator::make($request->toArray(), [
            '*.filter.*' => ['nullable', 'string', 'max:255'],
            '*.sort_priority' => ['nullable', 'array'],
            '*.sort.*' => ['nullable', 'string', 'in:ASC,DESC'],
            '*.display_row' => ['nullable', 'integer'],
            '*.display_column.*' => ['nullable', 'string', 'in:true,false'],
        ])->validate();

        return Inertia::render('Admin/Stand/Index', [
            'stands' => StandsTable::generateResponse('stands', 15, $request->toArray())
        ]);
    }

    public function create()
    {
        $venues = Venue::all();
        return Inertia::render('Admin/Stand/Create', [
            'options' => [
                'venue_id' => $venues->pluck('name', 'id')->unique(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'default_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'venue_id' => ['required', 'integer', 'exists:stands,venue_id'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        Stand::create([
            'default_name' => $request['default_name'],
            'location' => $request['location'],
            'venue_id' => $request['venue_id'],
        ]);

        return Redirect::route('admin.stands.index');
    }

    public function edit(Request $request, $id)
    {
        $stand = Stand::findOrFail($id);
        $venues = Venue::all();
        return Inertia::render('Admin/Stand/Edit', [
            'id' => $id,
            'default_name' => $stand->default_name,
            'location' => $stand->location,
            'venue_id' => $stand->venue_id,
            'options' => [
                'venue_id' => $venues->pluck('name', 'id')->unique(),
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'default_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'venue_id' => ['required', 'integer', 'exists:stands,venue_id'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        Stand::findOrFail($id)
            ->update([
                'default_name' => $request['default_name'],
                'location' => $request['location'],
                'venue_id' => $request['venue_id'],
            ]);

        return Redirect::route('admin.stands.index');
    }

    public function delete(Request $request, $id)
    {
        Stand::findOrFail($id)
            ->delete();
        return back();
    }
}
