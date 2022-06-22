<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTablesSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(SlidersSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(NewsCategorySeeder::class);
        $this->call(PortfolioSeeder::class);
        $this->call(NewsSeeder::class);
    }
}
