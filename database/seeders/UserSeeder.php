<?php

namespace Database\Seeders;


use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;






class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'     => 'Test User 1',
            'email'    => 'test1@example.com',
            'balance'  => '0',
            'password' => Hash::make('123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'balance'  => '0',
            'password' => Hash::make('456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Test User 3',
            'email' => 'test3@example.com',
            'balance'  => '0',
            'password' => Hash::make('789'),
        ]);
    }
}
