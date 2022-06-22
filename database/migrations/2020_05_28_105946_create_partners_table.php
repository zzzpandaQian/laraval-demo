<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题')->nullable();
            $table->string('link')->comment('链接')->nullable();
            $table->string('image')->comment('图片')->nullable();
            $table->text('description')->comment('描述')->nullable();
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
        Schema::dropIfExists('partners');
    }
}
