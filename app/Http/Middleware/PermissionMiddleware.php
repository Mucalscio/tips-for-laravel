<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
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
        $method = $request->getMethod();
        $uri = $request->route()->uri();
        $route = strtolower($method.'/'.$uri);
        /*
         * 获取用户信息:
         * 1,可以在登录的时候写进session,在session里面获得用户角色等信息
         * 2,通过token进行登录,也可以通过token拿到用户角色信息,可以参看登录模块
         */

        /*
         * 校验权限
         * 1,根据用户角色去拿对应的权限表,再做判断
         * 2,写数据库的可以直接去count权限记录做判断
         */

        //写在config文件夹里面的文件,可以通过config('文件名.字段名')拿到对应的值
        $permission = config("permission.admin");
        if(in_array($route, $permission)) {
            echo "从接口".$route."进来中间键,鉴权通过</br>";
            return $next($request);
        }
        return "从接口".$route."进来中间键,鉴权失败</br>";
    }
}
