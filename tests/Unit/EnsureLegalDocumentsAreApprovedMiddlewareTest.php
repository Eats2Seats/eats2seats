<?php

namespace Tests\Unit;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EnsureLegalDocumentsAreApprovedMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_proceed_if_their_legal_documents_are_approved()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()->create([
            'documents_approved_at' => Carbon::now(),
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/dashboard');

        // Assert
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_proceed_if_their_legal_documents_are_not_approved()
    {
        // Arrange
        $user = User::factory()->create([
            'documents_approved_at' => null,
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get('/dashboard');

        // Assert
        $response->assertRedirect('pending-approval');
    }
}
