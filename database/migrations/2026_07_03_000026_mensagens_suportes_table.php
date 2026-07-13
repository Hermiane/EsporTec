<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de mensagens dos chamados de suporte.
     *
     * Cada chamado pode possuir diversas mensagens
     * trocadas entre o usuário e a equipe administrativa.
     */
    public function up(): void
    {
        Schema::create('mensagens_suportes', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Identificação
            |--------------------------------------------------------------------------
            */

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamentos
            |--------------------------------------------------------------------------
            */

            $table->foreignId('suportes_id')
                ->constrained('suportes')
                ->cascadeOnDelete();

            $table->foreignId('usuarios_id')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Conteúdo da mensagem
            |--------------------------------------------------------------------------
            */

            $table->text('mensagem');

            /*
            |--------------------------------------------------------------------------
            | Auditoria
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensagens_suportes');
    }
};
