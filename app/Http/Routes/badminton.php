<?php
namespace App\Http\Routes;

use Route;
use Illuminate\Contracts\Routing\Registrar;

class Badminton
{
    public function map(Registrar $router)
    {
        Route::group(['prefix' => 'backend', 'middleware' => 'authBackend'], function ($router) {
            Route::get('activity/badminton', function () {
                return view('backend.activity.badminton.config');
            });
        });
    }
}
