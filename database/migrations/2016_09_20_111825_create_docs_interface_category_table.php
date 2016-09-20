<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsInterfaceCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs_interface_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id')->unsigned();   //文档ID
            $table->string('name');     //分类名
            $table->timestamps();

            //外键约束
            $table->foreign('doc_id')->references('id')->on('docs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('docs_interface_category');
    }
}
