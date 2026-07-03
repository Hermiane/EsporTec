<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de quadras.
     */
    public function up(): void
    {
        Schema::create('quadras', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamento
            |--------------------------------------------------------------------------
            */

            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informações da quadra
            |--------------------------------------------------------------------------
            */

            $table->string('nome', 50);

            $table->enum('tipo', [
                'society',
                'futsal',
                'futebol',
                'misto'
            ])->default('society');

            $table->text('descricao');

            $table->string('foto', 255);

            $table->unsignedInteger('capacidade_jogador');

            $table->boolean('coberta')
                ->default(false);

            $table->decimal('preco_hora', 8, 2);

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
                ['arenas_id', 'nome'],
                'idx_quadras_arenas_nome'
            );

            $table->index(
                ['ativo', 'tipo'],
                'idx_quadras_ativo_tipo'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Constraints (CHECK)
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE quadras
            ADD CONSTRAINT chk_quadras_capacidade
            CHECK (capacidade_jogador > 0)
        ");

        DB::statement("
            ALTER TABLE quadras
            ADD CONSTRAINT chk_quadras_preco
            CHECK (preco_hora >= 0)
        ");
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('quadras');
    }
};