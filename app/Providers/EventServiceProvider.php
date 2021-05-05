<?php

namespace App\Providers;

use App\Events\LegalDocumentsReviewed;
use App\Events\UserDocumentsReviewed;
use App\Listeners\SendLegalDocumentsReviewedNotification;
use App\Listeners\SendUserDocumentsReviewedNotification;
use App\Listeners\SetUserDocumentsApprovedAtField;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserDocumentsReviewed::class => [
            SetUserDocumentsApprovedAtField::class,
            SendUserDocumentsReviewedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
