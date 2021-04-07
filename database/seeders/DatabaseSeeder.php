<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Stand;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        $userA = User::factory()->create([
            'email' => 'userA@example.com',
            'password' => bcrypt('12345'),
        ]);

        Venue::factory()
            ->count(3)
            ->has(
                Event::factory()
                    ->count(10)
                    ->published()
                    ->state(function () use ($faker) {
                        $start = $faker->dateTimeBetween('now', '+1 month');
                        $end = Carbon::parse($start)->hours(3);
                        return [
                            'title' => $faker->randomElement([
                                'UNC vs Virginia Tech',
                                'Stanford vs Berkley',
                                'Harvard vs Yale',
                                'Dallas Baptist vs Syracuse',
                                'NC State vs Virginia Tech',
                                'Princeton vs Georgia Tech',
                                'MIT vs CalTech',
                                'Cornell vs Miami',
                                'Fresno State vs Baylor',
                            ]),
                            'start' => $start,
                            'end' => $end
                        ];
                    })
                    ->has(
                        Reservation::factory()
                            ->count(10)
                            ->unclaimed()
                            ->state(function (array $attributes) use ($faker) {
                                return [
                                    'stand_name' => $faker->randomElement([
                                        "Carrie's Cotton Candy",
                                        "Bob's Burgers",
                                        "Perry's Pizza",
                                        "Sal's Spaghetti",
                                        "Larry's Lemonade",
                                        "Harry's Hibachi",
                                    ]),
                                    'position_type' => $faker->randomElement([
                                        'Food Sales',
                                        'Alcohol Sales',
                                    ]),
                                ];
                            })
                            ->has(
                                Stand::factory()
                                    ->count(1)
                                    ->state(function (array $attributes, Reservation $reservation) use ($faker) {
                                        return [
                                            'venue_id' => $reservation->event->venue->id,
                                            'location' => 'Stand #' . $faker->numberBetween(1, 25),
                                        ];
                                    })
                            )
                    )
            )
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

//        $events = Event::factory()
//            ->published()
//            ->count(10)
//            ->for(
//                Venue::factory()
//                    ->state(function (array $attributes) use ($faker) {
//                        return [
//                            'name' => $faker->randomElement([
//                                'Kenan Memorial Stadium',
//                                'Dix Stadium',
//                                'Beaver Stadium',
//                                'Carrier Dome',
//                                'Carter-Finley Stadium',
//                                'Fred Yager Stadium',
//                                'Dowdy-Ficklen Stadium',
//                                'Folsom Field',
//                                'Floyd Casey Stadium',
//                            ]),
//                            'street' => $faker->streetAddress,
//                            'city' => $faker->city,
//                            'state' => $faker->state,
//                            'zip' => $faker->postcode,
//                        ];
//                    })
//            )
//            ->has(
//                Reservation::factory()
//                    ->count(10)
//                    ->unclaimed()
//                    ->state(function (array $attributes) use ($faker) {
//                        return [
//                            'stand_name' => $faker->randomElement([
//                                "Carrie's Cotton Candy",
//                                "Bob's Burgers",
//                                "Perry's Pizza",
//                                "Sal's Spaghetti",
//                                "Larry's Lemonade",
//                                "Harry's Hibachi",
//                            ]),
//                            'position_type' => $faker->randomElement([
//                                'Food Sales',
//                                'Alcohol Sales',
//                            ]),
//                        ];
//                    })
//                    ->has(
//                        Stand::factory()
//                            ->count(1)
//                            ->state(function (array $attributes, Event $event) use ($faker) {
//                                return [
//                                    'venue_id' => $event->venue->id,
//                                    'location' => 'Stand #' . $faker->numberBetween(1, 25),
//                                ];
//                            })
//                    )
//            )
//            ->create(function () use ($faker) {
//                $start = $faker->dateTimeBetween('now', '+1 month');
//                $end = Carbon::parse($start)->hours(3);
//                return [
//                    'title' => $faker->randomElement([
//                        'UNC vs Virginia Tech',
//                        'Stanford vs Berkley',
//                        'Harvard vs Yale',
//                        'Dallas Baptist vs Syracuse',
//                        'NC State vs Virginia Tech',
//                        'Princeton vs Georgia Tech',
//                        'MIT vs CalTech',
//                        'Cornell vs Miami',
//                        'Fresno State vs Baylor',
//                    ]),
//                    'start' => $start,
//                    'end' => $end
//                ];
//            });

        Event::whereRaw('MOD(id, 2) = 0')->each(function ($event) use ($userA) {
            $event->reservations->first()->update([
                'user_id' => $userA->id,
            ]);
        });
    }
}
