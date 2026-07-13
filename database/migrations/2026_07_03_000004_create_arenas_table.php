<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de arenas.
     */
    public function up(): void
    {
        Schema::create('arenas', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relacionamentos
            |--------------------------------------------------------------------------
            */

            $table->foreignId('criado_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Dados da Arena
            |--------------------------------------------------------------------------
            */

            $table->string('nome', 50);

            $table->string('cnpj', 18)
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Endereço
            |--------------------------------------------------------------------------
            */

            $table->string('logradouro', 60);

            $table->string('bairro', 20);

            $table->string('numero', 10)
                ->nullable();

            $table->string('ponto_referencia', 100)
                ->nullable();

            $table->string('cidade', 32);

            $table->string('estado', 2);

            /*
            |--------------------------------------------------------------------------
            | Contato
            |--------------------------------------------------------------------------
            */

            $table->string('telefone', 11);

            $table->string('email', 50)
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Informações da Arena
            |--------------------------------------------------------------------------
            */

            $table->string('foto_capa')
                ->nullable();

            $table->text('descricao');

            /*
            |--------------------------------------------------------------------------
            | PIX
            |--------------------------------------------------------------------------
            */

            $table->enum('pix_tipo', [
                'cpf',
                'cnpj',
                'email',
                'telefone',
                'aleatoria',
            ]);

            $table->string('pix_chave');

            /*
            |--------------------------------------------------------------------------
            | Controle
            |--------------------------------------------------------------------------
            */

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
                ['cidade', 'estado'],
                'idx_arenas_cidade_estado'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Constraints (CHECK)
        |--------------------------------------------------------------------------
        */

        DB::statement('
            ALTER TABLE arenas
            ADD CONSTRAINT chk_arenas_ativo
            CHECK (ativo IN (0,1))
        ');
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('arenas');
    }
};
