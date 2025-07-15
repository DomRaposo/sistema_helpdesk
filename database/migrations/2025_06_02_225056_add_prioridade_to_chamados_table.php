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
        Schema::table('chamados', function (Blueprint $table) {
            $table->enum('prioridade', ['baixo', 'medio', 'alto'])->default('medio')->after('assunto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chamados', function (Blueprint $table) {
            $table->dropColumn('prioridade');
        });
    }
};
