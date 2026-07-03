<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Partidas abertas pelos usuários.
     *
     * Cada partida está vinculada a uma reserva já
     * realizada e possui um link de compartilhamento
     * para permitir que outros jogadores participem.
     */
    public function up(): void
    {
        Schema::create('partidas', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Reserva responsável pela partida.
             */
            $table->foreignId('reservas_id')
                ->constrained('reservas')
                ->cascadeOnDelete();

            /**
             * Link público da partida.
             *
             * Exemplo:
             * https://esportec.com/partida/ABC123
             */
            $table->string('link_partida')
                ->unique();

            /**
             * Quantidade máxima de jogadores.
             */
            $table->unsignedInteger('max_jogador')
                ->default(22);

            /**
             * Indica se a partida ainda aceita jogadores.
             */
            $table->boolean('ativo')
                ->default(true);

            $table->timestamps();

            /**
             * Índice utilizado para localizar
             * rapidamente a reserva.
             */
            $table->index('reservas_id');

            /**
             * Quantidade máxima precisa ser positiva.
             */
            $table->check('max_jogador > 0');
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};