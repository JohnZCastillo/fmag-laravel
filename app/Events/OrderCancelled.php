<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCancelled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private \App\Models\Order $order;

    /**
     * Create a new event instance.
     */
    public function __construct(\App\Models\Order $order)
    {
        $this->order = $order;
    }

    public function getOrder(): \App\Models\Order
    {
        return $this->order;
    }

}
