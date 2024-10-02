<?php

namespace App\Http\Controllers;

use App\Actions\SendVerificationEmail;
use App\Models\Cart;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Verification;
use Carbon\Carbon;
use Faker\Provider\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
            return view('verify')->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function completeProfilePage()
    {

        try {
            return view('complete-profile');
        } catch (\Exception $e) {
            return view('complete-profile')->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function completeProfile(Request $request)
    {

        $validated = $request->validate([
            'firstName' => 'required|string',
            'middleName' => 'nullable|string',
            'lastName' => 'required|string',
            'contactNumber' => 'required|numeric',
            'region' => 'required|numeric',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'barangay' => 'required|numeric',
            'postal' => 'nullable|numeric',
            'property' => 'required|string',
        ]);

        try {

            DB::beginTransaction();

            $user = User::find(Auth::id());
            $address = new UserAddress();

            $user->name = $validated['firstName'];
            $user->last_name = $validated['lastName'];
            $user->contact_number = $validated['contactNumber'];
            $user->completed = true;

            $address->region = $validated['region'];
            $address->province = $validated['province'];
            $address->city = $validated['city'];
            $address->barangay = $validated['barangay'];
            $address->property = $validated['property'];
            $address->user_id = Auth::id();
            $address->active = true;

            if (isset($validated['middleName'])) {
                $user->middle_name = $validated['middleName'];
            }

            if (isset($validated['postal'])) {
                $address->postal = $validated['postal'];
            }

            $user->save();
            $address->save();

            Cart::create([
                'user_id' => $user->id
            ]);

            DB::commit();

            return redirect('/profile');

        } catch (\Exception $e) {
            DB::rollBack();
            return view('complete-profile')->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function verifyCode(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {

            Verification::where('session_id', '=', Session::getId())
                ->where('user_id', '=', Auth::id())
                ->where('code', '=', $validated['code'])
                ->where('expiration', '<', Carbon::now()->format('Y-m-d H:i'))
                ->firstOrFail();

            $user = User::where('id', '=', Auth::id())
                ->firstOrFail();

            $user->verified = true;
            $user->save();

            DB::commit();

            return redirect('/profile');

        } catch (\Exception $e) {
            DB::rollBack();
            return view('verify')->withErrors(['error' => 'invalid code']);
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
