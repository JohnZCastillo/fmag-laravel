<?php

namespace App\Http\Controllers;

use App\Enums\CheckoutType;
use App\Enums\OrderState;
use App\Enums\PaymentMethod;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    public function checkout($orderID)
    {

        try {

            $query = Order::query();

            $query->where('id', '=', $orderID)
                ->where('user_id', '=', Auth::id())
                ->where('state', '=', OrderState::PENDING->value)
                ->with(
                    [
                        'items' => function ($query) {

                            $query->select(['id', 'product_id', 'order_id', 'quantity', 'price', DB::raw('SUM(quantity * price) as total')]);

                            $query->with('product', function ($query) {
                                $query->select(['id', 'name', 'image']);
                            });

                            $query->groupBy('id', 'product_id', 'order_id', 'quantity', 'price');

                        },
                        'user',
                        'payment',
                        'delivery',
                    ]
                );

            $order = $query->firstOrFail();

            $total = OrderItem::select(['order_id', DB::raw('SUM(quantity * price) as total')])
                ->where('order_id', '=', $orderID)
                ->groupBy('order_id')
                ->get()
                ->value('total');

            return view('order-checkout', [
                'total' => $total,
                'order' => $order,
                'user' => Auth::user(),
            ]);

        } catch (\Exception $e) {
            return redirect('/')->withErrors(['message' => 'Order unavailable']);
        }
    }

    public function confirmCheckout(Request $request, Order $order)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'paymentMethod' => 'required',
                'total' => 'required|numeric',
            ]);

            $cart = Cart::where('user_id',Auth::id())
                ->firstOrFail();

            $paymentMethod = PaymentMethod::valueOf($validated['paymentMethod']);


            OrderPayment::create([
                'payment_method' => $paymentMethod->value,
                'order_id' => $order->id,
            ]);

            if ($paymentMethod == PaymentMethod::GCASH) {
                $order->state = OrderState::PAYMENT;
            } else {
                $order->state = OrderState::PROCESSING;
            }

            $order->save();

            foreach ($order->items as $item) {

                $product = $item->product;

                if ($item->quantity > $product->stock) {
                    throw new \Exception('insufficient product stock');
                }

                $product->stock -= $item->quantity;
                $product->save();
            }

            if($order->checkout_type == CheckoutType::CART &&  PaymentMethod::CASH){
                CartItem::where('cart_id',$cart->id)
                    ->delete();
            }

            $this->orderCreatedNotification->handle($order);

            DB::commit();

            if ($order->state === OrderState::PAYMENT) {
                return redirect()->route('gcash', ['orderID' => $order->id]);
            }

            return redirect('/shop')->with('message', 'Order Completed');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function cartCheckout(Request $request)
    {

        try {

            DB::beginTransaction();

            $cart = Cart::where('user_id', Auth::id())
                ->with(['items' => function ($query) {
                    $query->with(['product' => function ($query) {
                        $query->select(['id', 'price','stock']);
                    }]);

                }])
                ->firstOrFail();

            if ($cart->items->isEmpty()) {
                throw new \Exception('cart is empty');
            }

            $order = new Order();
            $order->user_id = Auth::id();
            $order->save();

            foreach ($cart->items as $item) {

                $product = $item->product;

                if ($item->quantity > $product->stock) {
                    throw new \Exception('insufficient product stock');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }


            DB::commit();

            return redirect()->route('checkout', ['orderID' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function productCheckout(Request $request)
    {

        try {

            $validated = $request->validate([
                'product_id' => 'required',
                'quantity' => 'required',
            ]);

            DB::beginTransaction();

            $order = new Order();
            $order->user_id = Auth::id();
            $order->save();

            $product = Product::findOrFail($validated['product_id']);

            if($validated['quantity'] > $product->stock){
                throw new \Exception('insufficient product stock');
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $validated['quantity'],
            ]);

            DB::commit();

            return redirect()->route('checkout', ['orderID' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

}
