<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZhaopingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zhaoping_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',20)->comment('招聘网站类型：1：拉勾');
            $table->string('job_type',50)->comment('招聘职位类型');
            $table->string('company_full_name')->comment('公司名称');
            $table->string('company_name')->comment('公司简称');
            $table->string('company_Id')->comment('公司ID')->nullable();
            $table->string('industry_field')->comment('公司领域')->nullable();
            $table->string('company_size')->comment('公司规模')->nullable();
            $table->string('finance_stage')->comment('发展阶段：如A轮等')->nullable();
            $table->string('position_name',50)->comment('职位名称');
            $table->string('position_advantage')->comment('职位优势');
            $table->string('position_lables')->comment('职位标签')->nullable();
            $table->string('work_year')->comment('工作年限')->nullable();
            $table->string('salary')->comment('薪水范围')->nullable();
            $table->string('city')->comment('城市')->nullable();
            $table->string('district')->comment('地区')->nullable();
            $table->string('first_type')->comment('职位第一分类')->nullable();
            $table->string('second_type')->comment('职位第二分类')->nullable();
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
        Schema::dropIfExists('zhaoping_jobs');
    }
}
