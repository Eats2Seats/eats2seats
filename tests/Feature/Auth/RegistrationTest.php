<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\Assert;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    /** @test */
    public function a_guest_can_view_the_account_registration_page()
    {
        // Act
        $response = $this->get(route('auth.register'));

        // Assert
        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Auth/Register')
            );
    }

    /** @test
     * @throws Exception
     */
    public function a_guest_can_successfully_register_for_an_account()
    {
        $this->withoutExceptionHandling();

        // Act
        $this->post('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $user = User::firstWhere('email', 'john@doe.com');

        // Assert
        $this->assertAuthenticated();
        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_registration_page()
    {
        // Arrange
        $user = User::factory()->unverified()->create();

        // Act
        $response = $this->actingAs($user)
            ->get(route('auth.register'));

        // Assert
        $response->assertRedirect();
    }
}
