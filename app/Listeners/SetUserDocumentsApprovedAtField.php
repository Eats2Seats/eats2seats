<?php

namespace App\Listeners;

use App\Events\UserDocumentsReviewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetUserDocumentsApprovedAtField
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
        if ($event->document->review_status === 'approved') {
            $event->document->user()->update([
                'documents_approved_at' => now(),
            ]);
        }
    }
}
