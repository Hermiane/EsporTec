<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de chamados de suporte.
     */
    public function up(): void
    {
        Schema::create('suportes', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamentos
            |--------------------------------------------------------------------------
            */

            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->restrictOnDelete();

            $table->foreignId('usuarios_id')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informações do chamado
            |--------------------------------------------------------------------------
            */

            $table->string('titulo');

            $table->text('descricao');

            $table->enum('status', [
                'aberto',
                'em_andamento',
                'pendente',
                'resolvido',
                'cancelado',
                'fechado',
            ])->default('aberto');

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
                'status',
                'idx_suportes_status'
            );
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('suportes');
    }
};
