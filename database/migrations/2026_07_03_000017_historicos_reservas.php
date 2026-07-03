<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Histórico de alterações das reservas.
     *
     * Esta tabela registra todas as ações realizadas
     * sobre uma reserva, permitindo auditoria completa
     * das alterações feitas pelos usuários.
     */
    public function up(): void
    {
        Schema::create('historicos_reservas', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Reserva relacionada ao histórico.
             */
            $table->foreignId('reservas_id')
                ->constrained('reservas')
                ->cascadeOnDelete();

            /**
             * Usuário responsável pela ação.
             */
            $table->foreignId('usuarios_id')
                ->constrained('usuarios')
                ->restrictOnDelete();

            /**
             * Tipo da ação realizada.
             */
            $table->enum('acao', [
                'criada',
                'alterada',
                'cancelada',
                'mantida',
                'confirmada',
                'reativada',
                'remarcada',
                'estornada'
            ]);

            /**
             * Campo alterado.
             *
             * Exemplo:
             * data
             * hora_inicio
             * hora_fim
             * valor_total
             */
            $table->string('campo_alterado', 50)
                ->nullable();

            /**
             * Valor antes da alteração.
             */
            $table->text('valor_antigo')
                ->nullable();

            /**
             * Valor após a alteração.
             */
            $table->text('valor_novo')
                ->nullable();

            /**
             * Motivo informado pelo usuário.
             */
            $table->text('motivo')
                ->nullable();

            /**
             * IP utilizado durante a operação.
             *
             * Compatível com IPv4 e IPv6.
             */
            $table->string('ip', 45)
                ->nullable();

            $table->timestamps();

            /**
             * Índice utilizado nas consultas
             * do histórico de uma reserva.
             */
            $table->index([
                'reservas_id',
                'usuarios_id'
            ]);

            /**
             * Índice utilizado para filtros
             * por tipo de ação.
             */
            $table->index('acao');
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicos_reservas');
    }
};