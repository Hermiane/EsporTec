<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de usuários.
     *
     * Esta tabela representa todas as pessoas cadastradas
     * no sistema (clientes, funcionários, administradores
     * e super administradores).
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {

            // Identificador único
            $table->id();

            // Dados pessoais
            $table->string('nome_completo',100);

            // Nome utilizado para login
            $table->string('nome_usuario',50)->unique();

            // Email principal
            $table->string('email')->unique();

            // Senha criptografada
            $table->string('senha_hash');

            // Apenas números
            $table->string('telefone',11);

            // Data de nascimento
            $table->date('data_nascimento');

            // Foto do perfil
            $table->string('foto_perfil')->nullable();

            // Preferência para receber campanhas
            $table->boolean('email_marketing')
                  ->default(false);

            // Controle de ativação da conta
            $table->boolean('ativo')
                  ->default(true);

            // Token "Lembrar-me"
            $table->string('relembrar_token',64)
                  ->nullable()
                  ->unique();

            // Momento em que o e-mail foi confirmado
            $table->timestamp('email_verificacao')
                  ->nullable();

            // Quantidade de tentativas consecutivas
            $table->unsignedTinyInteger('login_tentativa')
                  ->default(0);

            // Bloqueio temporário da conta
            $table->timestamp('login_bloqueado_ate')
                  ->nullable();

            // created_at e updated_at
            $table->timestamps();
        });
    }

    /**
     * Remove a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};