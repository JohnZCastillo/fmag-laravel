<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderState;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders()
    {
        $query = Order::query();

        $query->where('user_id', Auth::id())
            ->with([
                'payment',
            ])
            ->whereIn('state', [
                OrderState::PROCESSING->value,
                OrderState::COMPLETED->value,
                OrderState::PAYMENT->value,
            ]);

        $orders = $query->paginate();

        return view('user.orders', [
            'orders' => $orders,
        ]);

    }

    public function orderComplete($orderID)
    {

        try {

            DB::beginTransaction();

            $order = Order::findOrFail($orderID);
            $order->status = OrderStatus::COMPLETED;
            $order->state = OrderState::COMPLETED;
            $order->save();

            $this->orderCompletedNotification->handle($order);

            DB::commit();

            return redirect()->back()->with(['message' => 'order completed!']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'order update failed!']);
        }
    }

    public function orderFailed(Request $request, $orderID)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'reason' => 'required|string',
            ]);

            $order = Order::findOrFail($orderID);
            $order->status = OrderStatus::FAILED;
            $order->reason = $validated['reason'];


            if($order->payment->payment_method == PaymentMethod::GCASH){
                $order->refunded = true;
            }

            $order->save();

            $this->orderFailedNotification->handle($order);

            DB::commit();

            return redirect()->back()->with(['message' => 'order updated']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'order update failed!']);
        }
    }

    public function cancelOrder(Request $request, $orderID)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'reason' => 'required|string',
            ]);

            $order = Order::findOrFail($orderID);
            $order->status = OrderStatus::CANCELLED;
            $order->reason = $validated['reason'];

            if($order->payment->payment_method == PaymentMethod::GCASH){
                $order->refunded = true;
            }

            $order->save();

            $this->orderCancelledNotification->handle($order);

            DB::commit();

            return redirect()->back()->with(['message' => 'order updated']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return  $request->all();

//            return  $exception->getMessage();
//            return redirect()->back()->withErrors(['message' => 'order update failed!']);
        }
    }

    public function order($orderID)
    {

        $query = Order::query();

        $query->with(
                [
                    'items' => function ($query) {

                        $query->select(['id', 'product_id', 'order_id', 'quantity', 'price', DB::raw('SUM(quantity * price) as total')]);

                        $query->with('product', function ($query) {
                            $query->select(['id', 'name']);
                        });

                        $query->groupBy('id', 'product_id', 'order_id', 'quantity', 'price');

                    },
                    'user',
                    'payment',
                    'delivery',
                ]
            )
            ->withSum('items as total',DB::raw('(quantity * price)'))
            ->findOrFail($orderID);

        $total = 0;

        return view('user.order', [
            'order' => $query->first(),
            'total' => $total,
        ]);

    }
}
