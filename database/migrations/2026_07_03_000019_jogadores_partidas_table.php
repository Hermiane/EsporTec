<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Jogadores participantes das partidas.
     *
     * O jogador pode possuir cadastro no sistema
     * ou apenas informar nome e telefone para participar.
     */
    public function up(): void
    {
        Schema::create('jogadores_partidas', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Usuário participante.
             *
             * Pode ser nulo caso o jogador ainda
             * não possua cadastro.
             */
            $table->foreignId('usuarios_id')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Partida relacionada.
             */
            $table->foreignId('partidas_id')
                ->constrained('partidas')
                ->cascadeOnDelete();

            /**
             * Nome informado pelo jogador.
             */
            $table->string('nome_jogador', 100);

            /**
             * Contato informado.
             */
            $table->string('contato', 11)
                ->nullable();

            /**
             * Situação da participação.
             */
            $table->enum('status', [
                'pendente',
                'confirmado',
                'recusado'
            ])->default('pendente');

            $table->timestamps();

            /**
             * Índice utilizado para consultas
             * de participantes da partida.
             */
            $table->index([
                'partidas_id',
                'usuarios_id'
            ]);

        });
        /**
         * Validação do telefone.
         */
        DB::statement("ALTER TABLE jogadores_partidas ADD CONSTRAINT chk_jogadores_partidas_contato CHECK (CHAR_LENGTH(contato) = 11 OR contato IS NULL)");
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogadores_partidas');
    }
};