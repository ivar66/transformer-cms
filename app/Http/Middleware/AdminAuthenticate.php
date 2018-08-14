<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //当未登录，且不在登录页，则跳转到登录页
        //当登录了，访问登录页，则跳转到首页
        if (!$request->session()->get('admin.login') && $request->route()->getName() !== 'admin.account.login') {
            return redirect(route('admin.account.login'));
        } elseif ($request->session()->get('admin.login') && $request->route()->getName() == 'admin.account.login') {
            return redirect(route('admin.index.index'));
        }
        return $next($request);
    }
}
