<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Cria a tabela de padrões de visitas.
     *
     * Utilizada para identificar os hábitos dos usuários,
     * permitindo recursos como fidelização, ofertas
     * inteligentes e estatísticas.
     */
    public function up(): void
    {
        Schema::create('padroes_visitas', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
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

            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informações do padrão
            |--------------------------------------------------------------------------
            */

            /**
             * 0 = Domingo
             * 1 = Segunda
             * ...
             * 6 = Sábado
             */
            $table->unsignedTinyInteger('dia_semana');

            /**
             * Quantidade de visitas registradas.
             */
            $table->unsignedInteger('frequencia');

            /**
             * Última visita registrada.
             */
            $table->timestamp('ultima_visita');

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

            $table->unique(
                [
                    'usuarios_id',
                    'arenas_id',
                    'dia_semana'
                ],
                'uq_padrao_usuario_dia'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Constraints
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE padroes_visitas
            ADD CONSTRAINT chk_dia_semana
            CHECK (dia_semana BETWEEN 0 AND 6)
        ");

        DB::statement("
            ALTER TABLE padroes_visitas
            ADD CONSTRAINT chk_frequencia
            CHECK (frequencia >= 0)
        ");
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('padroes_visitas');
    }
};