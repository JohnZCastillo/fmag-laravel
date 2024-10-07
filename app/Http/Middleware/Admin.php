<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {

            $user = \App\Models\User::findOrFail(Auth::id());

            if ($user->role == UserRole::USER) {
                return redirect('/user/profile');
            }

            return $next($request);

        } catch (\Exception $e) {
            return redirect('/');
        }
    }
}
