<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Feedbacks enviados pelos usuários após a utilização
     * dos serviços da arena.
     */
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Reserva relacionada ao feedback.
             */
            $table->foreignId('reservas_id')
                ->constrained('reservas')
                ->cascadeOnDelete();

            /**
             * Usuário que enviou o feedback.
             */
            $table->foreignId('usuarios_id')
                ->constrained('usuarios')
                ->cascadeOnDelete();

            /**
             * Arena avaliada.
             */
            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /**
             * Momento em que o feedback foi solicitado.
             */
            $table->enum('momento', [
                'pos_pagamentos',
                'pos_jogo',
            ]);

            /**
             * Nota da avaliação.
             */
            $table->unsignedTinyInteger('nota');

            /**
             * Comentário do usuário.
             */
            $table->text('comentario')
                ->nullable();

            /**
             * Define se o feedback ficará visível
             * para outros usuários.
             */
            $table->boolean('visivel')
                ->default(true);

            /**
             * Usuário responsável pela resposta.
             */
            $table->foreignId('respondido_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Resposta da arena.
             */
            $table->text('resposta')
                ->nullable();

            $table->timestamps();

            /**
             * Garante apenas um feedback
             * por momento da reserva.
             */
            $table->unique([
                'reservas_id',
                'momento',
            ]);

            /**
             * Índice utilizado para exibição
             * de avaliações públicas.
             */
            $table->index([
                'usuarios_id',
                'visivel',
            ]);

        });
        /**
         * Nota permitida entre 1 e 5.
         */
        DB::statement('ALTER TABLE feedbacks ADD CONSTRAINT chk_feedbacks_nota CHECK (nota BETWEEN 1 AND 5)');
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
