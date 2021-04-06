<?php

namespace Tests\Feature\Volunteer;

use App\Models\Reservation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewReservationListTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_a_list_of_reservations()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $reservationA = Reservation::factory()->create();
        $reservationB = Reservation::factory()->create();
        $reservationC = Reservation::factory()->create();

        // Act
        $response = $this->get('/volunteer/reservations');

        // Assert
        $reservationA = $reservationA->fresh(['event', 'event.venue']);
        $reservationB = $reservationB->fresh(['event', 'event.venue']);
        $reservationC = $reservationC->fresh(['event', 'event.venue']);

        $response->assertStatus(200)
            ->assertPropCount('next', 3)
            ->assertPropValue('next.id', $reservationA->id)
            ->assertPropCount('next.event', 3)
            ->assertPropValue('next.event', function ($event) use ($reservationA) {
                $this->assertEquals($reservationA->event->title, $event['title']);
                $this->assertEquals($reservationA->event->start, $event['start']);
                $this->assertEquals($reservationA->event->end, $event['end']);
            })
            ->assertPropCount('next.venue', 5)
            ->assertPropValue('next.venue', function ($venue) use ($reservationA) {
                $this->assertEquals($reservationA->event->venue->name, $venue['name']);
                $this->assertEquals($reservationA->event->venue->street, $venue['street']);
                $this->assertEquals($reservationA->event->venue->city, $venue['city']);
                $this->assertEquals($reservationA->event->venue->state, $venue['state']);
                $this->assertEquals($reservationA->event->venue->zip, $venue['zip']);
            })
            ->assertPropCount('reservations', 3)
            ->assertPropValue('reservations', function ($reservations) use ($reservationA, $reservationB, $reservationC) {
                $this->assertContains([
                    'id' => $reservationA->id,
                    'event_title' => $reservationA->event->title,
                    'event_date' => $reservationA->event->start,
                    'venue_name' => $reservationA->event->venue->name,
                    'position_type' => $reservationA->position_type,
                ], $reservations);
                $this->assertContains([
                    'id' => $reservationB->id,
                    'event_title' => $reservationB->event->title,
                    'event_date' => $reservationB->event->start,
                    'venue_name' => $reservationB->event->venue->name,
                    'position_type' => $reservationB->position_type,
                ], $reservations);
                $this->assertContains([
                    'id' => $reservationC->id,
                    'event_title' => $reservationC->event->title,
                    'event_date' => $reservationC->event->start,
                    'venue_name' => $reservationC->event->venue->name,
                    'position_type' => $reservationC->position_type,
                ], $reservations);
            });
    }
}
