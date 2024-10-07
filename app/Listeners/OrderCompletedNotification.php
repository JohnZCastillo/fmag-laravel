<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCompletedNotification implements ShouldQueue
{

    protected \App\Actions\OrderCompletedNotification $orderCompletedNotification;

    /**
     * Create the event listener.
     */
    public function __construct(\App\Actions\OrderCompletedNotification $orderCompletedNotification)
    {
        $this->orderCompletedNotification = $orderCompletedNotification;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCompleted $orderCompleted): void
    {
        $this->orderCompletedNotification->handle($orderCompleted->getOrder());
    }
}
