<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderState;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orders()
    {
        $query = Order::query();

        $query->where('user_id', '=', 1)
            ->whereIn('state', [
                OrderState::PROCESSING->value,
                OrderState::COMPLETED->value,
                OrderState::PAYMENT->value,
            ]);

        $orders = $query->paginate();

        return view('user.orders', [
            'orders' => $orders,
        ]);

    }

    public function order($orderID)
    {

        $query = Order::query();

        $query->where('id', '=', $orderID)
            ->with(
                [
                    'items' => function ($query) {

                        $query->select(['id', 'product_id', 'order_id', 'quantity', 'price', DB::raw('SUM(quantity * price) as total')]);

                        $query->with('product', function ($query) {
                            $query->select(['id', 'name']);
                        });

                        $query->groupBy('id', 'product_id', 'order_id', 'quantity', 'price');

                    },
                    'user',
                    'payment',
                    'delivery',
                ]
            );

        $total = OrderItem::select(['order_id', DB::raw('SUM(quantity * price) as total')])
            ->where('order_id', '=', $orderID)
            ->groupBy('order_id')
            ->get()
            ->value('total');

        return view('user.order', [
            'order' => $query->first(),
            'total' => $total,
        ]);

    }
}
