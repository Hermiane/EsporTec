<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('arenas', function (Blueprint $table) {
            $table->enum('status_aprovacao', ['pendente', 'aprovada', 'recusada'])
                ->default('aprovada')
                ->after('ativo');
            $table->text('motivo_recusa')->nullable()->after('status_aprovacao');
            $table->timestamp('analisada_em')->nullable()->after('motivo_recusa');
            $table->foreignId('analisada_por')->nullable()->after('analisada_em')
                ->constrained('usuarios')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('arenas', function (Blueprint $table) {
            $table->dropForeign(['analisada_por']);
            $table->dropColumn(['status_aprovacao', 'motivo_recusa', 'analisada_em', 'analisada_por']);
        });
    }
};
