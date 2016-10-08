<?php

namespace App\Http\Controllers\Lottery;

use App\Http\Controllers\Controller;
use App\Model\Lottery;
use App\Services\Lottery\LotteryLock;

class FileController extends Controller
{
    /*
     * 文件锁的特点在于，在同一时间内，抽奖只能有一个。也就是说，抽奖是排队的，尽管有并发的情况，也不能同时抽奖
     * 这样保证了抽奖不会出现超抽的情况，也不会因为同时抽到一个奖品产生错误
     * 但是这种方式效率比较低下，并发量上千的抽奖吃不消
     */
    public function index()
    {
        $phone = random_int(13500000000, 13599999999);
        $path = storage_path('app');
        $key = 'file_lottery';
        $lottery = '';
        $lock = new LotteryLock($key, $path);
        //打开文件锁
        $lock->lock();

         //开始抽奖
        $first = Lottery::where('lottery_name','50元话费')
            ->where('status',1)
            ->count();
        $second = Lottery::where('lottery_name','10元话费')
            ->where('status',1)
            ->count();
        $random = random_int(0, 10000);
        if($random < 5000 && $second > 0)
        {
            $r_s = random_int(0, $second);
            $lottery = Lottery::where('lottery_name','10元话费')
                ->where('status',1)
                ->skip($r_s)
                ->take(1)
                ->get()
                ->first();
            //dump($lottery);

        } else if(5000 < $random && $random < 7000 && $first > 0) {
            $r_f = random_int(0, $first);
            $lottery = Lottery::where('lottery_name','50元话费')
                ->where('status',1)
                ->skip($r_f)
                ->take(1)
                ->get()
                ->first();
            //dump($lottery);
        }
        //如果有奖品，则获得
        if(!empty($lottery))
        {
            $lottery->phone = $phone;
            $lottery->win_at = date("Y-m-d H:i:s", time());
            $lottery->status = 2;
            $lottery->save();
            //获得奖品，解锁返回
            $lock->unlock();
            return $lottery->lottery_name."-".$lottery->id;
        }else {
            //没有获得奖品，解锁返回
            $lock->unlock();
            return "谢谢抽奖";
        }
    }

    public function lottery()
    {
        $t1 = microtime(true);
        $res = [];
        $success = 0;
        for($i=0; $i<1000; $i++) {
            $r = $this->index();
            if($r != "谢谢抽奖") {
                $success++;
            }
            $res[] = $r;
        }
        $t2 = microtime(true);
        echo '耗时'.round($t2-$t1,3).'秒<br>';
        echo $success.'抽到奖';
    }

}