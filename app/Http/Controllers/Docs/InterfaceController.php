<?php
namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

class InterfaceController extends Controller{

    function get()
    {
        $data = file_get_contents(url('routes'));
        $data = json_decode($data, true);
        return response()->json( formatReturnData(1, $data) );
    }

}