<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('score');
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
        Schema::drop('rank');
    }

    public function seed()
    {
        $data = [];
        for ($i = 1;$i <= 100000;$i++) {
            $item['name'] = str_random(6);
            $item['score'] = random_int(0, 100000);
            $item['created_at'] = date('Y-m-d H:i:s', time());
            $data[] = $item;
            if( $i % 10000 == 0 ) {
                DB::table('rank')->insert($data);
                unset($data);
            }
        }

    }
}
