<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public Collection $venues;
    public Collection $events;
    public Collection $stands;
    public Collection $reservations;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        $userA = User::factory()
            ->unverified()
            ->documentsUnapproved()
            ->create([
                'email' => 'userA@example.com',
                'password' => bcrypt('12345'),
            ]);

        for ($i = 0; $i < 3; $i++) {
            $venue = Venue::factory()
                ->create([
                    'name' => $faker->randomElement([
                        'Kenan Memorial Stadium',
                        'Dix Stadium',
                        'Beaver Stadium',
                        'Carrier Dome',
                        'Carter-Finley Stadium',
                        'Fred Yager Stadium',
                        'Dowdy-Ficklen Stadium',
                        'Folsom Field',
                        'Floyd Casey Stadium',
                    ]),
                    'street' => $faker->streetAddress,
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'zip' => $faker->postcode,
                ]);

            $events = Event::factory()
                ->count($faker->numberBetween(5, 10))
                ->published()
                ->state(function (array $attributes) use ($faker, $venue) {
                    return [
                        'venue_id' => $venue->id,
                        'title' => implode(' vs ', $faker->randomElements([
                            'UNC',
                            'Virginia Tech',
                            'Stanford',
                            'Berkley',
                            'Harvard',
                            'Yale',
                            'Dallas Baptist',
                            'Syracuse',
                            'NC State',
                            'Virginia Tech',
                            'Princeton',
                            'Georgia Tech',
                            'MIT',
                            'CalTech',
                            'Cornell',
                            'Miami',
                            'Fresno State',
                            'Baylor',
                        ], 2)),
                        'start' => $start = $faker->dateTimeBetween('now', '+1 month'),
                        'end' => Carbon::parse($start)->add('+3 hours'),
                    ];
                })
                ->create();

            $stands = Stand::factory()
                ->count($faker->numberBetween(5, 10))
                ->state(function (array $attributes) use ($faker, $venue) {
                    return [
                        'default_name' => $faker->randomElement([
                            'Sal\'s Spaghetti',
                            'Carrie\'s Cotton Candy',
                            'Perry\'s Pizza',
                            'Harry\'s Hot Dogs',
                            'Bart\'s Bagels',
                            'Izzy\'s Ice Cream',
                        ]),
                        'venue_id' => $venue->id,
                        'location' => 'Stand #' . $faker->numberBetween(1, 25),
                    ];
                })
                ->create();

            foreach ($events as $event) {
                foreach ($stands as $stand) {
                    $name = $faker->randomElement([
                        "Carrie's Cotton Candy",
                        "Bob's Burgers",
                        "Perry's Pizza",
                        "Sal's Spaghetti",
                        "Larry's Lemonade",
                        "Harry's Hibachi",
                    ]);
                    Reservation::factory()
                        ->count($faker->numberBetween(0, 10))
                        ->unclaimed()
                        ->state(function (array $attributes) use ($faker, $event, $stand, $name) {
                            return [
                                'event_id' => $event->id,
                                'stand_id' => $stand->id,
                                'user_id' => null,
                                'stand_name' => $name,
                                'position_type' => $faker->randomElement([
                                    'Food Sales',
                                    'Alcohol Sales',
                                ]),
                            ];
                        })
                        ->create();
                }
            }
        }

//        Event::whereRaw('MOD(id, 2) = 0')->each(function ($event) use ($userA) {
//            $event->reservations->first()->update([
//                'user_id' => $userA->id,
//            ]);
//        });
    }
}
