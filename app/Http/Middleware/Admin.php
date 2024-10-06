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

            User::where('user_role',UserRole::ADMIN->value)
            ->where('user_id',Auth::id())
            ->firstOrFail();

            return $next($request);

        } catch (\Exception $e) {
            return redirect('/account');
        }
    }
}