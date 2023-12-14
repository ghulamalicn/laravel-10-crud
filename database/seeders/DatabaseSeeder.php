<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void //void: PHP type declarations, and run method doesn't return any specific value.
    {
        $this->call([
            RolesTableSeeder::class,
            // Add other seeders if needed
        ]);

        \App\Models\User::factory()->count(10)->create();
    }
}
