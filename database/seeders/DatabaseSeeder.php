<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            JsonDBSeeder::class, ]);

        User::factory()->create([
            'name' => 'Faros',
            'email' => 'admin@email.com',
            'user_type_id' => 12,
        ]);
        User::factory()->create([
            'name' => 'Ahmad Faros',
            'email' => 'ahmadfaros.othman@amkor.com',
            'user_type_id' => 10,
        ]);
    }
}
