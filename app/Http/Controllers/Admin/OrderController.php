<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
}
