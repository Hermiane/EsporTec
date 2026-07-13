<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Feedback;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [

            'reservas_id' => Reserva::factory(),

            'usuarios_id' => Usuario::factory(),

            'arenas_id' => Arena::factory(),

            'momento' => fake()->randomElement([
                'pos_pagamentos',
                'pos_jogo',
            ]),

            'nota' => fake()->numberBetween(1, 5),

            'comentario' => fake()->optional(0.8)->paragraph(),

            'visivel' => fake()->boolean(90),

            'respondido_por' => null,

            'resposta' => null,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function excelente(): static
    {
        return $this->state(fn () => [

            'nota' => 5,

            'comentario' => 'Excelente atendimento e estrutura.',

        ]);
    }

    public function ruim(): static
    {
        return $this->state(fn () => [

            'nota' => 1,

            'comentario' => 'Experiência ruim.',

        ]);
    }

    public function invisivel(): static
    {
        return $this->state(fn () => [

            'visivel' => false,

        ]);
    }

    public function respondido(): static
    {
        return $this->state(fn () => [

            'respondido_por' => Usuario::factory(),

            'resposta' => fake()->paragraph(),

        ]);
    }

    public function semComentario(): static
    {
        return $this->state(fn () => [

            'comentario' => null,

        ]);
    }

    public function posJogo(): static
    {
        return $this->state(fn () => [

            'momento' => 'pos_jogo',

        ]);
    }

    public function posPagamento(): static
    {
        return $this->state(fn () => [

            'momento' => 'pos_pagamentos',

        ]);
    }
}
