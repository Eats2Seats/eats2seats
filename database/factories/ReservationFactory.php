<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Stand;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => Event::factory()->published(),
            'stand_id' => function (array $attributes) {
                return Stand::factory()->state([
                    'venue_id' => Event::find($attributes['event_id'])->venue_id,
                ]);
            },
            'user_id' => null,
            'stand_name' => 'Test Stand Name',
            'position_type' => 'Test Position',
        ];
    }

    public function claimed()
    {
        return $this->state([
            'user_id' => function () {
                return User::factory()->create();
            }
        ]);
    }

    public function claimedBy($user)
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    public function unclaimed()
    {
        return $this->state([
            'user_id' => null,
        ]);
    }
}
