<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de configurações.
     */
    public function up(): void
    {
        Schema::create('configuracoes', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamento
            |--------------------------------------------------------------------------
            */

            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Configuração
            |--------------------------------------------------------------------------
            */

            $table->string('chave', 50);

            $table->text('valor');

            $table->text('descricao');

            /*
            |--------------------------------------------------------------------------
            | Auditoria
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Restrições
            |--------------------------------------------------------------------------
            */

            $table->unique(
                ['arenas_id', 'chave'],
                'uq_config_arena_chave'
            );

            /*
            |--------------------------------------------------------------------------
            | Índices
            |--------------------------------------------------------------------------
            */

            $table->index('arenas_id');
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};