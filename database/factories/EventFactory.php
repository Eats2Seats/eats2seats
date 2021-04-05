<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Venue;
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
            'venue_id' => Venue::factory(),
            'start' => Carbon::parse('+1 day 5:00 PM'),
            'end' => Carbon::parse('+1 day 8:00 PM'),
            'published_at' => null,
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

    public function future()
    {
        return $this->state([
            'start' => Carbon::parse('+1 week 1:00 PM'),
            'end' => Carbon::parse('+1 week 4:00 PM'),
        ]);
    }

    public function past()
    {
        return $this->state([
            'start' => Carbon::parse('-1 week 3:00 PM'),
            'end' => Carbon::parse('-1 week 7:00 PM'),
        ]);
    }

    public function available()
    {
        return $this->has(Reservation::factory()->count(1));
    }

    public function unavailable()
    {
        return $this->has(Reservation::factory()->claimed()->count(1));
    }
}
