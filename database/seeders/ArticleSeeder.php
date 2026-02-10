<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les services existants créés par ServiceSeeder
        $lavageSimple = Service::where('nom', 'Lavage Simple')->first();
        $repassage = Service::where('nom', 'Repassage')->first();
        $nettoyageSec = Service::where('nom', 'Nettoyage à Sec')->first();
        $blanchisserie = Service::where('nom', 'Blanchisserie')->first();
        $detachage = Service::where('nom', 'Détachage')->first();
        $pressingExpress = Service::where('nom', 'Pressing Express')->first();

        // Articles pour Lavage Simple
        if ($lavageSimple) {
            $articles = [
                ['nom' => 'T-shirt', 'description' => 'T-shirt homme/femme', 'prix' => 500],
                ['nom' => 'Chemise', 'description' => 'Chemise classique', 'prix' => 800],
                ['nom' => 'Pantalon', 'description' => 'Pantalon classique', 'prix' => 1000],
                ['nom' => 'Jean', 'description' => 'Jean denim', 'prix' => 1000],
                ['nom' => 'Pull', 'description' => 'Pull en laine ou coton', 'prix' => 1200],
                ['nom' => 'Jupe', 'description' => 'Jupe classique', 'prix' => 800],
                ['nom' => 'Robe simple', 'description' => 'Robe de tous les jours', 'prix' => 1200],
            ];

            foreach ($articles as $article) {
                Article::create(array_merge($article, [
                    'service_id' => $lavageSimple->id,
                    'actif' => true
                ]));
            }
        }

        // Articles pour Repassage
        if ($repassage) {
            $articles = [
                ['nom' => 'Chemise repassage', 'description' => 'Repassage chemise', 'prix' => 300],
                ['nom' => 'Pantalon repassage', 'description' => 'Repassage pantalon', 'prix' => 400],
                ['nom' => 'T-shirt repassage', 'description' => 'Repassage t-shirt', 'prix' => 200],
                ['nom' => 'Robe repassage', 'description' => 'Repassage robe', 'prix' => 500],
                ['nom' => 'Nappe', 'description' => 'Repassage nappe', 'prix' => 600],
                ['nom' => 'Costume complet', 'description' => 'Repassage costume 2 pièces', 'prix' => 1500],
            ];

            foreach ($articles as $article) {
                Article::create(array_merge($article, [
                    'service_id' => $repassage->id,
                    'actif' => true
                ]));
            }
        }

        // Articles pour Nettoyage à Sec
        if ($nettoyageSec) {
            $articles = [
                ['nom' => 'Costume', 'description' => 'Costume 2 pièces homme', 'prix' => 3000],
                ['nom' => 'Veste', 'description' => 'Veste de costume', 'prix' => 2000],
                ['nom' => 'Manteau', 'description' => 'Manteau hiver', 'prix' => 4000],
                ['nom' => 'Robe de soirée', 'description' => 'Robe longue de soirée', 'prix' => 3500],
                ['nom' => 'Blouson cuir', 'description' => 'Blouson en cuir', 'prix' => 5000],
                ['nom' => 'Sac à main cuir', 'description' => 'Sac à main en cuir', 'prix' => 3000],
            ];

            foreach ($articles as $article) {
                Article::create(array_merge($article, [
                    'service_id' => $nettoyageSec->id,
                    'actif' => true
                ]));
            }
        }

        // Articles pour Blanchisserie
        if ($blanchisserie) {
            $articles = [
                ['nom' => 'Drap 1 place', 'description' => 'Drap de lit 1 place', 'prix' => 1000],
                ['nom' => 'Drap 2 places', 'description' => 'Drap de lit 2 places', 'prix' => 1500],
                ['nom' => 'Housse de couette', 'description' => 'Housse de couette', 'prix' => 2000],
                ['nom' => 'Couverture', 'description' => 'Couverture', 'prix' => 2500],
                ['nom' => 'Serviette de bain', 'description' => 'Serviette de bain grande', 'prix' => 500],
                ['nom' => 'Rideau', 'description' => 'Rideau (la pièce)', 'prix' => 1500],
                ['nom' => 'Nappe de table', 'description' => 'Nappe de table', 'prix' => 1000],
            ];

            foreach ($articles as $article) {
                Article::create(array_merge($article, [
                    'service_id' => $blanchisserie->id,
                    'actif' => true
                ]));
            }
        }

        // Articles pour Détachage
        if ($detachage) {
            $articles = [
                ['nom' => 'Détachage simple', 'description' => 'Tache légère (café, jus)', 'prix' => 500],
                ['nom' => 'Détachage moyen', 'description' => 'Tache moyenne (huile, encre)', 'prix' => 1000],
                ['nom' => 'Détachage difficile', 'description' => 'Tache difficile (vin, sang)', 'prix' => 1500],
                ['nom' => 'Tapis petit', 'description' => 'Détachage tapis petit format', 'prix' => 3000],
                ['nom' => 'Tapis grand', 'description' => 'Détachage tapis grand format', 'prix' => 5000],
            ];

            foreach ($articles as $article) {
                Article::create(array_merge($article, [
                    'service_id' => $detachage->id,
                    'actif' => true
                ]));
            }
        }

        // Articles pour Pressing Express
        if ($pressingExpress) {
            $articles = [
                ['nom' => 'Chemise express', 'description' => 'Lavage + repassage express 24h', 'prix' => 1500],
                ['nom' => 'Costume express', 'description' => 'Nettoyage costume express 24h', 'prix' => 5000],
                ['nom' => 'Robe express', 'description' => 'Nettoyage robe express 24h', 'prix' => 3000],
                ['nom' => 'Pantalon express', 'description' => 'Lavage + repassage pantalon 24h', 'prix' => 2000],
            ];

            foreach ($articles as $article) {
                Article::create(array_merge($article, [
                    'service_id' => $pressingExpress->id,
                    'actif' => true
                ]));
            }
        }
    }
}
