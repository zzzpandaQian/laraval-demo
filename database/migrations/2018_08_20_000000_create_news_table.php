<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id')->comment('新闻ID')->unique();
            $table->integer('news_category_id')->default(0)->comment('分类')->index();
            $table->string('title')->comment('标题')->nullable();
            $table->string('seo_title')->comment('seo标题')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->text('seo_description')->comment('seo描述')->nullable();
            $table->string('image')->comment('图片')->nullable();
            $table->text('short')->comment('简要')->nullable();
            $table->text('content')->comment('内容')->nullable();
            $table->integer('read_count')->comment('阅读次数')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->comment('发布:1是，0否')->nullable();
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
        Schema::dropIfExists('news');
    }
}
