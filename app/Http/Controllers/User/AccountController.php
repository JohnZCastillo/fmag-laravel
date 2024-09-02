<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    public function index()
    {
        return view('user.account');
    }

    public function update(Request $request)
    {

        try {
            DB::beginTransaction();

            $validate = $request->validate([
                'name' => 'required|string',
                'middle_name' => 'nullable|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'contact_number' => 'required|numeric',
                'profile' => 'nullable|image|mimes:jpeg,jpg,png',
            ]);

            $user = User::find(Auth::id());

            $user->name = $validate['name'];
            $user->last_name = $validate['last_name'];
            $user->contact_number = $validate['contact_number'];

            if ($user->email != $validate['email']) {
                $user->verified = false;
            }

            $user->email = $validate['email'];

            if (isset($validate['middle_name'])) {
                $user->middle_name = $validate['middle_name'];
            }

            if ($request->file('profile')) {
                $user->profile = $request->file('profile')->store('public');
            }

            $user->save();

            DB::commit();

            return redirect('/user/profile');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/user/profile')->withErrors(['message' => $e->getMessage()]);
        }
    }
}
