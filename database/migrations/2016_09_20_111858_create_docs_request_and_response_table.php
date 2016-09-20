<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsRequestAndResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs_request_and_response', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');          //文档ID
            $table->string('param');            //参数名称
            $table->string('type');             //类型
            $table->string('describe',255);     //描述
            $table->string('critical',128);     //临界值
            $table->string('status');           //状态码(以下是response字段)
            $table->string('data',1024);        //返回的数据
            $table->integer('count');           //数据的条目
            $table->string('remark',128);       //备注
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('docs_request_and_response');
    }
}
