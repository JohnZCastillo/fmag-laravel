<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceInquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{

    public function index(Service $service)
    {
        $count = ServiceInquiry::select([DB::raw('COUNT(id) as count')])
            ->where('user_id',Auth::id())
            ->where('service_id',$service->id)
            ->where('viewed', false)
            ->value('count');

        return view('user.service', [
            'service' => $service,
            'available' => !$count,
        ]);
    }
}
