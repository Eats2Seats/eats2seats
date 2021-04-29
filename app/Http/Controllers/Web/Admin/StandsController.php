<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stand;
use App\Models\Venue;
use App\Queries\Admin\StandsTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
}
