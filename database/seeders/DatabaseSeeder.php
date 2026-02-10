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

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'esperance@gmail.com',
            'password' => 'password',
            'role' => 'ADMIN',
        ]);

         User::factory()->create([
            'name' => 'Agent User',
            'email' => 'agent@gmail.com',
            'password' => 'password',
            'role' => 'AGENT_PRESSING',
        ]);
        User::factory()->create([
            'name' => 'Client User',
            'email' => 'client@gmail.com',
            'password' => 'password',
            'role' => 'CLIENT',
        ]);

        // Créer les forfaits par défaut
        $this->call(ForfaitSeeder::class);

        // Créer les services de pressing
        $this->call(ServiceSeeder::class);

        // Créer les articles pour chaque service
        $this->call(ArticleSeeder::class);
    }
}
