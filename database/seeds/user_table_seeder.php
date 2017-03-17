<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class user_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "GD1",
            'email' => '93gaurav93@gmail.com',
            'password' => Hash::make('12345678'),
            'level' => 1
        ]);
        DB::table('users')->insert([
            'name' => "GD2",
            'email' => '93gaurav9302@gmail.com',
            'password' => Hash::make('12345678'),
            'level' => 3
        ]);
    }
}
