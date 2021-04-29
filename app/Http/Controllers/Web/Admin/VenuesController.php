<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Queries\Admin\VenuesTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class VenuesController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function index (Request $request): \Inertia\Response
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

    public function show (Request $request, $id)
    {

    }

    public function create (Request $request)
    {

    }
}
