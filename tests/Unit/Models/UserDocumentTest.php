<?php

namespace Tests\Unit\Models;

use Tests\TestCase;

class UserDocumentTest extends TestCase
{
    /** @test */
    public function a_user_is_notified_when_their_document_is_approved()
    {
        // Arrange
        Notification::fake();

        // Act

        // Assert
    }
}
