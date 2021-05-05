<?php

namespace App\Listeners;

use App\Events\UserDocumentsReviewed;
use App\Notifications\UserDocumentsApprovedNotification;
use App\Notifications\UserDocumentsRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserDocumentsReviewedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserDocumentsReviewed  $event
     * @return void
     */
    public function handle(UserDocumentsReviewed $event)
    {
        $event->document->review_status === 'approved'
            ? $event->document->user->notify(new UserDocumentsApprovedNotification())
            : $event->document->user->notify(new UserDocumentsRejectedNotification());
    }
}
