<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\User as UserModel;
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

            UserModel::where('user_role',UserRole::USER->value)
            ->where('user_id',Auth::id())
            ->firstOrFail();

            return $next($request);

        } catch (\Exception $e) {
            return redirect('/admin/dashboard');
        }
    }
}
