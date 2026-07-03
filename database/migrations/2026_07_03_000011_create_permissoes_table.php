<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela responsável por armazenar todas as permissões
     * disponíveis no sistema.
     *
     * Exemplo:
     * - Gerenciar Reservas
     * - Gerenciar Quadras
     * - Gerenciar Funcionários
     * - Financeiro
     */
    public function up(): void
    {
        Schema::create('permissoes', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Nome da permissão.
             */
            $table->string('titulo', 50)
                  ->unique();

            /**
             * Explicação da permissão.
             */
            $table->text('descricao')
                  ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissoes');
    }
};