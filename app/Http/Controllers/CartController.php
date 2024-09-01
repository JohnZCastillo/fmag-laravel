<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index()
    {

        $cart = Cart::where('id', '=', 1)
            ->with(['items' => function ($query) {
                $query->with('product');
            }])->first();

        return view('cart', [
            'cart' => $cart,
        ]);
    }

    public function addCartItem(Request $request, $cartID)
    {

        DB::beginTransaction();

        try {

            $item = CartItem::firstOrCreate([
                'product_id' =>  $request->input('productID'),
                'cart_id' => $cartID
            ]);

            $item->quantity = ($item->quantity ?? 0) + $request->input('quantity');

            $item->save();

            DB::commit();

            return redirect()->back();

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

}
