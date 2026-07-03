<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Super administradores do sistema.
     *
     * Um usuário pode ou não ser um Super Admin.
     */
    public function up(): void
    {
        Schema::create('super_admins', function (Blueprint $table) {

            $table->id();

            // Usuário associado
            $table->foreignId('usuarios_id')
                  ->unique()
                  ->constrained('usuarios')
                  ->restrictOnDelete();

            // Cargo exercido
            $table->string('cargo',50);

            // Motivo da promoção
            $table->string('motivo')
                  ->nullable();

            // Último acesso ao painel
            $table->timestamp('ultimo_acesso')
                  ->nullable();

            // Quem criou este administrador
            $table->foreignId('criado_por')
                  ->nullable()
                  ->constrained('usuarios')
                  ->nullOnDelete();

            // Controle lógico
            $table->boolean('ativo')
                  ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('super_admins');
    }
};