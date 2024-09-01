<?php

namespace App\Http\Controllers;

use App\Actions\SendVerificationEmail;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function verifyPage(SendVerificationEmail $sendVerificationEmail)
    {

        try {
            $sendVerificationEmail->handle();
            return view('verify');
        } catch (\Exception $e) {
            return view('verify', ['error' => $e->getMessage()]);
        }

    }

    public function viewRegisterPage()
    {
        return view('register');
    }

    public function register(Request $request)
    {

        try {

            $credentials = $request->validate([
                'email' => 'required|unique:users|email',
                'password' => 'required|confirmed|min:8',
            ]);

            DB::beginTransaction();

            User::create([
                'email' => $credentials['email'],
                'password' => bcrypt($credentials['password']),
            ]);

            DB::commit();

            Auth::attempt($credentials);

            return redirect('/profile');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage(),
            ])->onlyInput('email');

        }
    }


    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'Incorrect email/password',
        ])->onlyInput('email');

    }

    public function logout(Request $request)
    {

        Auth::logout();

        return redirect('/');
    }
}
