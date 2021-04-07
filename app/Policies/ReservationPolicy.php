<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Request;

class ReservationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reservation  $reservation
     * @return mixed
     */
    public function view(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id
            ? Response::allow()
            : Response::deny('The reservation you are attempting to access does not belong to you.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reservation  $reservation
     * @return mixed
     */
    public function update(User $user, Reservation $reservation, int $requestUserID)
    {
        if ($reservation->user_id !== null) {
            return Response::deny('This reservation has already been claimed.');
        }
        if ($user->id !== $requestUserID) {
            return Response::deny('You cannot claim a reservation for another user.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reservation  $reservation
     * @return mixed
     */
    public function delete(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id
            ? Response::allow()
            : Response::deny('You cannot cancel a reservation claimed by another user.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reservation  $reservation
     * @return mixed
     */
    public function restore(User $user, Reservation $reservation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reservation  $reservation
     * @return mixed
     */
    public function forceDelete(User $user, Reservation $reservation)
    {
        //
    }
}
