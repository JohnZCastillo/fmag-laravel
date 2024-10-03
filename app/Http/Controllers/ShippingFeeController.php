<?php

namespace App\Http\Controllers;

use App\Actions\ShippingFee;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingFeeController extends Controller
{
    public function getShippingFee(Request $request, ShippingFee $shippingFee)
    {

        try {

            $validated = $request->validate([
//                'order_id' => 'required',
                'address_id' => 'required',
            ]);

//            $total = OrderItem::select(['order_id', DB::raw('SUM(quantity * price) as total')])
//                ->where('order_id', '=', $validated['order_id'])
//                ->groupBy('order_id')
//                ->get()
//                ->value('total');

            $address = UserAddress::select(['province'])
                ->findOrFail($validated['address_id']);

            $shipping = $shippingFee->handle($address->province);

            return response()->json([
//                'total' => $total,
                'shipping' => $shipping,
            ]);

        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
//            return response()->json(['message' => 'something went wrong'], 500);
        }
    }
}
