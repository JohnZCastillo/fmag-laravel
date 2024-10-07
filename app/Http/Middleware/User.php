<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {

            if (Auth::user()->role != UserRole::USER) {
                throw new \Exception('Not a user');
            }

            return $next($request);

        } catch (\Exception $e) {
            return redirect('/admin/dashboard');
        }
    }
}
