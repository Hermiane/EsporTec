<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela utilizada para recuperação
     * de senha e alteração de e-mail.
     */
    public function up(): void
    {
        if (Schema::hasTable('resetar_senhas')) {
            return;
        }

        Schema::create('resetar_senhas', function (Blueprint $table) {

            /*
            --------------------------------------------------------------------------
            | Identificação
            |--------------------------------------------------------------------------
            */

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamentos
            |--------------------------------------------------------------------------
            */

            $table->foreignId('usuarios_id')
                ->constrained('usuarios')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Dados da solicitação
            |--------------------------------------------------------------------------
            */

            $table->string('email', 255);

            /**
             * Código enviado ao usuário.
             */
            $table->string('codigo', 10);

            /**
             * Número de tentativas.
             */
            $table->unsignedTinyInteger('tentativa')
                ->default(0);

            /**
             * Código utilizado.
             */
            $table->boolean('usado')
                ->default(false);

            /**
             * Data de expiração.
             */
            $table->timestamp('expira_em');

            /**
             * Tipo da operação.
             */
            $table->enum('tipo', [
                'resetar_senha',
                'alterar_email',
            ]);

            /**
             * IP da solicitação.
             */
            $table->string('ip', 45)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Auditoria
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Índices
            |--------------------------------------------------------------------------
            */

            $table->index(
                [
                    'usuarios_id',
                    'codigo',
                ],
                'idx_resetar_usuarios_codigo'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Constraints
        |--------------------------------------------------------------------------
        */

        DB::statement('
            ALTER TABLE resetar_senhas
            ADD CONSTRAINT chk_tentativas
            CHECK (tentativa BETWEEN 0 AND 5)
        ');
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('resetar_senhas');
    }
};
