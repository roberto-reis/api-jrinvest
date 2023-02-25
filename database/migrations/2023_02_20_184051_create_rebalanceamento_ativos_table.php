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
        Schema::create('rebalanceamento_ativos', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignId('user_id')->index();
            $table->foreignUuid('ativo_uid')->index();
            $table->decimal('percentual', 10, 2);
            $table->timestamps();
            $table->unique(['user_id', 'ativo_uid']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ativo_uid')->references('uid')->on('ativos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rebalanceamento_ativos');
    }
};
