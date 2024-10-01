<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderCancelledNotification
{
    use AsAction;

    public function handle(Order $order)
    {

        $orderID = $order->id;

        Notification::create([
            'title' => 'Order Cancelled',
            'link' => "/order/$orderID",
            'user_id' =>  $order->user_id,
            'content' => 'Your order was cancelled.'
        ]);

        Notification::create([
            'title' => 'Order Cancelled',
            'link' => "/admin/orders/$orderID",
            'user_id' => UserRole::ADMIN_ID,
            'content' => 'Good day, admin! An order has been cancelled. Please review the details at your earliest convenience.'
        ]);
    }
}
