<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    public function removeItem(CartItem $item)
    {

        try {
            DB::beginTransaction();

            $item->delete();

            DB::commit();

            return redirect()->back();

        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage() ]);
        }
    }
}
