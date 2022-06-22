<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile', 20)->comment('手机(帐号)')->nullable()->index();
            $table->tinyInteger('gender')->unsigned()->default(0)->comment('性别 0：保密 1：男，2：女')->index();
            $table->date('birthdate')->comment('出生日期')->nullable();
            $table->string('avatar')->comment('自定义头像')->nullable();
            $table->string('address')->comment('地址')->nullable();
            $table->string('wx_avatar')->comment('微信头像')->nullable();
            $table->string('wx_openid', 80)->comment('公众号openid')->nullable();
            $table->string('wx_nickname', 80)->comment('微信昵称')->nullable();
            $table->string('xcx_openid')->comment('小程序openid')->nullable();
            $table->string('unionid')->comment('unionid')->nullable();
            $table->string('session_key')->comment('session_key')->nullable();
            $table->tinyInteger('oauth_scope')->comment('授权：0未授权, 1静默授权，2用户信息授权')->default(0);
            $table->tinyInteger('status')->comment('状态:1->启用,0->禁用')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
