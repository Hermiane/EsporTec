<?php

namespace Database\Factories;

use App\Models\JogadorPartida;
use App\Models\Partida;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class JogadorPartidaFactory extends Factory
{
    protected $model = JogadorPartida::class;

    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'partidas_id' => Partida::factory(),

            'nome_jogador' => fake()->name(),

            'contato' => fake()->numerify('###########'),

            'status' => fake()->randomElement([
                'pendente',
                'confirmado',
                'recusado',
            ]),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function confirmado(): static
    {
        return $this->state(fn () => [

            'status' => 'confirmado',

        ]);
    }

    public function pendente(): static
    {
        return $this->state(fn () => [

            'status' => 'pendente',

        ]);
    }

    public function recusado(): static
    {
        return $this->state(fn () => [

            'status' => 'recusado',

        ]);
    }

    /**
     * Jogador sem cadastro.
     */
    public function visitante(): static
    {
        return $this->state(fn () => [

            'usuarios_id' => null,

        ]);
    }

    /**
     * Sem telefone.
     */
    public function semContato(): static
    {
        return $this->state(fn () => [

            'contato' => null,

        ]);
    }
}
