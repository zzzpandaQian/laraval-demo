<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioIntroductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_introductions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题')->index();
            $table->text('content')->comment('内容')->nullable();
            $table->unsignedInteger('portfolio_id');
            $table->foreign('portfolio_id')->references('id')->on('portfolios')->onDelete('cascade');
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
        Schema::dropIfExists('portfolio_introductions');
    }
}
