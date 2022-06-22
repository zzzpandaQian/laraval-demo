<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run()
    {

        $b = '';
        for ($i=0; $i<300; $i++) {
            // 使用chr()函数拼接双字节汉字，前一个chr()为高位字节，后一个为低位字节
            $a = chr(mt_rand(0xB0,0xD0)).chr(mt_rand(0xA1, 0xF0));
            // 转码
            $b .= iconv('GB2312', 'UTF-8', $a);
        }

        App\Models\Page::create([
            'title'           => 'Privacy Policy',
            'parent_id'       => '0',
            'seo_title'       => 'Privacy Policy',
            'seo_keywords'    => 'Privacy Policy',
            'seo_description' => 'Privacy Policy',
            'sort_order'           => '0',
            'permalink'       => 'about',
            'content'         => $b,
            'status'          => '1',
        ]);

        App\Models\Page::create([
            'title'           => 'Terms of Use',
            'parent_id'       => '0',
            'seo_title'       => 'Terms of Use',
            'seo_keywords'    => 'Terms of Use',
            'seo_description' => 'Terms of Use',
            'sort_order'           => '1',
            'permalink'       => 'terms',
            'content'         => $b,
            'status'          => '1',
        ]);
    }
}
