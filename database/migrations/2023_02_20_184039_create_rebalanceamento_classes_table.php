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
        Schema::create('rebalanceamento_classes', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('user_uid');
            $table->foreignUuid('classe_ativo_uid');
            $table->double('percentual', 10, 2);
            $table->timestamps();
            $table->unique(['user_uid', 'classe_ativo_uid']);

            $table->foreign('user_uid')->references('uid')->on('users');
            $table->foreign('classe_ativo_uid')->references('uid')->on('classes_ativos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rebalanceamento_classes');
    }
};
