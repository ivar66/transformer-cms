<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_id')->comment('用户user_id');
            $table->string('logo', 255)->comment('文章logo')->nullable();
            $table->tinyInteger('category_id')->comment('分类ID')->default(0);
            $table->string('title')->comment('文章标题');
            $table->string('summary')->comment('文章简述')->nullable();
            $table->text('content')->comment('文章内容');
            $table->integer('views')->comment('浏览量')->default(0);
            $table->integer('comments')->comment('回复数')->default(0);
            $table->integer('collections')->comment('收藏数')->default(0);
            $table->tinyInteger('status')->comment('0 未审核，1审核完成')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
