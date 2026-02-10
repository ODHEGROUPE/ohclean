<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\LigneCommandeController;
use App\Http\Controllers\AbonnementControleur;
use App\Http\Controllers\WebhookControleur;
use App\Http\Controllers\ForfaitController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Pages publiques
// Suivi de commande sans compte (formulaire et résultat sur la même page)
Route::get('/suivi-commande', [ClientController::class, 'suiviCommandeForm'])->name('suivi-commande.form');
// Suivi de commande sans compte
Route::get('/a-propos', [ClientController::class, 'about'])->name('about');
Route::get('/services', [ClientController::class, 'services'])->name('services');
Route::get('/commander', [ClientController::class, 'commander'])->name('commander');
Route::get('/contact', [ClientController::class, 'contact'])->name('contact');

// Routes Abonnements (publiques pour voir les forfaits)
Route::get('/abonnement', [AbonnementControleur::class, 'index'])->name('abonnement.index');

// Routes Abonnements (authentification requise)
Route::middleware(['auth'])->group(function () {
    Route::post('/abonnement/souscrire', [AbonnementControleur::class, 'souscrire'])->name('abonnement.souscrire');
    Route::get('/abonnement/succes', [AbonnementControleur::class, 'succes'])->name('abonnement.succes');
    Route::get('/abonnement/annulation', [AbonnementControleur::class, 'annulation'])->name('abonnement.annulation');
    Route::get('/abonnement/actuel', [AbonnementControleur::class, 'actuel'])->name('abonnement.actuel');
    Route::get('/abonnement/historique', [AbonnementControleur::class, 'historique'])->name('abonnement.historique');

    // Profil client
    Route::get('/mon-profil', [ProfileController::class, 'clientProfile'])->name('client.profile');
    Route::patch('/mon-profil', [ProfileController::class, 'updateClientProfile'])->name('client.profile.update');

    // Mes commandes
    Route::get('/mes-commandes', [ClientController::class, 'mesCommandes'])->name('client.commandes');
    Route::get('/mes-commandes/{commande}', [ClientController::class, 'voirCommande'])->name('client.commandes.show');
    Route::get('/mes-commandes/{commande}/payer', [ClientController::class, 'payerCommande'])->name('client.commandes.payer');
});

// Passer commande (public)
Route::post('/commander', [ClientController::class, 'storeCommande'])->name('client.commander.store');
Route::get('/paiement', [ClientController::class, 'paiementPage'])->name('client.paiement');
Route::get('/paiement/confirmation', [ClientController::class, 'confirmationPaiement'])->name('client.paiement.confirmation');
Route::get('/commande/{commande}/confirmation', [ClientController::class, 'confirmationCommande'])->name('client.commandes.confirmation');

// Webhook KKiaPay (pas d'authentification - appelé par KKiaPay)
Route::post('/webhook/kkiapay', [WebhookControleur::class, 'gererWebhookKKiaPay'])->name('webhook.kkiapay');

// Admin Routes - Accessible uniquement aux ADMIN et AGENT_PRESSING
Route::prefix('admin')->middleware(['auth', 'verified', 'admin.or.agent'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin');

    Route::get('/calendar', function () {
        return view('admin.pages.calendar');
    })->name('admin.calendar');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes en lecture seule pour admin et agent
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

    Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/{paiement}', [PaiementController::class, 'show'])->name('paiements.show');

    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::post('/commandes/{commande}/changer-statut', [CommandeController::class, 'changerStatut'])
        ->name('commandes.changer-statut');
    Route::get('/commandes/{commande}/imprimer', [CommandeController::class, 'imprimer'])
        ->name('commandes.imprimer');

    Route::get('/ligneCommandes', [LigneCommandeController::class, 'index'])->name('ligneCommandes.index');
    Route::get('/ligneCommandes/{ligneCommande}', [LigneCommandeController::class, 'show'])->name('ligneCommandes.show');

    Route::get('/forfaits', [ForfaitController::class, 'index'])->name('admin.forfaits.index');
    Route::get('/forfaits/{forfait}', [ForfaitController::class, 'show'])->name('admin.forfaits.show');

    // Gestion des abonnements côté admin (lecture seule)
    Route::get('/abonnements', [AbonnementControleur::class, 'adminIndex'])->name('admin.abonnements.index');
    Route::get('/abonnements/{abonnement}', [AbonnementControleur::class, 'adminShow'])->name('admin.abonnements.show');
});

// Routes Admin Only - Modification/Suppression réservées à l'administrateur
Route::prefix('admin')->middleware(['auth', 'verified', 'admin.only'])->group(function () {
    // Gestion des utilisateurs (Admin uniquement)
    Route::resource('users', UserController::class);

    // Services - création, modification, suppression
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::patch('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Articles - création, modification, suppression
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::patch('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Paiements - création, modification, suppression
    Route::get('/paiements/create', [PaiementController::class, 'create'])->name('paiements.create');
    Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/paiements/{paiement}/edit', [PaiementController::class, 'edit'])->name('paiements.edit');
    Route::put('/paiements/{paiement}', [PaiementController::class, 'update'])->name('paiements.update');
    Route::patch('/paiements/{paiement}', [PaiementController::class, 'update']);
    Route::delete('/paiements/{paiement}', [PaiementController::class, 'destroy'])->name('paiements.destroy');

    // Commandes - création, modification, suppression
    Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
    Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
    Route::patch('/commandes/{commande}', [CommandeController::class, 'update']);
    Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');

    // LigneCommandes - création, modification, suppression
    Route::get('/ligneCommandes/create', [LigneCommandeController::class, 'create'])->name('ligneCommandes.create');
    Route::post('/ligneCommandes', [LigneCommandeController::class, 'store'])->name('ligneCommandes.store');
    Route::get('/ligneCommandes/{ligneCommande}/edit', [LigneCommandeController::class, 'edit'])->name('ligneCommandes.edit');
    Route::put('/ligneCommandes/{ligneCommande}', [LigneCommandeController::class, 'update'])->name('ligneCommandes.update');
    Route::patch('/ligneCommandes/{ligneCommande}', [LigneCommandeController::class, 'update']);
    Route::delete('/ligneCommandes/{ligneCommande}', [LigneCommandeController::class, 'destroy'])->name('ligneCommandes.destroy');

    // Forfaits - création, modification, suppression
    Route::get('/forfaits/create', [ForfaitController::class, 'create'])->name('admin.forfaits.create');
    Route::post('/forfaits', [ForfaitController::class, 'store'])->name('admin.forfaits.store');
    Route::get('/forfaits/{forfait}/edit', [ForfaitController::class, 'edit'])->name('admin.forfaits.edit');
    Route::put('/forfaits/{forfait}', [ForfaitController::class, 'update'])->name('admin.forfaits.update');
    Route::patch('/forfaits/{forfait}', [ForfaitController::class, 'update']);
    Route::delete('/forfaits/{forfait}', [ForfaitController::class, 'destroy'])->name('admin.forfaits.destroy');
});

require __DIR__ . '/auth.php';
