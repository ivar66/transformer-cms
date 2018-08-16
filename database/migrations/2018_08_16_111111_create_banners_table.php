<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('banner_name')->comment('banner名称');
            $table->string('banner_url')->comment('banner点击url');
            $table->string('banner_pic_url')->comment('banner图片url');
            $table->integer('sort')->comment('当前排序顺序，越大越前')->default(0);
            $table->tinyInteger('status')->comment('banner状态 0:未发布，1：发布 2：下架');
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
        Schema::dropIfExists('banners');
    }
}
