<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreatedNotification implements ShouldQueue
{

    protected \App\Actions\OrderCreatedNotification $orderCreatedNotification;

    /**
     * @param \App\Actions\OrderCreatedNotification $orderCreatedNotification
     */
    public function __construct(\App\Actions\OrderCreatedNotification $orderCreatedNotification)
    {
        $this->orderCreatedNotification = $orderCreatedNotification;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $orderCreated): void
    {
        $this->orderCreatedNotification->handle($orderCreated->getOrder());
    }
}
