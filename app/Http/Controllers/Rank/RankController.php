<?php

namespace App\Http\Controllers\Rank;

use App\Http\Controllers\Controller;
use DB;


class RankController extends Controller
{
    /*
     * 二十万条数据排序大概耗时0.6秒
     * 数据量大的排序不能用全部排序，可以用redis有序集合
     * 可以只排序部分
     */
    public function index()
    {
        $t1 = microtime(true);

        $data = DB::table('rank')
            ->orderBy('score', 'desc')
            ->skip(1000)
            ->take(50)
            ->get();

        $t2 = microtime(true);
        echo '耗时'.round($t2-$t1,3).'秒<br>';

        dump($data);

    }

}