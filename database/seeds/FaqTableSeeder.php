<?php

use Illuminate\Database\Seeder;
use App\Faq;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Faq::class, 10)->create();
    }
}
