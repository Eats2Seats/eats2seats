<?php

namespace Tests\Unit\Helpers;

use App\Helpers\FileNames\RandomFileNameGenerator;
use Tests\TestCase;

class RandomFileNameGeneratorTest extends TestCase
{
    /** @test */
    public function must_be_32_characters_long()
    {
        // Arrange
        $generator = new RandomFileNameGenerator;

        // Act
        $fileName = $generator->generate();

        // Assert
        $this->assertEquals(32, strlen($fileName));
    }

    /** @test */
    public function can_only_contain_letters_and_numbers()
    {
        // Arrange
        $generator = new RandomFileNameGenerator;

        // Act
        $fileName = $generator->generate();

        // Assert
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]+$/', $fileName);
    }

    /** @test */
    public function file_names_must_be_unique()
    {
        // Arrange
        $generator = new RandomFileNameGenerator;

        // Act
        $fileNames = array_map(function ($i) use ($generator) {
            return $generator->generate();
        }, range(1, 100));

        // Assert
        $this->assertCount(100, array_unique($fileNames));
    }
}
