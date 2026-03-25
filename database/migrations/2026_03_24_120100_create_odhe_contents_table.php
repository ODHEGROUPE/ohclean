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
        Schema::create('odhe_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('À Propos de Nous');
            $table->text('hero_subtitle')->nullable();
            $table->string('story_badge')->default('Notre Histoire');
            $table->string('story_title')->nullable();
            $table->text('story_text_1')->nullable();
            $table->text('story_text_2')->nullable();
            $table->string('story_image')->nullable();
            $table->string('team_title')->default('Rencontrez Notre Équipe');
            $table->text('team_subtitle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odhe_contents');
    }
};
