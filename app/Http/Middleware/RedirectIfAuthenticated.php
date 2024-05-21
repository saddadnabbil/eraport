<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if ($user->hasRole('Admin')) {
                return redirect(route('admin.dashboard'));
            } elseif ($user->hasRole('Curriculum')) {
                return redirect(route('curriculum.dashboard'));
            } elseif ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG'])) {
                return redirect(route('teacher.dashboard'));
            } elseif ($user->hasRole('Student')) {
                return redirect(route('student.dashboard'));
            }
        }

        return $next($request);
    }
}
