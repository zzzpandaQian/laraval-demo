<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        App\Models\User::create([
            'name'        => '张三',
            'email'       => 'zhangsan@example.com',
            'mobile'      => '18888888888',
            'gender'      => '2',
            'address'     => '四川',
            'xcx_openid'  => '1',
            'status'      => '1'
        ]);
    }
}
