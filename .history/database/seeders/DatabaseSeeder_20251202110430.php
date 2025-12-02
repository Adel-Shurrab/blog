<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create one specific Admin user for YOU to log in with
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
        ]);

        // 2. Create 20 random users with mixed roles
        User::factory(20)->create();
        
    }
}
