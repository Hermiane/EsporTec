<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Notificações enviadas pelo sistema, arenas
     * e administradores aos usuários.
     */
    public function up(): void
    {
        Schema::create('notificacoes', function (Blueprint $table) {

            // Identificador único
            $table->id();

            /**
             * Usuário destinatário da notificação.
             * Pode ser nulo quando enviada para todos.
             */
            $table->foreignId('usuarios_id')
                ->nullable()
                ->constrained('usuarios')
                ->cascadeOnDelete();

            /**
             * Arena relacionada à notificação.
             */
            $table->foreignId('arenas_id')
                ->nullable()
                ->constrained('arenas')
                ->nullOnDelete();

            /**
             * Oferta relacionada.
             */
            $table->foreignId('ofertas_id')
                ->nullable()
                ->constrained('ofertas')
                ->nullOnDelete();

            /**
             * Destinatário da notificação.
             */
            $table->enum('destinatario', [
                'cliente',
                'funcionario',
                'admin',
                'dono_arena',
                'todos_clientes',
                'todos_funcionarios',
                'todos',
            ]);

            /**
             * Tipo da notificação.
             */
            $table->enum('tipo', [
                'aniversario',
                'aviso',
                'oferta',
                'fidelidade',
                'inativo',
                'confirmacao',
                'manual',
                'cancelamento',
                'remarcacao',
                'suporte',
                'sistema',
            ])->default('manual');

            /**
             * Título exibido ao usuário.
             */
            $table->string('titulo', 150);

            /**
             * Conteúdo da mensagem.
             */
            $table->text('mensagem');

            /**
             * Controle de leitura.
             */
            $table->boolean('lida')
                ->default(false);

            /**
             * Usuário responsável pelo envio.
             */
            $table->foreignId('criado_por')
                ->nullable()
                ->constrained('usuarios')
                ->nullOnDelete();

            /**
             * Momento do envio.
             */
            $table->timestamp('enviada_em')
                ->useCurrent();

            $table->timestamps();

            /**
             * Índice utilizado para listar
             * notificações não lidas.
             */
            $table->index([
                'usuarios_id',
                'lida',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
