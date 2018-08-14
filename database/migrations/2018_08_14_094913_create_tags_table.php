<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag_name')->comment('话题名称');
            $table->string('tag_log')->comment('话题logo');
            $table->integer('catgory_id')->default(0)->commnet('分类ID');
            $table->string('summary', 200)->comment('话题简介')->nullable();
            $table->string('description', 200)->comment('话题详细介绍')->nullable();
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
        Schema::dropIfExists('tags');
    }
}
