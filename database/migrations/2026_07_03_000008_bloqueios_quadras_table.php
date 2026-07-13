<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de bloqueios das quadras.
     */
    public function up(): void
    {
        Schema::create('bloqueios_quadras', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamentos
            |--------------------------------------------------------------------------
            */

            $table->foreignId('quadras_id')
                ->constrained('quadras')
                ->cascadeOnDelete();

            $table->foreignId('criado_por')
                ->constrained('usuarios')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informações do bloqueio
            |--------------------------------------------------------------------------
            */

            $table->date('data');

            $table->time('hora_inicio');

            $table->time('hora_fim');

            $table->text('motivo');

            $table->enum('tipo', [
                'manutencao',
                'feriado',
                'evento',
                'limpeza',
                'interdicao',
                'outros',
            ]);

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
                ['quadras_id', 'data'],
                'idx_bloqueio_quadra_data'
            );

            $table->index(
                ['data', 'tipo'],
                'idx_bloqueios_data_tipo'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Constraints (CHECK)
        |--------------------------------------------------------------------------
        */

        DB::statement('
            ALTER TABLE bloqueios_quadras
            ADD CONSTRAINT chk_bloqueios_horarios
            CHECK (hora_inicio < hora_fim)
        ');
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloqueios_quadras');
    }
};
