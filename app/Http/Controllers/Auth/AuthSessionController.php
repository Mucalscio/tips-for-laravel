<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Session;
use Redirect;
use App\Http\Controllers\Controller;

class AuthSessionController extends Controller
{
    /*
     * 登陆参数规则
     */
    public $login_rule = [
        'email' => 'required|email|max:255',
        'password' => 'required|min:6',
    ];

    /*
     * 注册参数规则
     */
    public $register_rule = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed|min:6',
    ];
    
    /*
     * 账户登录接口
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->login_rule);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json( formatReturnData(-2, $error) );
        }
        $user = User::where('email', $data['email'])->first();
        if(!empty($user->password) && Hash::check($data['password'], $user->password)) {
            Session::set('login',['id' => $user->id, 'email' => $user->email, 'name' => $user->name]);
            return Redirect::to('backend');

        } else {
            return Redirect::to('backend/login')->with('status','用户名或密码错误');
        }
        
    }

    /**
     * 注册新的用户接口
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->register_rule);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json( formatReturnData(-2, $error) );
        }
        $code =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        if(!empty($code)) {
            return Redirect::to('backend/login')->with('status','注册成功');
        }
        return Redirect::to('backend/register')->with('status','注册失败');
    }

    /*
     * 退出登录接口
     */
    public function logout()
    {
        Session::forget('login');
        return Redirect::to('backend/login');
    }

}
