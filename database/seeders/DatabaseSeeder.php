<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'login' => 'admin',
            'email' => 'admin@megafon.tj',
            'password' => bcrypt('password'),
        ]);
    }
}
