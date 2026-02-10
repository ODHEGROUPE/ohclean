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
        // Supprimer le prix et description du service (un service a juste un nom)
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['prix', 'description']);
        });

        // Ajouter service_id aux articles (un article appartient à un service)
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->dropColumn('categorie'); // On n'a plus besoin de catégorie, le service fait office de catégorie
        });

        // Supprimer service_id de ligne_commandes (on garde seulement article_id)
        Schema::table('ligne_commandes', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ligne_commandes', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
            $table->string('categorie')->default('AUTRE');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2)->default(0);
        });
    }
};
