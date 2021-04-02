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
        $event = Event::factory()->published()->create();

        return [
            'event_id' => $event,
            'stand_id' => function () use ($event) {
                return Stand::factory()->create([
                    'venue_id' => $event->venue_id,
                ]);
            },
            'user_id' => function () {
                return User::factory()->create();
            },
            'stand_name' => 'Test Stand Name',
            'position_type' => 'Test Position',
        ];
    }
}
