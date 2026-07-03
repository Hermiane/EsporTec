<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reservas das quadras.
     *
     * Toda reserva pertence a um usuário
     * e a uma quadra.
     *
     * O histórico de alterações será armazenado
     * em uma tabela própria.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Cliente responsável pela reserva.
             */
            $table->foreignId('reservas_usuarios_id')
                ->constrained('usuarios')
                ->cascadeOnDelete();

            /**
             * Quadra reservada.
             */
            $table->foreignId('quadras_id')
                ->constrained('quadras')
                ->cascadeOnDelete();

            /**
             * Usuário responsável pela última alteração.
             */
            $table->foreignId('alteradas_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Data da reserva.
             */
            $table->date('data');

            /**
             * Horário inicial.
             */
            $table->time('hora_inicio');

            /**
             * Horário final.
             */
            $table->time('hora_fim');

            /**
             * Valor total da reserva.
             */
            $table->decimal('valor_total', 8, 2);

            /**
             * Situação atual.
             */
            $table->enum('status', [
                'pendente',
                'confirmada',
                'concluida',
                'cancelada'
            ])->default('pendente');

            /**
             * Observações.
             */
            $table->text('observacao')
                ->nullable();

            /**
             * Usuário responsável pelo cancelamento.
             */
            $table->foreignId('cancelados_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Data do cancelamento.
             */
            $table->timestamp('cancelada_em')
                ->nullable();

            $table->timestamps();

            /**
             * Índices utilizados nas consultas.
             */
            $table->index([
                'quadras_id',
                'reservas_usuarios_id'
            ]);

            $table->index([
                'data',
                'status'
            ]);

            /**
             * Garante que o horário inicial
             * seja menor que o horário final.
             */
            $table->check('hora_inicio < hora_fim');

            /**
             * Valor nunca pode ser negativo.
             */
            $table->check('valor_total >= 0');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};