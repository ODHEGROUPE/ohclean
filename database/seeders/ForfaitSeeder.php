<?php

namespace Database\Seeders;

use App\Models\Forfait;
use Illuminate\Database\Seeder;

class ForfaitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forfaits = [
            [
                'nom' => 'Basique',
                'slug' => 'basique',
                'description' => 'Idéal pour les besoins occasionnels',
                'montant' => 5000,
                'duree_jours' => 30,
                'credits' => 10,
                'caracteristiques' => [
                    '10 lessives par mois',
                    'Livraison sur demande',
                    'Support par SMS',
                ],
                'est_populaire' => false,
                'actif' => true,
                'ordre' => 1,
            ],
            [
                'nom' => 'Premium',
                'slug' => 'premium',
                'description' => 'Pour les familles et professionnels',
                'montant' => 10000,
                'duree_jours' => 30,
                'credits' => 30,
                'caracteristiques' => [
                    '30 lessives par mois',
                    'Livraison gratuite',
                    'Support prioritaire',
                    '-10% sur les lessives supplémentaires',
                ],
                'est_populaire' => true,
                'actif' => true,
                'ordre' => 2,
            ],
            [
                'nom' => 'VIP',
                'slug' => 'vip',
                'description' => 'Service illimité & prioritaire',
                'montant' => 20000,
                'duree_jours' => 30,
                'credits' => 999,
                'caracteristiques' => [
                    'Lessives illimitées',
                    'Livraison gratuite',
                    'Support 24/7',
                    'Service prioritaire',
                    'Vêtements délicats gratuit',
                ],
                'est_populaire' => false,
                'actif' => true,
                'ordre' => 3,
            ],
        ];

        foreach ($forfaits as $forfait) {
            Forfait::updateOrCreate(
                ['slug' => $forfait['slug']],
                $forfait
            );
        }
    }
}
