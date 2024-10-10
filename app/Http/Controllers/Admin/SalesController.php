<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
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

    public function getSalesInRange(Request $request)
    {
        try {

            $items = OrderItem::select(['products.name', 'order_items.price','stock', DB::raw('SUM(order_items.quantity) as sold'), DB::raw('SUM(order_items.quantity * order_items.price) as sales')])
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->when($request->input('from'), function ($query) use ($request) {
                    $from = Carbon::parse($request->input('from'))->startOfDay()->format('Y-m-d H:i');
                    $query->where('orders.created_at', '>=', $from);
                })
                ->when($request->input('to'), function ($query) use ($request) {
                    $to = Carbon::parse($request->input('to'))->startOfDay()->format('Y-m-d H:i');
                    $query->where('orders.created_at', '<=', $to);
                })
                ->where('orders.status', OrderStatus::COMPLETED->value)
                ->groupBy('products.id', 'products.name', 'products.stock','order_items.price')
                ->get();

            $total = OrderItem::select([DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')])
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->when($request->input('from'), function ($query) use ($request) {
                    $from = Carbon::parse($request->input('from'))->startOfDay()->format('Y-m-d H:i');
                    $query->where('orders.created_at', '>=', $from);
                })
                ->when($request->input('to'), function ($query) use ($request) {
                    $to = Carbon::parse($request->input('to'))->startOfDay()->format('Y-m-d H:i');
                    $query->where('orders.created_at', '<=', $to);
                })
                ->where('orders.status', OrderStatus::COMPLETED->value)
                ->value('total_sales');

            $coverage = '';

            if($request->input('from')){
                $coverage .= $request->input('from');
            }

            if($request->input('to')){
                $coverage .= ' - ' . $request->input('to');
            }

            $reportData = [
                'items' => $items,
                'total' => $total,
                'coverage' => $coverage
            ];

            session(['reportData' => $reportData]);

            return view('admin.report-preview', $reportData);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
