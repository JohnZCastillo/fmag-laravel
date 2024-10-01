<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderCreatedNotification
{
    use AsAction;

    public function handle(Order $order)
    {

        $orderID = $order->id;

        Notification::create([
            'title' => 'Order Completed',
            'link' => "/order/$orderID",
            'user_id' =>  $order->user_id,
            'content' => 'Your order has been placed.'
        ]);

        Notification::create([
            'title' => 'Order Completed',
            'link' => "/admin/orders/$orderID",
            'user_id' => UserRole::ADMIN_ID,
            'content' => 'Good day, admin! A new order has been placed. Please review the details at your earliest convenience.'
        ]);
    }
}
