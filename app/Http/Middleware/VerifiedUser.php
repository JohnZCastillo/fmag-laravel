<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {

            User::where('id', '=', Auth::id())
                ->where('verified', '!=', 0)
                ->firstOrFail();

            return $next($request);

        } catch (\Exception $e) {
            return redirect('/verify');
        }
    }
}
