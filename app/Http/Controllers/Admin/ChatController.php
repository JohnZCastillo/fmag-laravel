<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function index()
    {

        $users = User::select(['id', 'name'])
            ->whereNotIn('id', [Auth::id()])
            ->get();

        return view('admin.messages-preselect', [
            'users' => $users
        ]);
    }

    public function userChat($userID)
    {

        $user = User::findOrFail($userID);

        $users = User::select(['id', 'name','last_name'])
            ->whereNotIn('id', [Auth::id()])
            ->get();

        return view('admin.messages', [
            'user' => $user,
            'users' => $users
        ]);
    }

    public function addMessage(Request $request, $userID)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'content' => 'required|string'
            ]);

            Chat::create([
                'content' => $validated['content'],
                'sender_id' => Auth::id(),
                'receiver_id' => $userID
            ]);

            DB::commit();

            return response()->json(['message' => 'sent']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'sent'], 400);
        }
    }

    public function messages($userID)
    {

        $chat = Chat::with('user')
            ->where(function ($query) use ($userID) {
                $query->where('sender_id', $userID)
                    ->where('receiver_id', UserRole::ADMIN_ID);
            })
            ->orWhere(function ($query) use ($userID) {
                $query->where('sender_id', UserRole::ADMIN_ID)
                    ->where('receiver_id', $userID);
            })
            ->get();

        return view('partials.messages', ['chat' => $chat]);
    }
}
