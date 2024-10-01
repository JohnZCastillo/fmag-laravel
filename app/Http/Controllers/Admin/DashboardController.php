<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SalesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    protected $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->salesService = $salesService;
    }

    public function index()
    {

        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $sales = $this->salesService->getSales($from,$to);
        $orders = $this->salesService->countTodayOrders();
        $products = 123;

        $salesData = [];

        return view('admin.dashboard', [
            'sales' => $sales,
            'orders' => $orders,
            'products' => $products,
            'salesData' => $salesData,
        ]);
    }
}
