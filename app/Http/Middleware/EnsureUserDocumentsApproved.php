<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EnsureUserDocumentsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->user()->documents_approved_at) {
            return $request->user()->documents()->latest()->first()?->review_status === 'pending'
                ? Redirect::route('volunteer.user-documents.index')
                : Redirect::route('volunteer.user-documents.create');
        }

        return $next($request);
    }
}
