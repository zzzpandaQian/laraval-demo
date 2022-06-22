<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('seo_url')->comment('URL')->nullable();
            $table->string('seo_title')->comment('seo标题')->nullable();
            $table->string('seo_keywords')->comment('seo关键词')->nullable();
            $table->text('seo_description')->comment('seo描述')->nullable();

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
        Schema::dropIfExists('seo_items');
    }
}
