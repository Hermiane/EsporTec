<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\FuncionarioArena;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioArenaFactory extends Factory
{
    protected $model = FuncionarioArena::class;

    public function definition(): array
    {
        return [

            'arenas_id' => Arena::factory(),

            'usuarios_id' => Usuario::factory(),

            'criado_por' => Usuario::factory(),

            'cargo' => $this->faker->randomElement([
                'Recepcionista',
                'Caixa',
                'Zelador',
                'Gerente',
                'Atendente',
            ]),

            'turno' => $this->faker->randomElement([
                'manha',
                'tarde',
                'noite',
                'integral',
            ]),

            'data_entrada' => $this->faker->dateTimeBetween(
                '-5 years',
                'now'
            ),

            'ativo' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    /**
     * Funcionário do turno da manhã.
     */
    public function manha(): static
    {
        return $this->state(fn () => [

            'turno' => 'manha',

        ]);
    }

    /**
     * Funcionário do turno da tarde.
     */
    public function tarde(): static
    {
        return $this->state(fn () => [

            'turno' => 'tarde',

        ]);
    }

    /**
     * Funcionário do turno da noite.
     */
    public function noite(): static
    {
        return $this->state(fn () => [

            'turno' => 'noite',

        ]);
    }

    /**
     * Funcionário em período integral.
     */
    public function integral(): static
    {
        return $this->state(fn () => [

            'turno' => 'integral',

        ]);
    }

    /**
     * Gerente.
     */
    public function gerente(): static
    {
        return $this->state(fn () => [

            'cargo' => 'Gerente',

        ]);
    }

    /**
     * Recepcionista.
     */
    public function recepcionista(): static
    {
        return $this->state(fn () => [

            'cargo' => 'Recepcionista',

        ]);
    }

    /**
     * Funcionário desligado.
     */
    public function inativo(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }
}
