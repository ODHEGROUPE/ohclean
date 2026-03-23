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
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('commande_id')->nullable()->after('user_id')->constrained('commandes')->nullOnDelete();
            $table->string('type')->default('info')->after('message');
            $table->timestamp('lue_at')->nullable()->after('dateEnvoi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['commande_id']);
            $table->dropColumn(['commande_id', 'type', 'lue_at']);
        });
    }
};
