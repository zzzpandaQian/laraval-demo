<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题')->index();
            $table->string('image')->comment('背景图')->nullable();
            $table->string('link')->comment('按钮链接')->nullable();
            $table->text('description')->comment('轮播图描述')->nullable();
            $table->tinyInteger('status')->default(0)->comment('使用状态:1是，0否');
            $table->tinyInteger('button')->default(0)->comment('按钮显示:1显示，0不显示');
            $table->string('light')->default(0)->comment('明暗显示:0明，1暗');
            $table->string('position')->default(0)->comment('位置显示:1 intro-text-center，2intro-text-right');
            $table->tinyInteger('sort_order')->default(0)->comment('排序');
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
        Schema::dropIfExists('sliders');
    }
}
