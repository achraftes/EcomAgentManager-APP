<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect('/dashboard');
            } elseif ($user->role == 'agent') {
                return redirect('/clients');
            } else {
                return redirect('/home');
            }
        }

        return $next($request);
    }
}
