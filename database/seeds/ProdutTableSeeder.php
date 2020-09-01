<?php

use Illuminate\Database\Seeder;

class ProdutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Product::class, 15)->create();
    }
}
