<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{

    public function index()
    {
        return view('user.password');
    }

    public function changePassword(Request $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'password' => 'required|string',
                'new_password' => 'required|confirmed|string',
            ]);

            $confirmPassword = Hash::check($validated['password'], Auth::user()->getAuthPassword());

            if (!$confirmPassword) {
                throw new \Exception('Incorrect Username or password');
            }

            User::where('id', Auth::id())
                ->update(['password' => bcrypt($validated['new_password'])]);

            DB::commit();

            return redirect()->back()->with(['message' => 'password changed!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

    }
}
