<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function archiveProduct($productID)
    {
        try {

            DB::beginTransaction();

            Product::where('product_id', $productID)->update([
                'archive' => true
            ]);

            DB::commit();

            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'message' => 'product deletion failed!'
            ]);
        }
    }
}
