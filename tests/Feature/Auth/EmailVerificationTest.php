<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\Assert;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    /** @test */
    public function a_user_can_view_the_verify_email_page()
    {
        // Arrange
        $user = User::factory()->unverified()->create();

        // Act
        $response = $this->actingAs($user)
            ->get(route('verification.notice'));

        // Assert
        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Auth/VerifyEmail')
            );
    }

    /** @test */
    public function a_user_can_successfully_verify_their_email()
    {
        // Arrange
        $user = User::factory()->unverified()->create();
        $notification = new VerifyEmailNotification();
        $verificationURL = $notification->verificationUrl($user);

        // Act
        $this->assertNull($user->fresh()->email_verified_at);
        $this->actingAs($user)
            ->get($verificationURL);

        // Assert
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /** @test
     * @throws Exception
     */
    public function a_user_can_resend_the_email_verification_notification()
    {
        // Arrange
        $user = User::factory()->unverified()->create();

        // Act
        $response = $this->actingAs($user)
            ->post('/email/verification-notification');

        // Assert
        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }
}
