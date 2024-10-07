<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderRejected
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
