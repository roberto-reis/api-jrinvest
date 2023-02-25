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
        Schema::create('ativos', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('codigo', 20)->unique()->index();
            $table->foreignUuid('classe_ativo_uid');
            $table->string('nome', 100)->index();
            $table->string('setor', 100)->index();
            $table->timestamps();

            $table->foreign('classe_ativo_uid')->references('uid')->on('classes_ativos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ativos');
    }
};
