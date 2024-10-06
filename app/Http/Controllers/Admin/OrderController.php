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

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request){
                $qb->whereLike('reference', '%'.$request->input('search').'%');

                $qb->orWhereHas('user', function ($query) use ($request){
                    $query->whereLike('name','%'.$request->input('search').'%');
                });

                $qb->orWhereHas('address', function ($query) use ($request){
                    $query->whereLike('address','%'.$request->input('search').'%');
                });

                $qb->orWhereHas('address', function ($query) use ($request){
                    $query->whereLike('address','%'.$request->input('search').'%');
                });

                $qb->orWhereHas('payment', function ($query) use ($request){
                    $query->whereLike('payment_method',$request->input('search').'%');
                });
            });
        });

        $query->with(['user', 'payment']);

        $query->orderBy('updated_at','DESC');

        $orders = $query->paginate(8)->appends($request->except('page'));

        return view('admin.orders', [
            'orders' => $orders,
        ]);
    }

    public function order($orderID)
    {
        $order = Order::withSum('items as total', DB::raw('(quantity * price)'))
            ->with([
                'items' => function ($query) {
                    $query->select(['order_id', 'product_id', 'quantity', 'price', DB::raw('SUM(quantity * price) as total')]);

                    $query->with(['product' => function ($qb) {
                        $qb->select(['id', 'name']);
                    }]);

                    $query->groupBy('order_id', 'product_id', 'quantity', 'price');
                },
                'user',
                'payment',
                'address'
                ])
            ->where('id',$orderID)
            ->firstOrFail();

        $totalCost = $order->total + ($order->address->shipping_fee ?? 0);

        return view('admin.order', [
            'order' => $order,
            'total' => $totalCost
        ]);

    }
}
