<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Notificacao;
use App\Models\Oferta;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class NotificacaoSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $arenas = Arena::all();
        $ofertas = Oferta::all();

        if (
            $usuarios->isEmpty() ||
            $arenas->isEmpty()
        ) {
            return;
        }

        /**
         * Notificações individuais.
         */
        foreach ($usuarios->random(min(20, $usuarios->count())) as $usuario) {

            $tipo = fake()->randomElement([
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
            ]);

            Notificacao::create([

                'usuarios_id' => $usuario->id,

                'arenas_id' => $arenas->random()->id,

                'ofertas_id' => $tipo === 'oferta' && $ofertas->isNotEmpty()
                    ? $ofertas->random()->id
                    : null,

                'destinatario' => 'cliente',

                'tipo' => $tipo,

                'titulo' => fake()->sentence(4),

                'mensagem' => fake()->paragraph(),

                'lida' => fake()->boolean(35),

                'criado_por' => $usuarios->random()->id,

                'enviada_em' => fake()->dateTimeBetween('-30 days', 'now'),

                'created_at' => now(),

                'updated_at' => now(),

            ]);
        }

        /**
         * Notificações para todos os clientes.
         */
        Notificacao::create([

            'usuarios_id' => null,

            'arenas_id' => $arenas->random()->id,

            'ofertas_id' => null,

            'destinatario' => 'todos_clientes',

            'tipo' => 'manual',

            'titulo' => 'Comunicado Geral',

            'mensagem' => 'Confira nossos novos horários de funcionamento.',

            'lida' => false,

            'criado_por' => $usuarios->random()->id,

            'enviada_em' => now()->subDays(3),

            'created_at' => now(),

            'updated_at' => now(),

        ]);

        /**
         * Notificação promocional.
         */
        if ($ofertas->isNotEmpty()) {

            Notificacao::create([

                'usuarios_id' => null,

                'arenas_id' => $arenas->random()->id,

                'ofertas_id' => $ofertas->random()->id,

                'destinatario' => 'todos',

                'tipo' => 'oferta',

                'titulo' => 'Nova promoção disponível',

                'mensagem' => 'Aproveite nossa oferta especial por tempo limitado.',

                'lida' => false,

                'criado_por' => $usuarios->random()->id,

                'enviada_em' => now()->subDay(),

                'created_at' => now(),

                'updated_at' => now(),

            ]);
        }

        /**
         * Notificação do sistema.
         */
        Notificacao::create([

            'usuarios_id' => null,

            'arenas_id' => null,

            'ofertas_id' => null,

            'destinatario' => 'todos',

            'tipo' => 'sistema',

            'titulo' => 'Atualização do sistema',

            'mensagem' => 'O sistema passou por melhorias de desempenho.',

            'lida' => false,

            'criado_por' => null,

            'enviada_em' => now(),

            'created_at' => now(),

            'updated_at' => now(),

        ]);
    }
}