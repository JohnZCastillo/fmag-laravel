<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function updateDelivery(Request $request)
    {
        try {

            $validated = $request->validate([
                'order_id' => 'required',
                'logistic' => 'required|max:100',
                'tracking' => 'required|max:100',
            ]);

            OrderDelivery::updateOrCreate([
                'order_id' => $validated['order_id']
            ], [
                'logistic' => $validated['logistic'],
                'tracking' => $validated['tracking'],
            ]);

            $order = Order::findOrFail($validated['order_id']);
            $order->status = OrderStatus::DELIVERY;
            $order->save();

            $this->orderDeliveryNotification->handle($order);

            DB::commit();

            return redirect()->back()->with(['message' => 'delivery information updated!']);
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'delivery information update failed']);
        }
    }
}
