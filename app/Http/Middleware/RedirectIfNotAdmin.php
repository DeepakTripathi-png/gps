<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (!Auth::guard($guard)->check()) {
            return to_route('admin.login');
        }

        if (Auth::guard($guard)->user()->status == Status::USER_BAN) {
            Auth::guard($guard)->logout();
            $notify[] = ['error', 'This account is banned by super admin'];
            return to_route('admin.login')->withNotify($notify);
        }

        return $next($request);
    }
}
