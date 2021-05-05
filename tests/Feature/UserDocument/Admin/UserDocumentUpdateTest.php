<?php

namespace Tests\Feature\UserDocument\Admin;

use App\Events\UserDocumentsReviewed;
use App\Models\User;
use App\Models\UserDocument;
use App\Notifications\UserDocumentsApprovedNotification;
use App\Notifications\UserDocumentsRejectedNotification;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserDocumentUpdateTest extends TestCase
{
    use DatabaseMigrations;

    private User $user;
    private User $admin;
    private UserDocument $document;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');
        Notification::fake();

        $this->user = User::factory()->create([
            'documents_approved_at' => null,
        ]);
        $this->admin = User::factory()->create();
        $this->document = UserDocument::factory()
            ->liabilityFile('s3')
            ->taxFile('s3')
            ->reviewPending()
            ->create([
                'user_id' => $this->user->id,
            ]);
    }

    /** @test */
    public function a_user_can_approve_a_user_document()
    {
        $this->withoutExceptionHandling();
        // Act
        $response = $this->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'approved',
                'review_message' => null,
            ]);

        // Assert
        $response->assertOk();
        $this->assertEquals($this->admin->id, $this->document->fresh()->reviewed_by);
        $this->assertEquals('approved', $this->document->fresh()->review_status);
        $this->assertNull($this->document->fresh()->review_message);
        $this->assertNotNull($this->document->fresh()->reviewed_at);
    }

    /** @test */
    public function a_user_can_reject_a_user_document()
    {
        // Act
        $response = $this->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'rejected',
                'review_message' => 'Rejection reason.',
            ]);

        // Assert
        $response->assertOk();
        $this->assertEquals($this->admin->id, $this->document->fresh()->reviewed_by);
        $this->assertEquals('rejected', $this->document->fresh()->review_status);
        $this->assertEquals('Rejection reason.', $this->document->fresh()->review_message);
        $this->assertNotNull($this->document->fresh()->reviewed_at);
    }

    /** @test
     * @throws Exception
     */
    public function user_approved_at_field_is_set_when_a_users_documents_are_approved()
    {
        // Act
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'approved',
                'review_message' => null,
            ]);

        // Assert
        $response->assertOk();
        $this->assertNotNull($this->user->fresh()->documents_approved_at);
    }

    /** @test
     * @throws Exception
     */
    public function user_approved_at_field_is_not_set_when_a_users_documents_are_rejected()
    {
        // Act
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'rejected',
                'review_message' => 'Your documents are not formatted correctly.',
            ]);

        // Assert
        $response->assertOk();
        $this->assertNull($this->user->fresh()->documents_approved_at);
    }

    /** @test
     * @throws Exception
     */
    public function a_user_is_notified_when_their_documents_are_approved()
    {
        // Act
        $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'approved',
                'review_message' => null,
            ]);

        // Assert
        Notification::assertSentTo($this->user->fresh(), UserDocumentsApprovedNotification::class);
    }

    /** @test
     * @throws Exception
     */
    public function a_user_is_notified_when_their_documents_are_rejected()
    {
        // Act
        $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'rejected',
                'review_message' => 'Your documents are not in the right format.',
            ]);

        // Assert
        Notification::assertSentTo($this->user->fresh(), UserDocumentsRejectedNotification::class);
    }

    /** @test */
    public function review_status_is_required()
    {
        //Arrange
        Event::fake();

        // Act
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_message' => 'Test message',
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('review_status');
        $this->assertNull($this->document->fresh()->reviewed_by);
        $this->assertEquals('pending', $this->document->fresh()->review_status);
        $this->assertNull($this->document->fresh()->review_message);
        $this->assertNull($this->document->fresh()->reviewed_at);
        Event::assertNotDispatched(UserDocumentsReviewed::class);
    }

    /** @test */
    public function review_status_must_be_a_string()
    {
        //Arrange
        Event::fake();

        // Act
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 5,
                'review_message' => 'Test message',
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('review_status');
        $this->assertNull($this->document->fresh()->reviewed_by);
        $this->assertEquals('pending', $this->document->fresh()->review_status);
        $this->assertNull($this->document->fresh()->review_message);
        $this->assertNull($this->document->fresh()->reviewed_at);
        Event::assertNotDispatched(UserDocumentsReviewed::class);
    }

    /** @test */
    public function review_status_must_be_either_approved_or_rejected()
    {
        //Arrange
        Event::fake();

        // Act
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'not-approved-or-rejected',
                'review_message' => 'Test message',
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('review_status');
        $this->assertNull($this->document->fresh()->reviewed_by);
        $this->assertEquals('pending', $this->document->fresh()->review_status);
        $this->assertNull($this->document->fresh()->review_message);
        $this->assertNull($this->document->fresh()->reviewed_at);
        Event::assertNotDispatched(UserDocumentsReviewed::class);
    }

    /** @test */
    public function review_message_must_be_present()
    {
        //Arrange
        Event::fake();

        // Act
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'approved',
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('review_message');
        $this->assertNull($this->document->fresh()->reviewed_by);
        $this->assertEquals('pending', $this->document->fresh()->review_status);
        $this->assertNull($this->document->fresh()->review_message);
        $this->assertNull($this->document->fresh()->reviewed_at);
        Event::assertNotDispatched(UserDocumentsReviewed::class);
    }

    /** @test */
    public function review_message_must_be_a_string()
    {
        //Arrange
        Event::fake();

        // Act
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.user-documents.update', ['id' => $this->document->id]), [
                'review_status' => 'approved',
                'review_message' => 9,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('review_message');
        $this->assertNull($this->document->fresh()->reviewed_by);
        $this->assertEquals('pending', $this->document->fresh()->review_status);
        $this->assertNull($this->document->fresh()->review_message);
        $this->assertNull($this->document->fresh()->reviewed_at);
        Event::assertNotDispatched(UserDocumentsReviewed::class);
    }
}
