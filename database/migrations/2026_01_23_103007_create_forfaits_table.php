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
        Schema::create('forfaits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                          // Nom du forfait (Basique, Premium, VIP)
            $table->string('slug')->unique();               // Identifiant unique (basique, premium, vip)
            $table->text('description')->nullable();        // Description du forfait
            $table->integer('montant');                     // Prix en XOF (5000, 10000, 20000)
            $table->integer('duree_jours')->default(30);    // Durée en jours
            $table->integer('credits');                     // Nombre de lessives (999 = illimité)
            $table->json('caracteristiques')->nullable();   // Liste des avantages
            $table->boolean('est_populaire')->default(false); // Afficher badge "Populaire"
            $table->boolean('actif')->default(true);        // Forfait disponible ou non
            $table->integer('ordre')->default(0);           // Ordre d'affichage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forfaits');
    }
};
