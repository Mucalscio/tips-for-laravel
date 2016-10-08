<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery', function (Blueprint $table) {
            $table->increments('id');
            $table->char('phone',11);       //手机号
            $table->string('lottery_name',64);  //奖品名称
            $table->double('lottery_probability');  //奖品名称
            $table->dateTime('win_at');     //获奖时间
            $table->tinyInteger('status')->unsigned()->default(1); //1为未被抽到，2则被抽到，3则被废弃
            $table->timestamps();
        });
        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lottery');
    }

    public function seed()
    {
        $now = date( 'Y-m-d H:i:s', time() );
        $data = [];
        for($i = 0; $i<500; $i++){
            $item = [
                'lottery_name' => '50元话费',
                'created_at' => $now,
                'lottery_probability' => 0.05
            ];
            $data[] = $item;
        }
        for($i = 0; $i<1000; $i++){
            $item = [
                'lottery_name' => '10元话费',
                'created_at' => $now,
                'lottery_probability' => 0.1
            ];
            $data[] = $item;
        }
        for($i = 0; $i<100; $i++){
            $item = [
                'lottery_name' => '100元话费',
                'created_at' => $now,
                'lottery_probability' => 0.002
            ];
            $data[] = $item;
        }
        for($i = 0; $i<3; $i++){
            $item = [
                'lottery_name' => '300元话费',
                'created_at' => $now,
                'lottery_probability' => 0.0003
            ];
            $data[] = $item;
        }
        \App\Model\Lottery::insert($data);
    }

}
