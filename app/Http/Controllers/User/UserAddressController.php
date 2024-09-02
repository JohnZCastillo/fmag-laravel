<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{

    public function index()
    {
        $addresses = UserAddress::where('user_id', '=', Auth::id())
            ->orderBy('active')
            ->paginate(10);

        return view('user.address', [
            'addresses' => $addresses,
        ]);
    }
}
