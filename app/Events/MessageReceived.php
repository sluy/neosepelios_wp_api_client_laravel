<?php

namespace App\Events;

use App\Models\Instance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $instance;

    public $chatId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Instance $instance, $chatId)
    {
        $this->instance = $instance;
        $this->chatId = $chatId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('instance.' . $this->instance->id);
    }

    public function broadcastAs() {
        return 'whatsapi.message_received';
    }
}
