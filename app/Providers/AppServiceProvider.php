<?php

namespace App\Providers;

use Validator;
use App\Models\User;
use Encore\Admin\Config\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Validator::extend('zh_mobile', function ($attribute, $value) {
            return preg_match('/^(\+?0?86\-?)?((13\d|14[57]|15[^4,\D]|166|17[01235678]|18\d|19[89])\d{8})$/', $value);
        });

        // 是否https
        if (env('IS_HTTPS')) {
            URL::forceScheme('https');
        }

        $table = config('admin.extensions.config.table', 'admin_config');
        if (class_exists(Config::class) && Schema::hasTable($table)) {
            Config::load();
        }

        Schema::defaultStringLength(191);

        // 注册校验密码
        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            $user = User::find($parameters[0]);
            return $user && Hash::check($value, $user->password);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
