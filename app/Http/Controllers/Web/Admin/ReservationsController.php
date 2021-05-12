<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Queries\Admin\ReservationsTable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservationsController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/Reservation/Index', [
            'reservations' => ReservationsTable::generateResponse('reservations', 15, $request->all()),
        ]);
    }
}
