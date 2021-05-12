<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Queries\Admin\VenuesTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class VenuesController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function index(Request $request): \Inertia\Response
    {
        Validator::make($request->toArray(), [
            '*.filter.*' => ['nullable', 'string', 'max:255'],
            '*.sort_priority' => ['nullable', 'array'],
            '*.sort.*' => ['nullable', 'string', 'in:ASC,DESC'],
            '*.display_row' => ['nullable', 'integer'],
            '*.display_column.*' => ['nullable', 'string', 'in:true,false'],
        ])->validate();

        return Inertia::render('Admin/Venue/Index', [
            'venues' => VenuesTable::generateResponse('venues', 15, $request->toArray()),
        ]);
    }

    public function show(Request $request, $id)
    {

    }

    public function create(Request $request)
    {
        return Inertia::render('Admin/Venue/Create', []);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        Venue::create([
            'name' => $request['name'],
            'street' => $request['street'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zip' => $request['zip'],
        ]);

        return Redirect::route('admin.venues.index');
    }

    public function edit(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);
        return Inertia::render('Admin/Venue/Edit', [
            'id' => $id,
            'name' => $venue->name,
            'street' => $venue->street,
            'city' => $venue->city,
            'state' => $venue->state,
            'zip' => $venue->zip,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        Venue::findOrFail($id)
            ->update([
                'name' => $request['name'],
                'street' => $request['street'],
                'city' => $request['city'],
                'state' => $request['state'],
                'zip' => $request['zip'],
            ]);

        return Redirect::route('admin.venues.index');
    }

    public function delete(Request $request, $id)
    {
        Venue::findOrFail($id)
            ->delete();
        return Redirect::route('admin.venues.index');
    }
}
