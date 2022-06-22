<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('url')->nullable();
            $table->string('ip')->nullable();
            $table->string('mobile')->nullable();
            $table->string('color')->nullable();
            $table->string('currency')->nullable();
            $table->integer('number')->nullable();
            $table->string('rate')->nullable();
            $table->text('editor')->nullable();
            $table->string('switch')->nullable();
            $table->string('icon')->nullable();
            $table->string('slider')->nullable();

            $table->string('radio')->nullable();
            $table->string('checkbox')->nullable();
            $table->string('select')->nullable();
            $table->string('multipleSelect')->nullable();
            $table->string('listbox')->nullable();
            $table->string('nationality')->nullable();
            $table->string('name')->nullable();
            $table->string('idcard')->nullable();
            $table->string('passport')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();

            $table->string('timezone')->nullable();
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->time('timeRangeStart')->nullable();
            $table->time('timeRangeEnd')->nullable();
            $table->date('dateRangeStart')->nullable();
            $table->date('dateRangeEnd')->nullable();
            $table->dateTime('datetimeRangeStart')->nullable();
            $table->dateTime('datetimeRangeEnd')->nullable();

            $table->string('image')->nullable();
            $table->text('multipleImage')->nullable();
            $table->string('file')->nullable();
            $table->text('multipleFile')->nullable();

            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('demos');
    }
}
