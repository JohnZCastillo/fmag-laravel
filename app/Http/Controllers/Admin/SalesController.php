<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index(Request $request)
    {

        $query = OrderItem::query();

        $query->select(['products.name', 'stock', DB::raw('SUM(order_items.quantity) as sold'), DB::raw('SUM(order_items.quantity * order_items.price) as sales')])
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', OrderStatus::COMPLETED->value)
            ->groupBy('products.id', 'products.name', 'products.stock');

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->whereLike('products.name', '%' . $request->input('search') . '%');
        });

        $items = $query->paginate(5);

        return view('admin.sales', [
            'items' => $items,
        ]);
    }
}
