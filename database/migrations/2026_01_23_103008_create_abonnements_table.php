<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('forfait_id')->nullable()->constrained('forfaits')->onDelete('set null');
            $table->string('nom_forfait');                      // Nom du forfait au moment de l'achat
            $table->integer('montant');                         // Prix payé en XOF
            $table->integer('duree_jours');                     // Durée en jours
            $table->integer('credits');                         // Crédits restants
            $table->integer('credits_initiaux');                // Crédits au départ
            $table->string('identifiant_transaction_kkpay')->nullable(); // Référence KKiaPay
            $table->enum('etat', ['en_attente', 'actif', 'echec', 'expire', 'annule'])->default('en_attente');
            $table->timestamp('date_debut')->nullable();
            $table->timestamp('date_expiration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
