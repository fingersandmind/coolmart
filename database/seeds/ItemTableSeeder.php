<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Item::class, 10)->create();
    }
}
