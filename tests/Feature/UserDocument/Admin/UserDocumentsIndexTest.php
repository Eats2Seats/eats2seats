<?php

namespace Tests\Feature\UserDocument\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inertia\Testing\Assert;
use Tests\TestCase;

class UserDocumentsIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_the_user_documents_index_page()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this
            ->actingAs($user)
            ->get(route('admin.user-documents.index'));

        // Assert
        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/UserDocument/Index')
            );
    }
}
