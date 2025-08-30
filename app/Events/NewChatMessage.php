<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId; // <-- WAJIB ADA
    public $sender;

    public function __construct($message, $userId, $sender = 'user')
    {
        $this->message = $message;
        $this->userId  = $userId; // <-- WAJIB ADA
        $this->sender  = $sender;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('livechat.' . $this->userId),
        ];
    }
}