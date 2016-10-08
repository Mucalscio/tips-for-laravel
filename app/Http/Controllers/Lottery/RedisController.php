<?php

namespace App\Http\Controllers\Lottery;

use App\Http\Controllers\Controller;
use App\Model\Lottery;
use App\Services\Lottery\LotteryLock;

class RedisController extends Controller
{
    /*
     * 用redis做锁的好处是效率高，虽然redis执行语句是一句一句执行，不并发，但是效率非常快，足以应付并发的情况
     * 策略：先把用户的奖品抽出来，再根据id把奖品锁起来，如果能锁则获得，如果锁不了，就意味着奖品被别人锁了，返回谢谢参与
     * 这会有一点点影响概率，用了十个并发测试一万数据，发现这个影响可以忽略不计
     * 在并发的时候，几乎每个人抽到的奖品不一样，这样大家的锁就不是同一个，可以支持并发的情况，效率大大提高
     * 经过测试发现，效率对比redis > memcached > file
     */
    public function index()
    {
        $phone = random_int(13500000000, 13599999999);
        $key = 'redis_lottery';
        $lottery_get = '';
        $lotteries = Lottery::select('lottery_name','lottery_probability')
            ->distinct()
            ->get();
        foreach ($lotteries as $lottery) {
            $lottery->num = Lottery::where('lottery_name', $lottery->lottery_name)
                ->where('status',1)
                ->count();
        }

        $base_small = 0;
        $base_big = 10000;
        $random = random_int(0, $base_big-1);
        foreach ($lotteries as $lottery) {
            if( $base_small <= $random && $random < ($lottery->lottery_probability * $base_big + $base_small) && $lottery->num > 0 ) {
                $skip = random_int(0, $lottery->num);
                $lottery_get = Lottery::where('lottery_name',$lottery->lottery_name)
                    ->where('status',1)
                    ->skip($skip)
                    ->take(1)
                    ->get()
                    ->first();
                break;
            }
            $base_small += $lottery->lottery_probability * $base_big;
        }

        $redis = newRedis();
        //如果能锁定奖品，则获得
        if(!empty($lottery_get) && $redis->setnx($key.$lottery_get->id, $lottery_get->name))
        {
            $lottery_get->phone = $phone;
            $lottery_get->win_at = date("Y-m-d H:i:s", time());
            $lottery_get->status = 2;
            $lottery_get->save();
            $redis->expire($key.$lottery_get->id, 5);
            return $lottery_get->lottery_name."-".$lottery_get->id;
        }else {
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