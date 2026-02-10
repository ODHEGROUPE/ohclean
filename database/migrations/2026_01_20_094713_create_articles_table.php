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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2)->default(0);
            $table->string('categorie')->nullable(); // Vêtement, Linge de maison, Accessoire, etc.
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        // Ajouter article_id à ligne_commandes
        Schema::table('ligne_commandes', function (Blueprint $table) {
            $table->foreignId('article_id')->nullable()->after('service_id')->constrained()->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ligne_commandes', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
        });

        Schema::dropIfExists('articles');
    }
};
