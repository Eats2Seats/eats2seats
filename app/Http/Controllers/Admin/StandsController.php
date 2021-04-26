<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stand;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StandsController extends Controller
{
    public function index (Request $request): \Inertia\Response
    {
        Validator::make($request->all(), [
            'filter_default_name' => ['nullable', 'string', 'max:255'],
            'filter_venue_name' => ['nullable', 'string', 'max:255'],
            'filter_stand_location' => ['nullable', 'string', 'max:255'],
            'sort_default_name' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_venue_name' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_stand_location' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort' => ['nullable', 'array', 'distinct', 'in:default_name,stand_location,venue_name'],
        ])->validate();

        $stands = Stand::query();

        $stands->filter([
            'default_name' => $request['filter_default_name'],
            'location' => $request['filter_stand_location'],
        ])
            ->whereHas('venue', function (Builder $query) use ($request) {
                $query->filter([
                    'name' => $request['filter_venue_name'],
                ]);
            });

        $stands->join('venues', 'stands.venue_id', '=', 'venues.id')
            ->select([
                'stands.id',
                'stands.venue_id',
                'stands.default_name',
                'stands.location as stand_location',
                'venues.name as venue_name',
            ]);

        if ($request['sort']) {
            collect($request['sort'])->each(function ($sort) use ($request, $stands) {
                $stands->orderBy($sort, $request['sort_'.$sort]);
            });
        }

        return Inertia::render('Admin/Stand/Index', [
            'stands' => $stands->paginate(10)->appends($request->all()),
            'stand_constraints' => [
                'fields' => [
                    'default_name' => [
                        'filter_value' => $request['filter_default_name'] ?: null,
                        'sort_value' => $request['sort_default_name'] ?: null,
                    ],
                    'venue_name' => [
                        'filter_value' => $request['filter_venue_name'] ?: null,
                        'filter_options' => Stand::with('venue')->get()->pluck('venue.name')
                            ->unique(),
                        'sort_value' => $request['sort_venue_name'] ?: null,
                    ],
                    'stand_location' => [
                        'filter_value' => $request['filter_stand_location'] ?: null,
                        'sort_value' => $request['sort_stand_location'] ?: null,
                    ],
                ],
                'sort' => $request['sort'] ?: [],
            ],
        ]);
    }
}
