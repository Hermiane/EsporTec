<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Inclui o status usado quando um comprovante de pagamento é recusado.
     */
    public function up(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->enum('status', ['pendente', 'pago', 'recusado', 'estornado'])
                ->default('pendente')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->enum('status', ['pendente', 'pago', 'estornado'])
                ->default('pendente')
                ->change();
        });
    }
};
