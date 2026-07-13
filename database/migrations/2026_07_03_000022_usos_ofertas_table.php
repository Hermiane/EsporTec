<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Histórico de utilização das ofertas pelos usuários.
     */
    public function up(): void
    {
        Schema::create('usos_ofertas', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Usuário que recebeu/utilizou a oferta.
             */
            $table->foreignId('usuarios_id')
                ->constrained('usuarios')
                ->cascadeOnDelete();

            /**
             * Oferta utilizada.
             */
            $table->foreignId('ofertas_id')
                ->constrained('ofertas')
                ->cascadeOnDelete();

            /**
             * Reserva onde a oferta foi aplicada.
             */
            $table->foreignId('reservas_id')
                ->constrained('reservas')
                ->cascadeOnDelete();

            /**
             * Data em que a oferta foi enviada.
             */
            $table->timestamp('enviada_em')
                ->useCurrent();

            /**
             * Indica se a oferta foi utilizada.
             */
            $table->boolean('utilizada')
                ->default(false);

            /**
             * Data em que a oferta foi utilizada.
             */
            $table->timestamp('utilizada_em')
                ->nullable();

            $table->timestamps();

            /**
             * Índice utilizado nas consultas de histórico
             * de ofertas dos usuários.
             */
            $table->index([
                'usuarios_id',
                'ofertas_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usos_ofertas');
    }
};
