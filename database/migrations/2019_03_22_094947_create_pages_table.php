<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题')->index();
            $table->string('seo_title')->comment('seo标题')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->text('seo_description')->comment('seo描述')->nullable();
            $table->tinyInteger('parent_id')->comment('父级菜单')->nullable();
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->string('permalink')->comment('链接')->nullable();
            $table->text('content')->comment('内容')->nullable();
            $table->tinyInteger('status')->comment('发布状态：0未发布，1发布')->default(0);
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
        Schema::dropIfExists('pages');
    }
}
