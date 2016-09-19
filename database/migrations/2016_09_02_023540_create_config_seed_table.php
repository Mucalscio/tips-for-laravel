<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('config_seed');
        Schema::create('config_seed', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('value');
            $table->timestamps();
        });
        $now = date('Y-m-d H:i:s',time());
        $data = [
            ['name' => 'start_time', 'value' => '2016-09-02 00:00:00', 'created_at' => $now],
            ['name' => 'end_time', 'value' => '2016-09-05 00:00:00', 'created_at' => $now]
        ];
        \Illuminate\Support\Facades\DB::table('config_seed')
            ->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('config_seed');
    }
}
