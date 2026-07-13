<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Funcionários das arenas.
     *
     * Controla todos os funcionários vinculados
     * às arenas do sistema.
     */
    public function up(): void
    {
        Schema::create('funcionarios_arenas', function (Blueprint $table) {

            // Identificador
            $table->id();

            /**
             * Arena onde o funcionário trabalha.
             */
            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /**
             * Usuário que representa o funcionário.
             */
            $table->foreignId('usuarios_id')
                ->constrained('usuarios')
                ->restrictOnDelete();

            /**
             * Administrador responsável pelo cadastro.
             */
            $table->foreignId('criado_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Cargo do funcionário.
             *
             * Ex:
             * Recepcionista
             * Zelador
             * Caixa
             * Gerente
             */
            $table->string('cargo', 50);

            /**
             * Turno de trabalho.
             */
            $table->enum('turno', [
                'manha',
                'tarde',
                'noite',
                'integral',
            ]);

            /**
             * Data de contratação.
             */
            $table->date('data_entrada')
                ->useCurrent();

            /**
             * Controle lógico.
             */
            $table->boolean('ativo')
                ->default(true);

            $table->timestamps();

            /**
             * Impede duplicidade de funcionário
             * na mesma arena.
             */
            $table->unique([
                'arenas_id',
                'usuarios_id',
            ]);

            /**
             * Índice utilizado para pesquisas
             * por funcionários ativos.
             */
            $table->index('ativo');
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios_arenas');
    }
};
