<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Anwar',
            'email' => 'anwar@sipena-humas.com',
            'password' => bcrypt('password123'),
            'role' => 'super_admin',
            
        ]);
    }
}
