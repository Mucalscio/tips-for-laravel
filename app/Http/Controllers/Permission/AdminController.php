<?php
namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller{

    public function index()
    {
        return '进入controller,有权限的哟';
    }

}