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
                'image' => 'https://images.unsplash.com/photo-1545173168-9f1947eebb7f?w=400&h=300&fit=crop',
            ],
            [
                'nom' => 'Repassage',
                'description' => 'Repassage professionnel pour un rendu impeccable de vos vêtements',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
            ],
            [
                'nom' => 'Nettoyage à Sec',
                'description' => 'Nettoyage à sec pour vos vêtements délicats (costumes, robes, manteaux)',
                'image' => 'https://images.unsplash.com/photo-1489274495757-95c7c837b101?w=400&h=300&fit=crop',
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
