<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function orders(Request $request)
    {

        $query = Order::query();

        $query->when($request->input('status') && $request->input('status') != 'all', function ($qb) use ($request) {
            $qb->where('status', OrderStatus::valueOf($request->input('status'))->value);
        });

//        $query->when($request->input('search') && $request->input('status') != 'all', function ($qb) use ($request) {
//            $qb->where('status', OrderStatus::valueOf($request->input('status'))->value);
//        });

        $query->with(['user', 'payment']);

        $orders = $query->paginate();

        return view('admin.orders', [
            'orders' => $orders,
        ]);
    }

    public function order($orderID)
    {

        $order = Order::with([
            'items' => function ($query) {
                $query->select(['order_id', 'product_id', 'quantity' ,'price', DB::raw('SUM(quantity * price) as total')]);

                $query->with(['product' => function ($qb) {
                    $qb->select(['id', 'name']);
                }]);

                $query->groupBy('order_id', 'product_id', 'quantity' ,'price');
            },
            'user',
        ])
            ->withmSum('items',DB::raw('SUM(quantity * price)'))
            ->findOrFail($orderID);

        return view('admin.order', [
            'order' => $order,
        ]);
    }
}
