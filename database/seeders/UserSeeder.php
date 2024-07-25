<?php

namespace Database\Seeders;

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
            'name' => 'Admin',
            'email' => 'admin@me.com',
            'phone' => '1234567890',
            'password' => Hash::make('1212'),
            'admin_password' => Hash::make('1212'),
            'type' => 'admin',
            'status' => 'active'
        ]);
    }
}
