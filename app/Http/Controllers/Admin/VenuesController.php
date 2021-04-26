<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class VenuesController extends Controller
{
    public function index (Request $request): \Inertia\Response
    {
        Validator::make($request->all(), [
            'filter_name' => ['nullable', 'string', 'max:255'],
            'filter_city' => ['nullable', 'string', 'max:255'],
            'filter_state' => ['nullable', 'string', 'max:255'],
            'sort_name' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_city' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort_state' => ['nullable', 'string', 'in:ASC,DESC'],
            'sort' => ['nullable', 'array'],
            'sort.*' => ['string', 'distinct', 'in:name,city,state'],
        ])->validateWithBag('errors');

        $venues = Venue::query();

        $venues->filter([
            'name' => $request['filter_name'],
            'city' => $request['filter_city'],
            'state' => $request['filter_state'],
        ]);

        if ($request['sort']) {
            collect($request['sort'])->each(function ($sort) use ($request, $venues) {
                $venues->orderBy($sort, $request['sort_'.$sort]);
            });
        }

        return Inertia::render('Admin/Venue/Index', [
            'venue_constraints' => [
                'fields' => [
                    'name' => [
                        'filter_value' => $request['filter_name'] ?: null,
                        'sort_value' => $request['sort_name'] ?: null,
                    ],
                    'city' => [
                        'filter_value' => $request['filter_city'] ?: null,
                        'filter_options' => Venue::all()->pluck('city')->unique(),
                        'sort_value' => $request['sort_city'] ?: null,
                    ],
                    'state' => [
                        'filter_value' => $request['filter_state'] ?: null,
                        'filter_options' => Venue::all()->pluck('state')->unique(),
                        'sort_value' => $request['sort_state'] ?: null,
                    ],
                ],
                'sort' => $request['sort'] ?: [],
                'group' => []
            ],
            'venues' => $venues->select('*')->paginate(5),
        ]);
    }
}
