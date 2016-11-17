<?php

/*
 * 本项目写了一些laravel的一些小技巧
 * 作者:  Mucalscio
 * 作者的习惯:
 *      1,使用phpStorm编辑器
 *        1)安装依赖包:https://github.com/koomai/phpstorm-laravel-live-templates#requests--input
 *        2)安装插件Laravel Plugin
 *      2,安装laravel-ide-helper插件,需要区分好开发环境和生产环境,安装产生两个文件,在ignore中忽略了
 *          使用php artisan ide-helper:generate命令生成的_ide_helper.php文件
 *          使用php artisan ide-helper:meta命令生成的.phpstorm.meta.php文件
 *          laravel-ide-helper的网址: https://github.com/barryvdh/laravel-ide-helper
 *      3,在app目录下,创建Helpers文件夹,放置自己写的全局函数,通常是一个functions.php文件,这个文件会在bootstrap/autoload.php文件中引用
 *      4,在全局函数中,写一个格式化返回函数,所有接口的返回格式都统一起来
 *      5,本地化:https://github.com/caouecs/Laravel-lang,安装完组件在config/app.php的local设置成对应的语言
 */

Route::get('/', function () {
    //dump( json_encode(['type'=>1, 'data'=>"哈哈哈"]) );
    return view('welcome');
});


/*
 * 获取所有路由,以此做DOC文档,权限的管理等,非常不错
 */
Route::get('routes',function () {
    $getRoutes = Route::getRoutes();
    $routes = $getRoutes->getRoutes();
    foreach ($routes as $route) {
        $uri = $route->uri();
        $methods = $route->methods();
        if($uri[0] == '/') {
            $uri = substr($uri,1,strlen($uri-1));
        }
        echo strtolower($methods[0].'/'.$uri).'</br>';
    }
});

/*
 * 基于token的登录
 * laravel自带的登录基于session的,在使用react做前后端分离的时候会遇到跨域问题,所以使用token做登录凭证
 */
Route::group(['prefix' => 'auth','namespace' => 'Auth'],function (){
    Route::post('login','AuthTokenController@login');
    Route::delete('logout','AuthTokenController@logout');
    Route::post('register','AuthTokenController@register');
});

/*
 * 加工request对象
 * request 对象在单次请求中是唯一的,所以,在中间件中处理完,可以对request对象进行加工,以便逻辑去调用
 * 这适用于多个接口,都需要做同样的处理,
 */
Route::get('request_process',['middleware'=>['requestProcess'],'uses'=>'RequestProcess\ReceiveController@index']);

/*
 * 基于路由的权限管理
 * 对于权限校验的策略是这样的
 * 1,所有需要权限校验的路由都写在一个权限路由组中,路由组配置一个权限校验中间件
 * 2,在权限表(可以写数据库也可以写配置文件)中把权限组中的所有路由加进去
 *   规则: (1)全部字母为小写
 *         (2)提交方式/prefix/路由,例:(get/permission/admin/{id})
 * 3,在中间件中,获取请求的路由,去校验此路由是否在该用户的权限表里
 */
Route::group(['prefix' => 'permission','middleware'=>'permission'],function (){
    Route::get('admin/{id}',['uses'=>'Permission\AdminController@index']);
    Route::post('admin/{id}',['uses'=>'Permission\AdminController@index']);
    Route::get('admin',['uses'=>'Permission\AdminController@index']);
});

/*
 * 查看日志
 * 组件的安装在:https://github.com/rap2hpoutre/laravel-log-viewer
 */
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

/*
 * 输出全部的路由信息
 */
Route::get('routes', function () {
    $getRoutes = Route::getRoutes();
    $routes = $getRoutes->getRoutes();
    $data = [];
    foreach ($routes as $route) {
        $action = $route->getAction();
        $uri = $route->uri();
        if (!empty($action['controller'])) {
            $controller = explode('@', $action['controller']);
            $methods = $route->methods();
            if($uri[0] == '/') {
                $uri = substr($uri,1,strlen($uri-1));
            }
            $class = $controller[0];
            $object = new $class;
            $rule = $controller[1].'_rule';
            if(!empty($object->$rule)) {
                $item['rule'] = $object->$rule;
            }
            $item['class'] = $class;
            $item['uri'] = $uri;
            $item['method'] = $methods[0];
            $data[] = $item;
            unset($item);
        }
    }
    return json_encode($data);
});

/*
 * 后台路由
 */
Route::group(['prefix' => 'backend', 'middleware' => 'authBackend'], function (){
    //主页
    Route::get('/',function (){ return view('backend.index'); });

    //日志
    Route::get('logs_view', function () { return view('backend.logs'); });
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    //活动
    Route::get('activity/pool_party', function(){ return view('backend.activity.poolParty.config'); });

    //文档
    Route::group(['prefix' => 'docs','namespace' => 'Docs'], function (){
        Route::get('manage', 'ManageController@manage_view');
        Route::get('delete', 'ManageController@delete');
        Route::get('create_view', 'EditController@create_view');
        Route::get('edit_view/{id}', 'EditController@edit_view');
        Route::post('edit/{id}', 'EditController@edit');
        Route::post('create','EditController@create');
        Route::get('category/list/{id}','CategoryController@category_list');
        Route::delete('category/delete/{id}','CategoryController@delete');
        Route::post('category/create/{id}','CategoryController@create');
        Route::get('interface/get', 'InterfaceController@get');
    });
    
});

/*
 * 基于session的登陆,用户名密码在migrate直接写入。
 */
Route::group(['prefix' => 'backend','namespace' => 'Auth'],function (){
    Route::get('login',function (){ return view('backend.login'); });
    Route::post('login','AuthSessionController@login');
    Route::get('logout','AuthSessionController@logout');
    Route::post('register','AuthSessionController@register');
});

Route::get('t',function (){
    for($i = 1 ; $i <= 36 ; $i +=  $i > 1 ? 3 : 2) {
        echo $i."<br>";
    }
});