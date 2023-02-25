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
        Schema::create('classes_ativos', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('nome', 50);
            $table->string('nome_interno', 50)->unique()->index();
            $table->string('descricao', 60)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes_ativos');
    }
};
