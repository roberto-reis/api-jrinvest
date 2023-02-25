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
            $table->foreignId('user_id')->index();
            $table->foreignUuid('ativo_uid')->index();
            $table->string('tipo_operacao', 20)->index();
            $table->string('quantidade', 50);
            $table->string('cotacao_preco', 50);
            $table->string('corretora', 50)->index();
            $table->timestamp('data_operacao');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ativo_uid')->references('uid')->on('ativos');
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
