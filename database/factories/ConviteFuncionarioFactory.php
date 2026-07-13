<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\ConviteFuncionario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ConviteFuncionarioFactory extends Factory
{
    /**
     * Model correspondente.
     */
    protected $model = ConviteFuncionario::class;

    /**
     * Define o estado padrão do model.
     */
    public function definition(): array
    {
        return [

            'arenas_id' => Arena::factory(),

            'email' => fake()->unique()->safeEmail(),

            'token' => Str::random(64),

            'cargo' => fake()->randomElement([
                'Recepcionista',
                'Caixa',
                'Zelador',
                'Gerente',
                'Supervisor',
                'Atendente',
            ]),

            'turno' => fake()->randomElement([
                'manha',
                'tarde',
                'noite',
                'integral',
            ]),

            'status' => 'pendente',

            'enviados_por' => Usuario::factory(),

            'aceitados_por' => null,

            'expirado_em' => now()->addDays(7),

        ];
    }

    /**
     * Convite aceito.
     */
    public function aceito(): static
    {
        return $this->state(fn () => [

            'status' => 'aceitado',

            'aceitados_por' => Usuario::factory(),

            'expirado_em' => now()->addDays(7),

        ]);
    }

    /**
     * Convite expirado.
     */
    public function expirado(): static
    {
        return $this->state(fn () => [

            'status' => 'expirado',

            'aceitados_por' => null,

            'expirado_em' => now()->subDay(),

        ]);
    }

    /**
     * Convite cancelado.
     */
    public function cancelado(): static
    {
        return $this->state(fn () => [

            'status' => 'cancelado',

            'aceitados_por' => null,

        ]);
    }

    /**
     * Convite para turno da manhã.
     */
    public function manha(): static
    {
        return $this->state(fn () => [

            'turno' => 'manha',

        ]);
    }

    /**
     * Convite para turno da tarde.
     */
    public function tarde(): static
    {
        return $this->state(fn () => [

            'turno' => 'tarde',

        ]);
    }

    /**
     * Convite para turno da noite.
     */
    public function noite(): static
    {
        return $this->state(fn () => [

            'turno' => 'noite',

        ]);
    }

    /**
     * Convite para período integral.
     */
    public function integral(): static
    {
        return $this->state(fn () => [

            'turno' => 'integral',

        ]);
    }
}
