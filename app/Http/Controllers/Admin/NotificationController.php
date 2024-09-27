<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {

        $ADMIN_ID = 1;

        $notifications = Notification::where('user_id',$ADMIN_ID)
            ->paginate(20);

        return view('admin.notifications', [
            'notifications' => $notifications
        ]);
    }
}
