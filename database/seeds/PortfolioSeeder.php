<?php

use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{

    public function run()
    {
        App\Models\Portfolio::create([
            'title'     => '案例测试',
            'sub_title' => '案例测试',
            'image'     => 'http://cdn001.eastyun.net/demo/pic04-320x320.jpg',
            'status'    => 1,
        ]);
    }
}
