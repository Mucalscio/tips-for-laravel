<?php
namespace App\Http\Routes;

use Route;
use Illuminate\Contracts\Routing\Registrar;

class Rank
{
    public function map(Registrar $route)
    {
        Route::group(['prefix' => 'rank'], function () {
            Route::get('mysql', "Rank\RankController@index");
        });
    }
}
