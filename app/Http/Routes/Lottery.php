<?php
namespace App\Http\Routes;

use Route;
use Illuminate\Contracts\Routing\Registrar;

class Lottery
{
    public function map(Registrar $route)
    {
        Route::group(['prefix' => 'lottery'], function () {
            Route::get('file', "Lottery\FileController@lottery");
            Route::get('redis', "Lottery\RedisController@lottery");
            Route::get('memcached', "Lottery\MemcachedController@lottery");
        });
    }
}
