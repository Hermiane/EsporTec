<?php

namespace Database\Seeders;

use App\Models\JogadorPartida;
use App\Models\Partida;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class JogadorPartidaSeeder extends Seeder
{
    /**
     * Popula os participantes das partidas.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Usuários disponíveis
        |--------------------------------------------------------------------------
        */

        $usuarios = Usuario::all();

        if ($usuarios->isEmpty()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Partidas cadastradas
        |--------------------------------------------------------------------------
        */

        $partidas = Partida::all();

        if ($partidas->isEmpty()) {
            return;
        }

        foreach ($partidas as $partida) {

            /*
            |--------------------------------------------------------------------------
            | Quantidade de jogadores desta partida.
            |
            | Nem toda partida ficará cheia.
            |--------------------------------------------------------------------------
            */

            $quantidade = fake()->numberBetween(
                max(2, intval($partida->max_jogador * 0.4)),
                $partida->max_jogador
            );

            /*
            |--------------------------------------------------------------------------
            | Usuários cadastrados participantes.
            |--------------------------------------------------------------------------
            */

            $usuariosSelecionados = $usuarios
                ->random(min($quantidade, $usuarios->count()));

            foreach ($usuariosSelecionados as $usuario) {

                JogadorPartida::create([

                    'usuarios_id' => $usuario->id,

                    'partidas_id' => $partida->id,

                    'nome_jogador' => $usuario->nome_completo,

                    'contato' => $usuario->telefone,

                    'status' => fake()->randomElement([
                        'confirmado',
                        'confirmado',
                        'confirmado',
                        'pendente',
                        'recusado',
                    ]),

                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Alguns jogadores visitantes.
            |--------------------------------------------------------------------------
            */

            $visitantes = fake()->numberBetween(0, 2);

            $vagasRestantes = $partida->max_jogador
                - $partida->jogadores()->count();

            $visitantes = min($visitantes, $vagasRestantes);

            for ($i = 0; $i < $visitantes; $i++) {

                JogadorPartida::create([

                    'usuarios_id' => null,

                    'partidas_id' => $partida->id,

                    'nome_jogador' => fake()->name(),

                    'contato' => fake()->numerify('###########'),

                    'status' => fake()->randomElement([
                        'pendente',
                        'confirmado',
                    ]),

                ]);
            }
        }
    }
}

