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