<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderState;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Events\OrderCancelled;
use App\Events\OrderRejected;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $query = Order::query();

        $query->where('user_id', Auth::id())
            ->with([
                'payment',
                'feedbacks'
            ])
            ->whereIn('state', [
                OrderState::PROCESSING->value,
                OrderState::COMPLETED->value,
                OrderState::PAYMENT->value,
            ])
        ->orderBy('created_at','DESC');

        $orders = $query->paginate(8)->appends($request->except('page'));

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

            $order = Order::with(['user'])->findOrFail($orderID);
            $order->status = OrderStatus::FAILED;
            $order->reason = $validated['reason'];

            if($order->payment->payment_method == PaymentMethod::GCASH){
                $order->refunded = true;
            }

            $order->save();

            DB::commit();

            OrderRejected::dispatch($order);

            return redirect()->back()->with(['message' => 'order rejected']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'order rejection failed!']);
        }
    }

    public function cancelOrder(Request $request, $orderID)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'reason' => 'required|string',
            ]);

            $order = Order::with([
                'user'
            ])->findOrFail($orderID);

            $order->status = OrderStatus::CANCELLED;
            $order->reason = $validated['reason'];

            if($order->payment->payment_method == PaymentMethod::GCASH){
                $order->refunded = true;
            }

            $order->save();

            DB::commit();

            OrderCancelled::dispatch($order);

            return redirect()->back()->with(['message' => 'order cancelled']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'order cancellation failed!']);
        }
    }

    public function order($orderID)
    {

        $order = Order::with(
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
            ->where('id',$orderID)
            ->firstOrFail();

        $totalCost = $order->total + ($order->address->shipping_fee ?? 0);

        return view('user.order', [
            'order' => $order,
            'total' => $totalCost,
        ]);

    }
}
