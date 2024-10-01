<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderDeliveryNotification
{
    use AsAction;

    public function handle(Order $order)
    {

        $orderID = $order->id;

        Notification::create([
            'title' => 'Order Out for Delivery',
            'link' => "/order/$orderID",
            'user_id' =>  $order->user_id,
            'content' => 'Your order is out for delivery.'
        ]);

    }
}
