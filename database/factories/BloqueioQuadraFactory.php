<?php

namespace Database\Factories;

use App\Models\BloqueioQuadra;
use App\Models\Quadra;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class BloqueioQuadraFactory extends Factory
{
    protected $model = BloqueioQuadra::class;

    public function definition(): array
    {
        $inicio = $this->faker->numberBetween(6, 18);

        return [

            'quadras_id' => Quadra::factory(),

            'criado_por' => Usuario::factory(),

            'data' => $this->faker->dateTimeBetween(
                '-30 days',
                '+60 days'
            ),

            'hora_inicio' => sprintf('%02d:00:00', $inicio),

            'hora_fim' => sprintf('%02d:00:00', $inicio + 2),

            'motivo' => $this->faker->sentence(),

            'tipo' => $this->faker->randomElement([
                'manutencao',
                'feriado',
                'evento',
                'limpeza',
                'interdicao',
                'outros',
            ]),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function manutencao(): static
    {
        return $this->state(fn () => [

            'tipo' => 'manutencao',

        ]);
    }

    public function limpeza(): static
    {
        return $this->state(fn () => [

            'tipo' => 'limpeza',

        ]);
    }

    public function evento(): static
    {
        return $this->state(fn () => [

            'tipo' => 'evento',

        ]);
    }

    public function feriado(): static
    {
        return $this->state(fn () => [

            'tipo' => 'feriado',

        ]);
    }
}
