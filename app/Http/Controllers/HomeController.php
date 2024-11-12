<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {

        $arrivals = Product::with(['image'])
            ->whereHas('category', function ($qb) {
                $qb->where('name', 'new products');
            })
            ->take(10)
            ->get();

        return view('homepage', [
            'arrivals' => $arrivals,
        ]);
    }
}
