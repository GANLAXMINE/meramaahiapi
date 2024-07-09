<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(Auth::guard('admin')->check());
        if(FacadesAuth::guard('admin')->check()){
            return $next($request);
        }
        return redirect('admin\login');
    }
}
