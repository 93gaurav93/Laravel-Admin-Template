<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class student_s extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 57; $i++) {
            DB::table('student')->insert([
                'name' => $faker->name,
                'about' => $faker->realText(10),
                'dob' => $faker->dateTimeBetween('-27 years', '-17 years'),
                'file' => 'file_1.pdf',
                'photo' => $faker->imageUrl(150, 200, 'cats'),
                'book' => $faker->numberBetween(1, 50),
                'profile_link' => $faker->url,
                'gender' => $faker->numberBetween(1, 2),
                'email' => $faker->safeEmail,
                'age' => $faker->numberBetween(15, 25),
                'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
            ]);
        }

    }
}
