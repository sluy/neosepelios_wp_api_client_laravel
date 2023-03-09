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

class Loading implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $instance;

    public $progress;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Instance $instance, $progress)
    {
        $this->instance = $instance;
        $this->progress = $progress;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('instance.' . $this->instance->id);
    }

    public function broadcastAs() {
        return 'whatsapi.loading';
    }
}
