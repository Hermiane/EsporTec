<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Cria a tabela de auditoria do sistema.
     *
     * Responsável por armazenar todas as operações
     * importantes realizadas pelos usuários.
     */
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {

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

            $table->foreignId('usuarios_id')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            $table->foreignId('arenas_id')
                ->nullable()
                ->constrained('arenas')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informações da auditoria
            |--------------------------------------------------------------------------
            */

            $table->string('acao', 100);

            $table->text('descricao');

            $table->string('tabela_afetada', 100);

            $table->unsignedBigInteger('registro_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Segurança
            |--------------------------------------------------------------------------
            */

            $table->string('ip', 45);

            /*
            |--------------------------------------------------------------------------
            | Auditoria
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Índices
            |--------------------------------------------------------------------------
            */

            $table->index(
                ['usuarios_id', 'arenas_id'],
                'idx_auditoria_usuarios_arenas'
            );

            $table->index(
                'acao',
                'idx_auditoria_acao'
            );
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};