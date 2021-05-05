<?php

namespace Tests\Feature\UserDocument\Volunteer;

use App\Facades\FileName;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserDocumentStoreTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');
    }

    /** @test */
    public function a_user_can_upload_their_document()
    {
        // Arrange
        FileName::shouldReceive('generate')->once()->andReturn('LiabilityFileRandomName.pdf');
        FileName::shouldReceive('generate')->once()->andReturn('TaxFileRandomName.pdf');

        $user = User::factory()->create();
        $liabilityFile = UploadedFile::fake()
            ->create('liability-waiver.pdf', 100, 'application/pdf');
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'application/pdf');

        // Act
        $this->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => $taxFile,
            ])
            ->assertOk();

        // Assert
        Storage::disk('s3')
            ->assertExists('user-documents/LiabilityFileRandomName.pdf')
            ->assertExists('user-documents/TaxFileRandomName.pdf');

        $document = UserDocument::first();
        $this->assertEquals($user->id, $document->user_id);
        $this->assertEquals('LiabilityFileRandomName.pdf', $document->liability_file_name);
        $this->assertEquals(
            Storage::disk('s3')->url('user-documents/LiabilityFileRandomName.pdf'),
            $document->liability_file_url
        );
        $this->assertEquals('TaxFileRandomName.pdf', $document->tax_file_name);
        $this->assertEquals(
            Storage::disk('s3')->url('user-documents/TaxFileRandomName.pdf'),
            $document->tax_file_url
        );
        $this->assertNull($document->reviewed_by);
        $this->assertEquals('pending', $document->review_status);
        $this->assertNull($document->review_message);
        $this->assertNull($document->reviewed_at);
    }

    /** @test */
    public function a_user_with_pending_documents_cannot_upload_additional_documents()
    {
        // Arrange
        $user = User::factory()->documentsUnapproved()->create();
        $pendingDocuments = UserDocument::factory()
            ->liabilityFile('s3')
            ->taxFile('s3')
            ->reviewPending()
            ->create([
                'user_id' => $user->id,
            ]);
        $liabilityFile = UploadedFile::fake()
            ->create('liability-waiver.pdf', 100, 'application/pdf');
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => $taxFile,
            ]);

        // Assert
        $response->assertForbidden();
        $this->assertEquals(1, $user->fresh()->documents->count());
    }

    /** @test */
    public function a_user_with_approved_documents_cannot_upload_additional_documents()
    {
        // Arrange
        $user = User::factory()->documentsUnapproved()->create();
        $pendingDocuments = UserDocument::factory()
            ->liabilityFile('s3')
            ->taxFile('s3')
            ->reviewApproved()
            ->create([
                'user_id' => $user->id,
            ]);
        $liabilityFile = UploadedFile::fake()
            ->create('liability-waiver.pdf', 100, 'application/pdf');
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => $taxFile,
            ]);

        // Assert
        $response->assertForbidden();
        $this->assertEquals(1, $user->fresh()->documents->count());
    }

    /** @test */
    public function liability_file_is_required()
    {
        // Arrange
        $user = User::factory()->create();
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
               'liability_file' => null,
               'tax_file' => $taxFile,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('liability_file');
        $this->assertEquals(0, UserDocument::count());
    }

    /** @test */
    public function liability_file_must_be_of_type_file()
    {
        // Arrange
        $user = User::factory()->create();
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => 'not-a-file.pdf',
                'tax_file' => $taxFile,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('liability_file');
        $this->assertEquals(0, UserDocument::count());
    }

    /** @test */
    public function liability_file_must_have_a_pdf_mimetype()
    {
        // Arrange
        $user = User::factory()->create();
        $liabilityFile = UploadedFile::fake()
            ->create('liability-form.pdf', 100, 'video/avi');
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => $taxFile,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('liability_file');
        $this->assertEquals(0, UserDocument::count());
    }

    /** @test */
    public function liability_file_cannot_be_larger_than_1000kb()
    {
        // Arrange
        $user = User::factory()->create();
        $liabilityFile = UploadedFile::fake()
            ->create('liability-form.pdf', 1001, 'application/pdf');
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => $taxFile,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('liability_file');
        $this->assertEquals(0, UserDocument::count());
    }

    /** @test */
    public function tax_file_is_required()
    {
        // Arrange
        $user = User::factory()->create();
        $liabilityFile = UploadedFile::fake()
            ->create('liability-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => null,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('tax_file');
        $this->assertEquals(0, UserDocument::count());
    }

    /** @test */
    public function tax_file_must_be_of_type_file()
    {
        // Arrange
        $user = User::factory()->create();
        $liabilityFile = UploadedFile::fake()
            ->create('liability-form.pdf', 100, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => 'not-a-file.pdf',
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('tax_file');
        $this->assertEquals(0, UserDocument::count());
    }

    /** @test */
    public function tax_file_must_have_a_pdf_mimetype()
    {
        // Arrange
        $user = User::factory()->create();
        $liabilityFile = UploadedFile::fake()
            ->create('liability-form.pdf', 100, 'application/pdf');
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 100, 'video/avi');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => $taxFile,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('tax_file');
        $this->assertEquals(0, UserDocument::count());
    }

    /** @test */
    public function tax_file_cannot_be_larger_than_1000kb()
    {
        // Arrange
        $user = User::factory()->create();
        $liabilityFile = UploadedFile::fake()
            ->create('liability-form.pdf', 100, 'application/pdf');
        $taxFile = UploadedFile::fake()
            ->create('tax-form.pdf', 1001, 'application/pdf');

        // Act
        $response = $this
            ->actingAs($user)
            ->post(route('volunteer.user-documents.store'), [
                'liability_file' => $liabilityFile,
                'tax_file' => $taxFile,
            ]);

        // Assert
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('tax_file');
        $this->assertEquals(0, UserDocument::count());
    }
}
