<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    public function index()
    {

        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function readAllNotification()
    {

        try {
            DB::beginTransaction();

            Notification::where('user_id', Auth::id())
                ->where('read', false)
                ->update(['read' => true]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'something went wrong while unreading all notifications']);
        }
    }

    public function viewNotification($notificationID)
    {

        try {
            DB::beginTransaction();

            $notification = Notification::findOrFail($notificationID);

            $notification->read = true;
            $notification->save();

            DB::commit();

            return redirect($notification->link);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'error occurred while viewing notification ']);
        }
    }

    public function countUnreadNotifications()
    {

        try {

            $count = Notification::select([DB::raw('COUNT(id) as count')])
                ->where('user_id', Auth::id())
                ->where('read', false)
                ->value('count');

            return response()->json(['count' => $count]);

        } catch (\Exception $e) {
            return response()->json(['unread' => 0], 500);
        }
    }
}
