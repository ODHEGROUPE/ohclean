<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'nom' => 'Lavage Simple',
                'description' => 'Lavage standard de vos vêtements du quotidien (t-shirts, chemises, pantalons, etc.)',
                'image' => 'https://i.pinimg.com/736x/24/7b/55/247b559414b3d05ff8629be0285b335f.jpg',
            ],
            [
                'nom' => 'Repassage',
                'description' => 'Repassage professionnel pour un rendu impeccable de vos vêtements',
                'image' => 'https://i.pinimg.com/1200x/12/3a/a9/123aa902fa651c3dc856083d18d85ab9.jpg',
            ],
            [
                'nom' => 'Nettoyage à Sec',
                'description' => 'Nettoyage à sec pour vos vêtements délicats (costumes, robes, manteaux)',
                'image' => 'https://i.pinimg.com/1200x/95/61/38/956138620c3c5c253914afab22726f89.jpg',
            ],
            [
                'nom' => 'Blanchisserie',
                'description' => 'Service de blanchisserie pour draps, serviettes et linge de maison',
                'image' => 'https://images.unsplash.com/photo-1582735689369-4fe89db7114c?w=400&h=300&fit=crop',
            ],
            [
                'nom' => 'Détachage',
                'description' => 'Traitement spécial pour enlever les taches difficiles',
                'image' => 'https://images.unsplash.com/photo-1610557892470-55d9e80c0bce?w=400&h=300&fit=crop',
            ],
            [
                'nom' => 'Pressing Express',
                'description' => 'Service rapide avec livraison en 24h pour les urgences',
                'image' => 'https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?w=400&h=300&fit=crop',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
