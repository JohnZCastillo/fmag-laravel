<?php

namespace App\Listeners;

use App\Events\OrderDelivery;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDeliveryNotification implements ShouldQueue
{

    protected \App\Actions\OrderDeliveryNotification $orderDeliveryNotification;

    /**
     * @param \App\Actions\OrderDeliveryNotification $orderDeliveryNotification
     */
    public function __construct(\App\Actions\OrderDeliveryNotification $orderDeliveryNotification)
    {
        $this->orderDeliveryNotification = $orderDeliveryNotification;
    }


    /**
     * Handle the event.
     */
    public function handle(OrderDelivery $orderDelivery): void
    {
        $this->orderDeliveryNotification->handle($orderDelivery->getOrder());
    }
}
