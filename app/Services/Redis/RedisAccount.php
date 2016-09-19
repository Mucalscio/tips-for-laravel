<?php
namespace App\Services\Redis;

class RedisAccount extends RedisBase {

    //app的前缀，与别的应用区分
    private $app_prefix = 'tips_';
    //email验证码前缀
    private $email_prefix = 'email_validator_code_';
    //短信验证码前缀
    private $sms_prefix = 'sms_validator_code_';
    //账户信息前缀
    private $account_prefix = 'account';

    //邮箱验证时间
    private $email_validator_time = 259200;  //3天

    //短信验证时间
    private $sms_validator_time = 600;

    //发短信间隔时间
    private $sms_send_limit = 59;

    //登陆时间
    private $login_time = 1800;


    /*
     * 描述：设置email验证码
     * 参数：string $code
     *      string $email
     * 返回：boolean
     */
    public function set_email_validator_code($code, $email)
    {
        $code = $this->app_prefix.$this->email_prefix.$code;
        $bool = $this->redis->setnx($code,$email);
        if($bool){
            $this->redis->setTimeout($code,$this->email_validator_time);
            return true;
        } else {
            return false;
        }
    }

    /*
     * 描述：检查邮件验证码是否存在
     * 参数：string $code
     *      string $email
     * 返回：boolean
     */
    public function check_email_validator_code($code,$email)
    {
        $code = $this->app_prefix.$this->email_prefix.$code;
        $value = $this->redis->get($code);
        if(!$value || $email != $value)
        {
            return false;
        }
        return true;
    }

    /*
     * 描述：设置短信验证码
     * 参数：string $phone
     *      string $code
     * 返回：boolean
     */
    public function set_sms_validator_code($phone, $code)
    {
        $phone = $this->app_prefix.$this->sms_prefix.$phone;
        $bool = $this->redis->set($phone,$code);
        if($bool){
            $this->redis->setTimeout($phone,$this->sms_validator_time);
            return true;
        } else {
            return false;
        }
    }

    /*
     * 描述：验证手机号是否发送过验证码，时间限制60秒
     */
    public function had_send_sms($phone)
    {
        $phone = $this->app_prefix.$this->sms_prefix.$phone;
        $time = $this->redis->ttl($phone);
        if($this->sms_validator_time - $time <= $this->sms_send_limit)
        {
            return true;
        }
        return false;
    }

    /*
     * 描述：检查短信验证码是否正确
     * 参数：string $phone
     *      string $code
     * 返回：boolean
     */
    public function check_sms_validator_code($phone, $code)
    {
        $phone = $this->app_prefix.$this->sms_prefix.$phone;
        $value = $this->redis->get($phone);
        if(!$value || $code != $value)
        {
            return false;
        }
        return true;
    }

    /*
     * 描述：登陆时，设置登陆账户的基本信息
     * 参数：string  $token(用户登陆产生的token)
     *      array   $data(需要保存的数据key-value)
     * 返回：boolean
     */
    public function set_login_info($token,array $data)
    {
        $token = $this->app_prefix.$this->account_prefix.$token;
        if($this->set_hash($token,$data))
        {
            $this->redis->setTimeout($token,$this->login_time);
            return true;
        }else{
            return false;
        }
    }

    /*
     * 描述：退出系统，删除缓存信息
     * 参数：string  $token(用户登陆产生的token)
     * 返回：boolean
     */
    public function delete_login_info($token)
    {
        $token = $this->app_prefix.$this->account_prefix.$token;
        if($this->redis->del($token))
        {
            return true;
        }
        return false;
    }

    /*
     * 描述：检查是否登陆
     * 参数：string $token
     * 返回：boolean
     */
    public function is_login($token)
    {
        $token = $this->app_prefix.$this->account_prefix.$token;
        if($this->redis->exists($token))
        {
            $this->redis->setTimeout($token,$this->login_time);
            return true;
        }
        return false;
    }

    /*
     * 描述：获取账户的信息，第一个参数传账户的token，第二个参数可选
     * 参数：string $token
     *      $key(可选)
     *      key的传参形式：1.数组　例：get_login_info($token, [key1,key2,key3...])
     *                   2.字符串　例：get_login_info($token, $key1, $key2, $key3...)
     *                   3.null(不传)返回所有信息　例：get_login_info($token)
     * 返回：array(key-value)
     */
    public function get_login_info($token,$keys = null)
    {
        $token = $this->app_prefix.$this->account_prefix.$token;
        $result = false;
        if(!is_array($keys) && !is_null($keys)){
            $keys = func_get_args();
            unset($keys[0]);
        }
        if($this->redis->exists($token))
        {
            $this->redis->setTimeout($token,$this->login_time);
            $result = $this->get_hash($token,$keys);
        }
        return $result;
    }



}