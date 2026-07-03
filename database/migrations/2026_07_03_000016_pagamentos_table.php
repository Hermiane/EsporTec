<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pagamentos das reservas.
     *
     * Cada reserva possui um pagamento.
     * O pagamento pode ser confirmado
     * manualmente por um administrador.
     */
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {

            // Identificador
            $table->id();

            /**
             * Reserva relacionada.
             */
            $table->foreignId('reservas_id')
                ->constrained('reservas')
                ->cascadeOnDelete();

            /**
             * Método de pagamento.
             */
            $table->enum('metodo', [
                'dinheiro',
                'pix',
                'cartao_credito',
                'cartao_debito'
            ]);

            /**
             * Situação do pagamento.
             */
            $table->enum('status', [
                'pendente',
                'pago',
                'estornado'
            ])->default('pendente');

            /**
             * Valor pago.
             */
            $table->decimal('valor', 8, 2);

            /**
             * Código PIX Copia e Cola.
             */
            $table->string('pix_copia_cola')
                ->nullable();

            /**
             * Foto do comprovante enviada pelo cliente.
             */
            $table->string('comprovante')
                ->nullable();

            /**
             * Data do pagamento.
             */
            $table->timestamp('pago_em')
                ->nullable();

            /**
             * Administrador ou funcionário
             * que confirmou o pagamento.
             */
            $table->foreignId('confirmados_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            $table->timestamps();

            /**
             * Índices.
             */
            $table->index([
                'reservas_id',
                'status'
            ]);

            $table->index('status');

            $table->index('metodo');

            /**
             * Valor nunca pode ser negativo.
             */
            $table->check('valor >= 0');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};