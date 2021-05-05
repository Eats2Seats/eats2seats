<?php

namespace Tests\Unit\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EnsureUserDocumentsApprovedMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_proceed_if_their_documents_are_approved()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()->create([
            'documents_approved_at' => now(),
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/dashboard');

        // Assert
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_proceed_if_their_documents_are_not_approved()
    {
        // Arrange
        $user = User::factory()->create([
            'documents_approved_at' => null,
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/dashboard');

        // Assert
        $response->assertRedirect(route('volunteer.user-documents.index'));
    }
}
