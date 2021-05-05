<?php

namespace Tests\Feature\UserDocument\Volunteer;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Tests\TestCase;

class UserDocumentIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_without_approved_documents_can_view_the_user_document_page()
    {
        // Arrange
        $user = User::factory()->documentsUnapproved()->create();

        // Act
        $response = $this
            ->actingAs($user)
            ->get(route('volunteer.user-documents.index'));

        // Assert
        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Volunteer/UserDocument/Index')
            );
    }
}
