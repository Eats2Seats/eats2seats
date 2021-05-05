<?php

namespace Database\Factories;

use App\Facades\FileName;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create();
            },
        ];
    }

    public function liabilityFile(String $disk, UploadedFile $file = null): UserDocumentFactory
    {
        if (!$file) {
            $file = UploadedFile::fake()
                ->create('file-name.pdf', 100, 'application/pdf');
        }
        $name = FileName::generate($file);
        $path = $file->storeAs('user-documents', $name, [
            'disk' => 's3',
            'visibility' => 'private'
        ]);
        return $this->state([
            'liability_file_name' => basename($path),
            'liability_file_url' => Storage::disk($disk)->url($path)
        ]);
    }

    public function taxFile(String $disk, UploadedFile $file = null): UserDocumentFactory
    {
        if (!$file) {
            $file = UploadedFile::fake()
                ->create('file-name.pdf', 100, 'application/pdf');
        }
        $name = FileName::generate($file);
        $path = $file->storeAs('user-documents', $name, [
            'disk' => 's3',
            'visibility' => 'private'
        ]);
        return $this->state([
            'tax_file_name' => basename($path),
            'tax_file_url' => Storage::disk($disk)->url($path)
        ]);
    }

    public function reviewPending(): UserDocumentFactory
    {
        return $this->state([
            'reviewed_by' => null,
            'review_status' => 'pending',
            'review_message' => null,
        ]);
    }

    public function reviewApproved(User $reviewer = null): UserDocumentFactory
    {
        return $this->state([
            'reviewed_by' => $reviewer->id ?? function () {
                    return User::factory()->create();
                },
            'review_status' => 'approved',
            'review_message' => null,
            'reviewed_at' => now(),
        ]);
    }

    public function reviewRejected(User $reviewer = null): UserDocumentFactory
    {
        return $this->state([
            'reviewed_by' => $reviewer->id ?? function () {
                    return User::factory()->create();
                },
            'review_status' => 'rejected',
            'review_message' => 'Reason for rejection.',
            'reviewed_at' => now(),
        ]);
    }
}
