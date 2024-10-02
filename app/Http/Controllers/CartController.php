<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
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
            }])->where('user_id', Auth::id())->firstOrFail();

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

    public function addCartItem(Request $request)
    {

        DB::beginTransaction();

        try {

            $validated = $request->validate([
                'product_id' => 'required',
                'quantity' => 'required|min:1'
            ]);

            $cart = Cart::select(['id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $product = Product::select(['id', 'stock'])
                ->findOrFail($validated['product_id']);

            $item = CartItem::where('product_id',$validated['product_id'])
                ->where('cart_id',$cart->id)
                ->first();

            if ($item) {
                $item->quantity = $item->quantity + $validated['quantity'];
            } else {
                $item = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity']
                ]);
            }

            if ($item->quantity > $product->stock) {
                $item->quantity = $product->stock;
            }

            $item->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'added to cart']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

}
