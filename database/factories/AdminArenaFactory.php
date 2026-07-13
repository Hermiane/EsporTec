<?php

namespace Database\Factories;

use App\Models\AdminArena;
use App\Models\Arena;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminArenaFactory extends Factory
{
    protected $model = AdminArena::class;

    public function definition(): array
    {
        return [

            'arenas_id' => Arena::factory(),

            'usuarios_id' => Usuario::factory(),

            'criado_por' => Usuario::factory(),

            'cargo' => $this->faker->randomElement([
                'Administrador Geral',
                'Financeiro',
                'Operacional',
                'Comercial',
                'Gerente',
            ]),

            'is_dono' => false,

            'ativo' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    /**
     * Proprietário da arena.
     */
    public function dono(): static
    {
        return $this->state(fn () => [

            'is_dono' => true,

            'cargo' => 'Administrador Geral da sua arena',

        ]);
    }

    /**
     * Administrador financeiro.
     */
    public function financeiro(): static
    {
        return $this->state(fn () => [

            'cargo' => 'Financeiro',

        ]);
    }

    /**
     * Administrador operacional.
     */
    public function operacional(): static
    {
        return $this->state(fn () => [

            'cargo' => 'Operacional',

        ]);
    }

    /**
     * Administrador comercial.
     */
    public function comercial(): static
    {
        return $this->state(fn () => [

            'cargo' => 'Comercial',

        ]);
    }

    /**
     * Administrador inativo.
     */
    public function inativo(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }
}
