<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Clockwork\Support\Laravel\Tests\UsesClockwork;
use Illuminate\Support\Collection;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

//        $this->setUpClockwork();

        Collection::macro('assertHas', function ($value) {
            \PHPUnit\Framework\Assert::assertTrue(
                $this->contains($value),
                'Failed asserting that the value is contained in the collection.'
            );
        });

        Collection::macro('assertMissing', function ($value) {
            \PHPUnit\Framework\Assert::assertFalse(
                $this->contains($value),
                'Failed asserting that the value is contained in the collection.'
            );
        });

    }
}
