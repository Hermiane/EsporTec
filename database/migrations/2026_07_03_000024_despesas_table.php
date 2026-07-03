<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de despesas.
     */
    public function up(): void
    {
        Schema::create('despesas', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamentos
            |--------------------------------------------------------------------------
            */

            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            $table->foreignId('registrado_por')
                ->constrained('usuarios')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informações da despesa
            |--------------------------------------------------------------------------
            */

            $table->text('descricao');

            $table->enum('categoria', [
                'salario',
                'manutencao',
                'conta',
                'marketing',
                'equipamento',
                'outros'
            ]);

            $table->decimal('valor', 8, 2);

            $table->date('data_despesas');

            /*
            |--------------------------------------------------------------------------
            | Controle financeiro
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('semana_do_mes');

            $table->boolean('recorrente')
                ->default(false);

            $table->enum('recorrencia', [
                'diaria',
                'semanal',
                'mensal',
                'anual'
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | Documentação
            |--------------------------------------------------------------------------
            */

            $table->string('comprovante')
                ->nullable();

            $table->text('observacao');

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
                ['arenas_id', 'data_despesas'],
                'idx_despesas_arenas_data'
            );

            $table->index(
                'categoria',
                'idx_despesas_categoria'
            );

            $table->index(
                ['recorrente', 'recorrencia'],
                'idx_despesas_recorrente'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Constraints (CHECK)
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE despesas
            ADD CONSTRAINT chk_despesas_valor
            CHECK (valor >= 0)
        ");

        DB::statement("
            ALTER TABLE despesas
            ADD CONSTRAINT chk_semana_do_mes
            CHECK (semana_do_mes BETWEEN 1 AND 5)
        ");
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};