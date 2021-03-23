<?php

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Example Title',
            'venue' => 'Example Venue',
            'start' => Carbon::parse('+1 day 5:00 PM'),
            'end' => Carbon::parse('+1 day 8:00 PM'),
        ];
    }

    public function published()
    {
        return $this->state([
            'published_at' => Carbon::parse('now'),
        ]);
    }

    public function unpublished()
    {
        return $this->state([
            'published_at' => null,
        ]);
    }
}
