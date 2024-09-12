<?php

namespace App\Http\Controllers;

use App\Enums\OrderState;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index($orderID)
    {
        try {

            $order = Order::with('payment')
                ->findOrFail($orderID);

            if ($order->state != OrderState::PAYMENT) {
                throw new \Exception('Invalid order');
            }

            return view('gcash', [
                'order' => $order,
            ]);

        } catch (\Exception $e) {
            return  $e->getMessage();
//            return redirect('/shop')->withErrors(['message' => 'Order unavailable']);
        }
    }
}
