<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {

        $arrivals = Product::select(['id','name','image','category_id'])
            ->with(['category' => function ($query) {
            $query->where(function ($query) {
                $query->where('name', 'new arrivals');
            });
        }])
            ->take(10)
            ->get();

        return view('homepage', [
            'arrivals' => $arrivals,
        ]);
    }
}
