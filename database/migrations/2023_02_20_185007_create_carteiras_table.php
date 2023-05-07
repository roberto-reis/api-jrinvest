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
        Schema::create('carteiras', function (Blueprint $table) {
            $table->uuid('uid')->primary()->index();
            $table->foreignUuid('user_uid')->index();
            $table->foreignUuid('ativo_uid')->index();
            $table->string('quantidade_saldo');
            $table->string('preco_medio');
            $table->timestamps();

            $table->foreign('user_uid')->references('uid')->on('users')->cascadeOnDelete();
            $table->foreign('ativo_uid')->references('uid')->on('ativos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carteiras');
    }
};
