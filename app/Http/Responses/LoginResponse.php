<?php


namespace App\Http\Responses;


class LoginResponse implements \Laravel\Fortify\Contracts\LoginResponse
{

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $home = '/volunteer/dashboard';
        return redirect()->intended($home);
    }
}
