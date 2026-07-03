<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de horários de funcionamento.
     */
    public function up(): void
    {
        Schema::create('horarios_funcionamento', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamento
            |--------------------------------------------------------------------------
            */

            $table->foreignId('quadras_id')
                ->constrained('quadras')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Horário de funcionamento
            |--------------------------------------------------------------------------
            */

            $table->enum('dia_semana', [
                'segunda-feira',
                'terca-feira',
                'quarta-feira',
                'quinta-feira',
                'sexta-feira',
                'sabado',
                'domingo'
            ]);

            $table->time('hora_inicio');

            $table->time('hora_fim');

            $table->boolean('ativo')
                ->default(true);

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
                ['quadras_id', 'dia_semana'],
                'idx_horarios_quadra_dia'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Constraints (CHECK)
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE horarios_funcionamento
            ADD CONSTRAINT chk_horarios_validos
            CHECK (hora_inicio < hora_fim)
        ");
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_funcionamento');
    }
};