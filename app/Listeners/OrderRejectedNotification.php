<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Events\OrderRejected;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderRejectedNotification implements ShouldQueue
{

    protected \App\Actions\OrderFailedNotification $orderFailedNotification;

    /**
     * Create the event listener.
     */
    public function __construct(\App\Actions\OrderFailedNotification $orderFailedNotification)
    {
        $this->orderFailedNotification = $orderFailedNotification;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderRejected $orderRejected): void
    {
        $this->orderFailedNotification->handle($orderRejected->getOrder());
    }
}
