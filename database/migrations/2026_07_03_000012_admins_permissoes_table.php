<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permissões concedidas aos administradores.
     *
     * Um administrador pode possuir várias permissões.
     * Uma permissão pode ser concedida para vários administradores.
     */
    public function up(): void
    {
        Schema::create('admins_permissoes', function (Blueprint $table) {

            // Identificador
            $table->id();

            /**
             * Administrador da arena.
             */
            $table->foreignId('admins_arenas_id')
                ->constrained('admins_arenas')
                ->cascadeOnDelete();

            /**
             * Permissão concedida.
             */
            $table->foreignId('permissoes_id')
                ->constrained('permissoes')
                ->cascadeOnDelete();

            /**
             * Usuário responsável por conceder
             * esta permissão.
             */
            $table->foreignId('concedido_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            $table->timestamps();

            /**
             * Evita permissões duplicadas
             * para o mesmo administrador.
             */
            $table->unique([
                'admins_arenas_id',
                'permissoes_id'
            ]);
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins_permissoes');
    }
};