<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题')->index();
            $table->string('sub_title')->comment('副标题')->nullable();
            $table->string('image')->comment('图片')->nullable();
            $table->text('more_images')->nullable()->comment('多图片');
            $table->text('content')->comment('内容')->nullable();
            $table->tinyInteger('status')->default(0)->comment('发布状态：0未发布，1发布');
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
        Schema::dropIfExists('portfolios');
    }
}
