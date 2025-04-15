<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'Udin Admin',
                    'email' => 'admin@gmail.com',
                    'role' => 'admin',
                    'password' => Hash::make('1234')
                ],
                [
                    'name' => 'Udin Staff',
                    'email' => 'staff@gmail.com',
                    'role' => 'staff',
                    'password' => Hash::make('1234')
                ]
            ]
                );
    }
}
