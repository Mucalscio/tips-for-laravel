<?php

namespace App\Http\Controllers\Auth;

use App\Services\Redis\RedisAccount;
use App\Model\User;
use Illuminate\Http\Request;
use Validator;
use Hash;
use App\Http\Controllers\Controller;

class AuthTokenController extends Controller
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
            $redis = new RedisAccount();
            $token = str_random(32);
            $redis->set_login_info($token,['id' => $user->id, 'email' => $user->email, 'name' => $user->name]);
            //登录成功,返回token
            return response()->json( formatReturnData(1, $token) );

        } else {
            return response()->json( formatReturnData(-1, '用户名或密码错误') );
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
            return response()->json( formatReturnData(1, '注册成功') );
        }
    }

    /*
     * 退出登录接口
     */
    public function logout(Request $request)
    {
        $token = $request->input('token');
        $redis = new RedisAccount();
        $redis->delete_login_info($token);
        return response()->json( formatReturnData(1, '退出成功') );
    }

}
