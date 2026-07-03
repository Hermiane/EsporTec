<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convites enviados para novos funcionários.
     *
     * O administrador envia um convite para um e-mail.
     * Após aceitar, o usuário passa a integrar a arena.
     */
    public function up(): void
    {
        Schema::create('convites_funcionarios', function (Blueprint $table) {

            // Identificador
            $table->id();

            /**
             * Arena responsável pelo convite.
             */
            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /**
             * E-mail que receberá o convite.
             */
            $table->string('email');

            /**
             * Token único utilizado para validar
             * o convite.
             */
            $table->string('token', 64)
                ->unique();

            /**
             * Cargo que o funcionário exercerá.
             */
            $table->string('cargo', 50);

            /**
             * Turno de trabalho.
             */
            $table->enum('turno', [
                'manha',
                'tarde',
                'noite',
                'integral'
            ])->nullable();

            /**
             * Situação do convite.
             */
            $table->enum('status', [
                'pendente',
                'aceitado',
                'expirado',
                'cancelado'
            ])->default('pendente');

            /**
             * Administrador que enviou o convite.
             */
            $table->foreignId('enviados_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Usuário que aceitou o convite.
             */
            $table->foreignId('aceitados_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Data de expiração do convite.
             */
            $table->timestamp('expirado_em');

            $table->timestamps();

            /**
             * Índice utilizado nas pesquisas
             * por convites.
             */
            $table->index([
                'status',
                'email'
            ]);
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('convites_funcionarios');
    }
};