<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permissões dos funcionários.
     *
     * Um funcionário pode possuir diversas permissões,
     * e uma mesma permissão pode ser atribuída a vários
     * funcionários.
     */
    public function up(): void
    {
        Schema::create('funcionarios_permissoes', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Funcionário da arena.
             */
            $table->foreignId('funcionarios_id')
                ->constrained('funcionarios_arenas')
                ->cascadeOnDelete();

            /**
             * Permissão concedida.
             */
            $table->foreignId('permissoes_id')
                ->constrained('permissoes')
                ->cascadeOnDelete();

            /**
             * Usuário responsável por conceder
             * esta permissão.
             */
            $table->foreignId('concedido_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            $table->timestamps();

            /**
             * Impede permissões duplicadas
             * para o mesmo funcionário.
             */
            $table->unique([
                'funcionarios_id',
                'permissoes_id'
            ]);
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios_permissoes');
    }
};