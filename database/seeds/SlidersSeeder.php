<?php

use Illuminate\Database\Seeder;

class SlidersSeeder extends Seeder
{
    public function run()
    {
        App\Models\Slider::create([
            'title'        => '轮播测试',
            'image'     => 'http://cdn001.eastyun.net/demo/slider1920x520.jpg',
            'status'      => '1'
        ]);
    }
}
