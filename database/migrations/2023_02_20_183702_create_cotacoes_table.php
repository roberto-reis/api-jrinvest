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
        Schema::create('cotacoes', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('ativo_uid')->index();
            $table->char('moeda_ref', 3);
            $table->double('preco')->index();
            $table->timestamps();

            $table->foreign('ativo_uid')->references('uid')->on('ativos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotacoes');
    }
};
