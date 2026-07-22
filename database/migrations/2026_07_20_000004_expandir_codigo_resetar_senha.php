<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { 
        //  Mudei de 255 para 191 para evitar erro de índice no MySQL
        Schema::table('resetar_senhas', fn (Blueprint $table) => $table->string('codigo', 191)->change()); 
    }
    
    public function down(): void { 
        // Mantém 10 no rollback (já estava correto)
        Schema::table('resetar_senhas', fn (Blueprint $table) => $table->string('codigo', 10)->change()); 
    }
};