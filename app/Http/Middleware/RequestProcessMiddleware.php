<?php

namespace App\Http\Middleware;

use Closure;

class RequestProcessMiddleware
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
        $request->mydata = ["first"=>"加工了一个数据"];
        return $next($request);
    }
}
