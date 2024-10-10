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

            ForgotPassword::dispatch($verification,$user);

            return view('verify-pin', ['email' => $validated['email']]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
//            return redirect()->back()->withErrors(['message' => 'something went wrong!']);
        }
    }

    public function verifyPin(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'pin' => 'required|numeric',
                'email' => 'required|email'
            ]);

            Verification::where('session_id', Session::getId())
                ->whereHas('user', function ($query) use ($validated){
                    $query->where('email', $validated['email']);
                })
                ->where('code', $validated['pin'])
                ->where('expiration', '>', Carbon::now()->format('Y-m-d H:i'))
                ->firstOrFail();

            $rawPassword = Str::password(8);

            User::where('email',$validated['email'])
                ->update(['password' =>  bcrypt($rawPassword) ]);

            Mail::to($validated['email'])->send(new TemporaryPassword($rawPassword));

            DB::commit();

            return  redirect('/login');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'something went wrong!']);
        }
    }

    public function resendPin(Request $request)
    {

        try {

            DB::beginTransaction();

            $user = \App\Models\User::findOrFail(Auth::id());

            $code = fake()->numberBetween(111111, 999999);

            $verification = Verification::create([
                'user_id' => $user->id,
                'session_id' => Session::getId(),
                'code' => $code,
                'expiration' => Carbon::now()->addMinutes(5)->format('Y-m-d H:i')
            ]);

            DB::commit();

            ForgotPassword::dispatch($verification,$user);

            return view('verify-pin', ['email' => $user->email]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

}
