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
        Schema::create('operacoes', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('user_uid')->index();
            $table->foreignUuid('ativo_uid')->index();
            $table->foreignUuid('tipo_operacao_uid')->index();
            $table->foreignUuid('corretora_uid');
            $table->double('quantidade');
            $table->double('cotacao_preco');
            $table->timestamp('data_operacao');
            $table->timestamps();

            $table->foreign('user_uid')->references('uid')->on('users');
            $table->foreign('ativo_uid')->references('uid')->on('ativos');
            $table->foreign('tipo_operacao_uid')->references('uid')->on('tipos_operacoes');
            $table->foreign('corretora_uid')->references('uid')->on('corretoras')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operacoes');
    }
};
