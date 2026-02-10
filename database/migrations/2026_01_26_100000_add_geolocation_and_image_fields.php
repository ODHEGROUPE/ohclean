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
        // Ajouter la géolocalisation aux commandes
        Schema::table('commandes', function (Blueprint $table) {
            if (!Schema::hasColumn('commandes', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('facture');
            }
            if (!Schema::hasColumn('commandes', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('commandes', 'adresse_livraison')) {
                $table->string('adresse_livraison')->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('commandes', 'instructions')) {
                $table->text('instructions')->nullable()->after('adresse_livraison');
            }
        });

        // Ajouter l'image et la description aux services
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'description')) {
                $table->text('description')->nullable()->after('nom');
            }
            if (!Schema::hasColumn('services', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'adresse_livraison', 'instructions']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['image', 'description']);
        });
    }
};
