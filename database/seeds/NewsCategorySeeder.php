<?php

use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{

    public function run()
    {
        App\Models\NewsCategory::create([
            'title'       => '娱乐新闻',
            'status'      => 1,
        ]);

        App\Models\NewsCategory::create([
            'title'       => '国际新闻',
            'status'      => 1,
        ]);
    }
}
