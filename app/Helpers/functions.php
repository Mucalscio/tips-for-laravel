<?php

/**
 * 式化要输出到客户端的数据
 * @param mixed $code 返回结果状态码，boolean或int
 * @param mixed $data 返回结果数据，string，int或array
 * @return array
 */
function formatReturnData($code, $data) {
    return ['status' => $code, 'data' => $data];
}

/**
 * 式化json到客户端的数据
 * @param mixed $code 返回结果状态码，boolean或int
 * @param mixed $data 返回结果数据，string，int或array
 * @return string
 */
function formatResponseData($code, $data) {
    return response()->json( ['status' => $code, 'data' => $data] );
}

/*
 * 创建一个redis连接
 */
function newRedis()
{
    $redis = new \Redis();
    $host = empty(env('REDIS_HOST')) ? 'localhost' : env('REDIS_HOST');
    $redis->connect($host);
    return $redis;
}

/*
 * 创建一个memcached连接
 */
function newMemcached()
{
    $memcached = new \Memcache();
    $host = empty(env('MEMCACHED_HOST')) ? 'localhost' : env('MEMCACHED_HOST');
    $port = empty(env('MEMCACHED_PORT')) ? '11211' : env('MEMCACHED_PORT');
    $memcached->connect($host,$port) or die (false);
    return $memcached;
}