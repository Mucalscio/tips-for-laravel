<?php
namespace App\Http\Controllers\RequestProcess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceiveController extends Controller{

    public function index(Request $request)
    {
        dump($request->all());
        dump($request->mydata);
        dump($request->input('second'));
    }

}