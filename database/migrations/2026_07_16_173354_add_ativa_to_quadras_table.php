<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // A coluna já faz parte da migration de criação de quadras.
        // Mantemos esta migration como no-op para bancos que a registraram depois.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não remover: a coluna pertence à migration original da tabela.
    }
};
