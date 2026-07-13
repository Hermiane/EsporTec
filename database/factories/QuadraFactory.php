<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Quadra;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuadraFactory extends Factory
{
    protected $model = Quadra::class;

    public function definition(): array
    {
        return [

            'arenas_id' => Arena::factory(),

            'nome' => 'Quadra '.$this->faker->unique()->numberBetween(1, 99),

            'tipo' => $this->faker->randomElement([
                'society',
                'futsal',
                'futebol',
                'misto',
            ]),

            'descricao' => $this->faker->paragraph(),

            'foto' => 'quadras/'.$this->faker->uuid().'.jpg',

            'capacidade_jogador' => $this->faker->randomElement([
                10,
                12,
                14,
                18,
                22,
            ]),

            'coberta' => $this->faker->boolean(),

            'preco_hora' => $this->faker->randomFloat(
                2,
                50,
                400
            ),

            'ativo' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function coberta(): static
    {
        return $this->state(fn () => [

            'coberta' => true,

        ]);
    }

    public function descoberta(): static
    {
        return $this->state(fn () => [

            'coberta' => false,

        ]);
    }

    public function inativa(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }

    public function society(): static
    {
        return $this->state(fn () => [

            'tipo' => 'society',

        ]);
    }

    public function futsal(): static
    {
        return $this->state(fn () => [

            'tipo' => 'futsal',

        ]);
    }

    public function futebol(): static
    {
        return $this->state(fn () => [

            'tipo' => 'futebol',

        ]);
    }

    public function mista(): static
    {
        return $this->state(fn () => [

            'tipo' => 'misto',

        ]);
    }
}
