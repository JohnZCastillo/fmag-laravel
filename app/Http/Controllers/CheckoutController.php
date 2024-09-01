<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function checkout(Order $order)
    {

        return view('order-checkout', [
            'order' => $order,
            'user' => Auth::user(),
        ]);
    }
}
