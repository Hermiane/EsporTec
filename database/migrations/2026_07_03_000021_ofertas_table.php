<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ofertas cadastradas pelas arenas.
     */
    public function up(): void
    {
        Schema::create('ofertas', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Arena proprietária da oferta.
             */
            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /**
             * Nome da oferta.
             */
            $table->string('titulo',150);

            /**
             * Descrição detalhada.
             */
            $table->text('descricao');

            /**
             * Percentual de desconto.
             */
            $table->decimal('desconto_percent',8,2);

            /**
             * Data limite para utilização.
             */
            $table->timestamp('valida_ate');

            /**
             * Tipo da oferta.
             */
            $table->enum('tipo',[
                'aniversario',
                'fidelidade',
                'manual'
            ]);

            /**
             * Público alvo.
             */
            $table->enum('publico_alvo',[
                'todos',
                'fiel',
                'vip',
                'inativo',
                'individual'
            ])->default('individual');

            /**
             * Oferta ativa.
             */
            $table->boolean('ativo')
                ->default(true);

            /**
             * Usuário que criou.
             */
            $table->foreignId('criado_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            $table->timestamps();

            /**
             * Índice para buscas por arena.
             */
            $table->index([
                'arenas_id',
                'tipo'
            ]);

            /**
             * Índice utilizado para
             * ofertas válidas.
             */
            $table->index([
                'ativo',
                'valida_ate'
            ]);
            
        });
        /**
         * Percentual permitido.
         */
        DB::statement("ALTER TABLE ofertas ADD CONSTRAINT chk_ofertas_desconto_percent CHECK (desconto_percent BETWEEN 0 AND 100)");
    }

    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};