<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('标签')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('news_has_tags', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('news_id')->unsigned();
            $table->integer('news_tag_id')->unsigned();

            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade');

            $table->foreign('news_tag_id')
                ->references('id')
                ->on('news_tags')
                ->onDelete('cascade');

            // $table->primary(['news_id', 'news_tag_id']);
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
        Schema::dropIfExists('news_tags');
        Schema::dropIfExists('news_has_tags');
    }
}
