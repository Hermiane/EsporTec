<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Suporte;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuporteFactory extends Factory
{
    protected $model = Suporte::class;

    public function definition(): array
    {
        return [

            'arenas_id' => Arena::factory(),

            'usuarios_id' => Usuario::factory(),

            'titulo' => fake()->sentence(4),

            'descricao' => fake()->paragraph(3),

            'status' => fake()->randomElement([
                'aberto',
                'em_andamento',
                'pendente',
                'resolvido',
                'cancelado',
                'fechado',
            ]),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function aberto(): static
    {
        return $this->state(fn () => [

            'status' => 'aberto',

        ]);
    }

    public function emAndamento(): static
    {
        return $this->state(fn () => [

            'status' => 'em_andamento',

        ]);
    }

    public function pendente(): static
    {
        return $this->state(fn () => [

            'status' => 'pendente',

        ]);
    }

    public function resolvido(): static
    {
        return $this->state(fn () => [

            'status' => 'resolvido',

        ]);
    }

    public function cancelado(): static
    {
        return $this->state(fn () => [

            'status' => 'cancelado',

        ]);
    }

    public function fechado(): static
    {
        return $this->state(fn () => [

            'status' => 'fechado',

        ]);
    }

    public function anonimo(): static
    {
        return $this->state(fn () => [

            'usuarios_id' => null,

        ]);
    }
}
