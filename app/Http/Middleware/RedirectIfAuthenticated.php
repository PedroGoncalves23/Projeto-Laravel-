<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
//
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            //ESSA PARTE FAZ COM QUE QUANDO USUARIO TIVER LOGADO ELE NÃO CONSEGUE IR PARA A TELA DE LOGIN
            if (Auth::guard($guard)->check()) {
                $userRole = auth()->user()->role;
                return redirect(UserService::getDashboardRouteBasedOnUserRole($userRole));
            }
        }

        return $next($request);
    }
}
