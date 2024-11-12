<?php

namespace App\Http\Controllers;

use App\Enums\OrderState;
use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return redirect('/shop')->withErrors(['message' => $e->getMessage()]);
//            return redirect('/shop')->withErrors(['message' => 'Order unavailable']);
        }
    }

    public function confirm(Request $request, Order $order)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png',
                'message' => 'nullable|string|max:50|min:10'
            ]);

            $payment = OrderPayment::where('order_id',$order->id)
                ->firstOrFail();

            if($request->hasFile('image')){

                $filename = $request->file('image')->store('public');

                if(!$filename){
                    throw new \Exception('Unable to upload image');
                }

                $payment->file = $filename;
            }

            if(isset($validated['message'])){
                $payment->message = $validated['message'];
            }

            $payment->save();

            DB::commit();

            return redirect('/shop');

        }catch (\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }

}
