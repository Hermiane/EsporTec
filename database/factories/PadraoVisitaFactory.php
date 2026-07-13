<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\PadraoVisita;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class PadraoVisitaFactory extends Factory
{
    protected $model = PadraoVisita::class;

    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'arenas_id' => Arena::factory(),

            'dia_semana' => fake()->numberBetween(0, 6),

            'frequencia' => fake()->numberBetween(0, 80),

            'ultima_visita' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    /**
     * Usuário frequente.
     */
    public function frequente(): static
    {
        return $this->state(fn () => [

            'frequencia' => fake()->numberBetween(20, 100),

        ]);
    }

    /**
     * Primeira visita.
     */
    public function primeiraVisita(): static
    {
        return $this->state(fn () => [

            'frequencia' => 1,

        ]);
    }

    /**
     * Última visita recente.
     */
    public function visitaRecente(): static
    {
        return $this->state(fn () => [

            'ultima_visita' => now()->subDays(fake()->numberBetween(0, 7)),

        ]);
    }

    /**
     * Usuário inativo.
     */
    public function inativo(): static
    {
        return $this->state(fn () => [

            'ultima_visita' => now()->subMonths(fake()->numberBetween(3, 12)),

        ]);
    }

    /**
     * Visitas de final de semana.
     */
    public function finalSemana(): static
    {
        return $this->state(fn () => [

            'dia_semana' => fake()->randomElement([
                0,
                6,
            ]),

        ]);
    }

    /**
     * Visitas durante a semana.
     */
    public function diasUteis(): static
    {
        return $this->state(fn () => [

            'dia_semana' => fake()->numberBetween(1, 5),

        ]);
    }
}
