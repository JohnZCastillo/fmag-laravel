<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SalesService;
use Carbon\Carbon;
use Carbon\Month;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    protected $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->salesService = $salesService;
    }

    public function index()
    {

        $now = Carbon::now()->format('Y-m-d H:i');

        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $sales = $this->salesService->getSales($from, $to);
        $orders = $this->salesService->countTodayOrders();

        $products = Product::select([DB::raw('COUNT(id) as total')])
            ->where('created_at', '>=', $now)
            ->where('created_at', '<=', $now)
            ->value('total');

        $salesData = OrderItem::select(['products.name', 'products.price', DB::raw('SUM(order_items.quantity) as sold'), DB::raw('SUM(order_items.quantity * order_items.price) as total')])
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', OrderStatus::COMPLETED->value)
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('sold','DESC')
            ->take(5)
            ->get();

        $monthlySales = [
            $this->salesService->getMonthlySales(Month::January),
            $this->salesService->getMonthlySales(Month::February),
            $this->salesService->getMonthlySales(Month::March),
            $this->salesService->getMonthlySales(Month::April),
            $this->salesService->getMonthlySales(Month::May),
            $this->salesService->getMonthlySales(Month::June),
            $this->salesService->getMonthlySales(Month::July),
            $this->salesService->getMonthlySales(Month::August),
            $this->salesService->getMonthlySales(Month::September),
            $this->salesService->getMonthlySales(Month::October),
            $this->salesService->getMonthlySales(Month::November),
            $this->salesService->getMonthlySales(Month::December),
        ];

        return view('admin.dashboard', [
            'sales' => $sales,
            'orders' => $orders,
            'products' => $products,
            'salesData' => $salesData,
            'monthlySales' => $monthlySales,
        ]);
    }
}
