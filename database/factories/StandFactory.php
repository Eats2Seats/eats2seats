<?php

namespace Database\Factories;

use App\Models\Stand;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class StandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'venue_id' => Venue::factory(),
            'default_name' => 'Test Default Name',
            'location' => 'Test Location',
        ];
    }
}
