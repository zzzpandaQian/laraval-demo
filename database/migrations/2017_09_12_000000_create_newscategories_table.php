<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->comment('标题')->nullable();
            $table->integer('parent_id')->comment('父级id')->default(0);
            $table->integer('order')->comment('排序')->default(0);
            $table->string('permalink', 100)->comment('固定链接')->nullable();
            $table->tinyInteger('status')->default(0)->comment('状态: 0 禁用, 1 激活');
            $table->softDeletes();
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
        Schema::dropIfExists('news_categories');
    }
}
