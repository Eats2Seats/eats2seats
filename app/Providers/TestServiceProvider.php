<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        TestResponse::macro('props', function (string|null $key = null): mixed {
            $props = json_decode(json_encode($this->original->getData()['page']['props']), JSON_OBJECT_AS_ARRAY);

            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });

        TestResponse::macro('assertHasProp', function (string $key): TestResponse {
            Assert::assertTrue(Arr::has($this->props(), $key), 'Failed asserting that the response contains the "' . $key . '" prop.');

            /** @var TestResponse $this */
            return $this;
        });

        TestResponse::macro('assertPropValue', function (string $key, mixed $value): TestResponse {
            $this->assertHasProp($key);

            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }

            /** @var TestResponse $this */
            return $this;
        });

        TestResponse::macro('assertPropCount', function (string $key, int $count): TestResponse {
            $this->assertHasProp($key);

            Assert::assertCount($count, $this->props($key));

            /** @var TestResponse $this */
            return $this;
        });

        Collection::macro('assertContains', function ($value) {
            Assert::assertTrue($this->contains($value), "Failed asserting that the collection contains the specified value.");
        });

        Collection::macro('assertNotContains', function ($value) {
            Assert::assertFalse($this->contains($value), "Failed asserting that the collection did not contain the specified value.");
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
