<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class book_s extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('book')->insert([
                'title' => $faker->words(5, true),
            ]);
        }
    }
}
