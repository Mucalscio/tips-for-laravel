<?php
namespace App\Services\Redis;

use ErrorException;

class RedisBase {

    protected $redis;

    public function __construct(){
        $this->redis = new \Redis();
        $host = empty(env('REDIS_HOST')) ? 'localhost' : env('REDIS_HOST');
        $this->redis->connect($host);
    }

    protected function set_hash($key,$data)
    {
        try{
            foreach($data as $field => $value){
                $boolean = $this->redis->hSet($key,$field,$value);
                if(!$boolean){
                    return false;
                }
            }
        }catch(ErrorException $exception){
            return false;
        }
        return true;
    }

    protected function get_hash($key,$fields = null)
    {
        $result = [];
        if(is_array($fields)) {
            foreach ($fields as $field) {
                $result[$field] = $this->redis->hGet($key, $field);
            }
        } else if(is_string($fields)) {
            $result[$fields] = $this->redis->hGet($key, $fields);
        } else {
            $result = $this->redis->hGetAll($key);
        }
        return $result;
    }

}