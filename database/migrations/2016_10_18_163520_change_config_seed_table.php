<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeConfigSeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_seed', function (Blueprint $table) {
            $table->string('openid');
            $table->string('name', 50)->change();
            $table->renameColumn('name', 'username');
            $table->dropColumn('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_seed', function (Blueprint $table) {
            //
        });
    }
}
