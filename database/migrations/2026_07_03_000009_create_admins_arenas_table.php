<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Administradores das arenas.
     *
     * Cada arena pode possuir um ou mais administradores.
     * Um administrador pode administrar várias arenas.
     * Apenas um vínculo entre usuário e arena é permitido.
     */
    public function up(): void
    {
        Schema::create('admins_arenas', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Arena administrada.
             */
            $table->foreignId('arenas_id')
                ->constrained('arenas')
                ->cascadeOnDelete();

            /**
             * Usuário administrador.
             */
            $table->foreignId('usuarios_id')
                ->constrained('usuarios')
                ->restrictOnDelete();

            /**
             * Quem cadastrou este administrador.
             * Pode ser um Super Admin ou outro administrador.
             */
            $table->foreignId('criado_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Cargo exercido.
             *
             * Ex:
             * Administrador Geral
             * Financeiro
             * Operacional
             */
            $table->string('cargo', 50);

            /**
             * Define se este administrador é o proprietário
             * oficial da arena.
             */
            $table->boolean('is_dono')
                ->default(false);

            /**
             * Controle lógico.
             */
            $table->boolean('ativo')
                ->default(true);

            $table->timestamps();

            /**
             * Um usuário não pode ser administrador
             * duas vezes da mesma arena.
             */
            $table->unique([
                'arenas_id',
                'usuarios_id',
            ]);
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins_arenas');
    }
};
