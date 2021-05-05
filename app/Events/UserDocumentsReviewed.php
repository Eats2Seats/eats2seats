<?php

namespace App\Events;

use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserDocumentsReviewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UserDocument $document;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserDocument $document)
    {
        $this->document = $document;
    }
}
