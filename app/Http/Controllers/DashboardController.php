<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Abonnement;
use App\Models\Service;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord avec les statistiques
     */
    public function index()
    {
        // Statistiques générales
        $stats = [
            'totalClients' => User::where('role', 'CLIENT')->count(),
            'totalCommandes' => Commande::count(),
            'commandesEnCours' => Commande::where('statut', 'EN_COURS')->count(),
            'commandesPret' => Commande::where('statut', 'PRET')->count(),
            'commandesTerminees' => Commande::where('statut', 'LIVREE')->count(),
            'totalPaiements' => Paiement::count(),
            'montantTotalPaiements' => Paiement::sum('montant'),
            'totalAbonnements' => Abonnement::where('etat', 'actif')->count(),
            'totalServices' => Service::count(),
            'totalArticles' => Article::count(),
        ];

        // Revenus du mois en cours
        $debutMois = Carbon::now()->startOfMonth();
        $finMois = Carbon::now()->endOfMonth();

        $revenuMois = Paiement::whereBetween('created_at', [$debutMois, $finMois])->sum('montant');

        // Revenus des 6 derniers mois pour le graphique
        $revenusParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $montant = Paiement::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('montant');
            $revenusParMois[] = [
                'mois' => $date->translatedFormat('M Y'),
                'montant' => $montant,
            ];
        }

        // Commandes récentes
        $commandesRecentes = Commande::with(['user', 'paiement'])
            ->latest()
            ->take(5)
            ->get();

        // Paiements récents
        $paiementsRecents = Paiement::with('commande.user')
            ->latest()
            ->take(5)
            ->get();

        // Répartition des commandes par statut
        $commandesParStatut = Commande::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->get()
            ->pluck('total', 'statut')
            ->toArray();

        return view('admin.pages.dashboard', compact(
            'stats',
            'revenuMois',
            'revenusParMois',
            'commandesRecentes',
            'paiementsRecents',
            'commandesParStatut'
        ));
    }
}
