<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::select(['id','name'])
            ->with('products')->get();

        return view('shop',[
            'categories' => $categories,
        ]);

    }
}
