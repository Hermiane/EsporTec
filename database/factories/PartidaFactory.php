<?php

namespace Database\Factories;

use App\Models\Partida;
use App\Models\Reserva;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PartidaFactory extends Factory
{
    protected $model = Partida::class;

    public function definition(): array
    {
        return [

            'reservas_id' => Reserva::factory(),

            'link_partida' => Str::uuid(),

            'max_jogador' => fake()->randomElement([
                10,
                12,
                14,
                16,
                18,
                20,
                22,
            ]),

            'ativo' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function inativa(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }

    public function society(): static
    {
        return $this->state(fn () => [

            'max_jogador' => 14,

        ]);
    }

    public function futebol(): static
    {
        return $this->state(fn () => [

            'max_jogador' => 22,

        ]);
    }
}
