<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inertia\Testing\Assert;
use Tests\TestCase;

class VolunteerDashboardTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_the_dashboard()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this
            ->actingAs($user)
            ->get(route('volunteer.dashboard'));

        // Assert
        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Volunteer/Dashboard')
            );
    }
}
