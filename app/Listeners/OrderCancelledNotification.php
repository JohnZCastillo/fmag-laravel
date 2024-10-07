<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCancelledNotification implements ShouldQueue
{

    protected \App\Actions\OrderCancelledNotification $orderCancelledNotification;

    /**
     * Create the event listener.
     */
    public function __construct(\App\Actions\OrderCancelledNotification $orderCancelledNotification)
    {
        $this->orderCancelledNotification = $orderCancelledNotification;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCancelled $orderCancelled): void
    {
        $this->orderCancelledNotification->handle($orderCancelled->getOrder());
    }
}
