<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

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

}
