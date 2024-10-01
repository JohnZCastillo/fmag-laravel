<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesService
{

    public function getSales($from, $to): float
    {
        $from = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i');
        $to = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i');

        return OrderItem::select([DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')])
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where(function ($query) use ($from, $to) {
                $query->where('orders.created_at', '>=', $from)
                    ->where('orders.created_at', '<=', $to)
                    ->where('orders.status', OrderStatus::COMPLETED->value);
            })
            ->value('total_sales') ?? 0;
    }

    public function countTodayOrders(): float
    {

        $start = Carbon::now()->startOfDay()->format('Y-m-d H:i');
        $end = Carbon::now()->endOfDay()->format('Y-m-d H:i');

        return Order::select([DB::raw('COUNT(id) as orders')])
            ->where('status', OrderStatus::COMPLETED->value)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->where('created_at', OrderStatus::COMPLETED->value)
            ->value('orders') ?? 0;

    }

}
