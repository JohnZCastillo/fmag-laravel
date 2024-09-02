<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['category' => function ($query) {
            $query->select(['id', 'name']);
        }])->paginate(20);

        return view('admin.products', [
            'products' => $products
        ]);
    }
}
