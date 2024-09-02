<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index()
    {

        try {

            $cart = Cart::with(['items' => function ($query) {
                $query->with('product');
            }])->first();

            $total = CartItem::select(['cart_id', DB::raw('SUM(quantity * price) as total')])
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->where('cart_id', '=', $cart->id)
                ->groupBy('cart_id')
                ->get()
                ->value('total');

            return view('cart', [
                'cart' => $cart,
                'total' => $total,
            ]);

        } catch (\Exception $e) {
            return redirect('/')->withErrors(['message' => 'unable to load cart']);
        }
    }

    public function addCartItem(Request $request, $cartID)
    {

        DB::beginTransaction();

        try {

            $item = CartItem::firstOrCreate([
                'product_id' => $request->input('productID'),
                'cart_id' => $cartID
            ]);

            $item->quantity = ($item->quantity ?? 0) + $request->input('quantity');

            $item->save();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

}
