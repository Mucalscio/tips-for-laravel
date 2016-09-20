<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsInterfaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs_interface', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id')->unsigned();;          //文档ID
            $table->integer('category_id');     //分类ID
            $table->string('name');             //接口名
            $table->string('method',10);        //提交方法
            $table->string('url',128);          //提交的URL
            $table->string('json',1024);        //JSON
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
        Schema::drop('docs_interface');
    }
}
