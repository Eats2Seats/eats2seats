<?php

namespace Tests\Feature\Venue\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inertia\Testing\Assert;
use Tests\TestCase;

class VenueCreateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_the_create_page()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this
            ->actingAs($user)
            ->get(route('admin.venues.create'));

        // Assert
        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Venue/Create')
            );
    }
}
