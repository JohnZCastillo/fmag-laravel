<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        $users = User::select(['id', 'name'])
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
        $chat = Chat::where('sender_id',$userID)
            ->orWhere('receiver_id',$userID)
            ->get();

        return view('partials.messages', ['chat' => $chat]);
    }
}
