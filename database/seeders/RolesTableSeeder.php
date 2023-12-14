<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::factory()->create(['name' => 'admin', 'description' => 'Administrator']);
        \App\Models\Role::factory()->create(['name' => 'user', 'description' => 'Regular User']);
    }
}
