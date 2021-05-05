<?php

namespace App\Providers;

use App\Helpers\FileNames\FileNameGenerator;
use App\Helpers\FileNames\RandomFileNameGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileNameGenerator::class, RandomFileNameGenerator::class);

        Str::macro('concat', function(string $str1, string $str2) : string {
            return $str1 . $str2;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
