<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderFailedNotification
{
    use AsAction;

    public function handle(Order $order)
    {

        $orderID = $order->id;

        Notification::create([
            'title' => 'Order Failed',
            'link' => "/order/$orderID",
            'user_id' =>  $order->user_id,
            'content' => 'Your order has failed.'
        ]);

        Notification::create([
            'title' => 'Order Failed',
            'link' => "/admin/orders/$orderID",
            'user_id' => UserRole::ADMIN_ID,
            'content' => 'Good day, admin! An order has failed. Please review the details at your earliest convenience.'
        ]);
    }
}
