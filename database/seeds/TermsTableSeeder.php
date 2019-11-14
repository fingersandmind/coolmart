<?php

use Illuminate\Database\Seeder;
use App\Term;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Term::class, 10)->create();
    }
}
