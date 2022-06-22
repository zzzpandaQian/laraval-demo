<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->comment('区域ID')->nullable();
            $table->string('title')->comment('经销商')->nullable();
            $table->string('tel')->comment('电话')->nullable();
            $table->text('description')->comment('描述')->nullable();
            $table->string('longitude')->comment('经纬度')->nullable();
            $table->string('latitude')->comment('经纬度')->nullable();
            $table->tinyInteger('status')->default(0)->comment('发布:1是，0否');
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
        Schema::dropIfExists('dealers');
    }
}
