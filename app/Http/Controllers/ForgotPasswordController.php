<?php

namespace App\Http\Controllers;

use App\Events\ForgotPassword;
use App\Mail\TemporaryPassword;
use App\Models\User;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('forgot-password');
    }

    public function sendPin(Request $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'email' => 'required|email'
            ]);

            $user = \App\Models\User::where('email', $validated['email'])
                ->firstOrFail();

            $code = fake()->numberBetween(111111, 999999);

            $verification = Verification::create([
                'user_id' => $user->id,
                'session_id' => Session::getId(),
                'code' => $code,
                'expiration' => Carbon::now()->addMinutes(5)->format('Y-m-d H:i')
            ]);

            DB::commit();

            ForgotPassword::dispatch($verification);

            return view('verify-pin');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'something went wrong!']);
        }
    }

    public function verifyPin(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'pin' => 'required|numeric'
            ]);

            Verification::where('session_id', Session::getId())
                ->where('user_id', Auth::id())
                ->where('pin', $validated['pin'])
                ->where('expiration', '>', Carbon::now()->format('Y-m-d H:i'))
                ->firstOrFail();

            $user = User::findOrFail(Auth::id());

            $rawPassword = Str::password(8);

            $user->password =  bcrypt($rawPassword);

            $user->save();

            Mail::to($user->email)->send(new TemporaryPassword($rawPassword));

            DB::commit();

            return  redirect('/login');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'something went wrong!']);
        }
    }
}