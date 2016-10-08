<?php

namespace App\Http\Controllers\Lottery;

use App\Http\Controllers\Controller;
use App\Model\Lottery;
use App\Services\Lottery\LotteryLock;

class MemcachedController extends Controller
{
    /*
     * 用memcached做锁的好处是效率较高，虽然memcached执行语句是一句一句执行，不并发，但是效率快，足以应付并发的情况
     * 策略：先把用户的奖品抽出来，再根据id把奖品锁起来，如果能锁则获得，如果锁不了，就意味着奖品被别人锁了，返回谢谢参与
     * 这会有一点点影响概率，用了十个并发测试一万数据，发现这个影响可以忽略不计
     * 在并发的时候，几乎每个人抽到的奖品不一样，这样大家的锁就不是同一个，可以支持并发的情况，效率大大提高
     * 经过测试发现，效率对比redis > memcached > file
     */
    public function index()
    {
        $phone = random_int(13500000000, 13599999999);
        $key = 'memcached_lottery';
        $lottery = '';

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

        } else if(5000 < $random && $random < 7000 && $first > 0) {
            $r_f = random_int(0, $first);
            $lottery = Lottery::where('lottery_name','50元话费')
                ->where('status',1)
                ->skip($r_f)
                ->take(1)
                ->get()
                ->first();
        }
        $memcached = newMemcached();
        //如果能锁定奖品，则获得
        if(!empty($lottery) && $memcached->add($key.$lottery->id, $lottery->name, 0, 3))
        {
            $lottery->phone = $phone;
            $lottery->win_at = date("Y-m-d H:i:s", time());
            $lottery->status = 2;
            $lottery->save();
            return $lottery->lottery_name."-".$lottery->id;
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
        //dump($res);
    }

}