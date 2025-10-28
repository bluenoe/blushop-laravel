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
        // User::factory(10)->create();

        // Create a local admin for testing the /admin panel
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@blushop.local',
            'is_admin' => true,
        ]);

        // Optionally seed demo products
        // $this->call(ProductSeeder::class);
    }
}
