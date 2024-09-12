<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function userChat()
    {
        return view('user.messages');
    }

    public function getMessages($userID)
    {
        try {

            $chats = Chat::with('user')
                ->where(function ($qb) use ($userID) {
                    $qb->where('sender_id', $userID);
                    $qb->orWhere('receiver_id', $userID);
                })->get();

            return view('partials.messages', [
                'chat' => $chats
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function addMessage(Request $request, $recieverID)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'content' => 'required'
            ]);

            Chat::create([
                'content' => $validated['content'],
                'sender_id' => Auth::id(),
                'receiver_id' => $recieverID,
            ]);

            DB::commit();

            return response()->json(['message' => 'sent']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'failed '], 500);
        }
    }

    public function sendToAdmin(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'content' => 'required'
            ]);

            $adminID = 1;

            Chat::create([
                'content' => $validated['content'],
                'sender_id' => Auth::id(),
                'receiver_id' => $adminID,
            ]);

            DB::commit();

            return response()->json(['message' => 'sent']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
