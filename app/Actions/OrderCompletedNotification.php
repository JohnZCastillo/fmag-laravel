<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderCompletedNotification
{
    use AsAction;

    public function handle(Order $order)
    {

        $orderID = $order->id;

        Notification::create([
            'title' => 'Order',
            'link' => "/order/$orderID",
            'user_id' =>  $order->user_id,
            'content' => 'Your order has been completed.'
        ]);

        Notification::create([
            'title' => 'Order',
            'link' => "/admin/orders/$orderID",
            'user_id' => UserRole::ADMIN_ID,
            'content' => 'Good day, admin! an order has been completed.'
        ]);
    }
}
