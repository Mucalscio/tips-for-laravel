<?php

namespace App\Http\Middleware;

use Closure;

class AuthBackendMiddleware
{
    /*
     * 验证后台是否登陆,没有登陆的话不允许通过路由
     */
    public function handle($request, Closure $next)
    {
        if(!\Session::has('login')) {
            return \Redirect::to('backend/login');
        }
        return $next($request);

    }
}
