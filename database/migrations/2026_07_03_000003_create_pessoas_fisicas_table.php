<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cadastro de CPF.
     *
     * Nem todo usuário obrigatoriamente precisa possuir CPF
     * cadastrado imediatamente, porém quando existir será único.
     */
    public function up(): void
    {
        Schema::create('pessoas_fisicas', function (Blueprint $table) {

            $table->id();

            // Usuário proprietário do CPF
            $table->foreignId('usuarios_id')
                  ->unique()
                  ->constrained('usuarios')
                  ->restrictOnDelete();

            // CPF sem máscara
            $table->string('CPF',11)
                  ->unique();

            // Indica se o CPF foi validado
            $table->boolean('cpf_verificado')
                  ->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoas_fisicas');
    }
};