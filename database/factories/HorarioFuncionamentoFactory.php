<?php

namespace Database\Factories;

use App\Models\HorarioFuncionamento;
use App\Models\Quadra;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioFuncionamentoFactory extends Factory
{
    protected $model = HorarioFuncionamento::class;

    public function definition(): array
    {
        $inicio = $this->faker->numberBetween(6, 18);

        return [

            'quadras_id' => Quadra::factory(),

            'dia_semana' => $this->faker->randomElement([
                'segunda-feira',
                'terca-feira',
                'quarta-feira',
                'quinta-feira',
                'sexta-feira',
                'sabado',
                'domingo',
            ]),

            'hora_inicio' => sprintf('%02d:00:00', $inicio),

            'hora_fim' => sprintf('%02d:00:00', $inicio + 4),

            'ativo' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function inativo(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }

    public function fimDeSemana(): static
    {
        return $this->state(fn () => [

            'dia_semana' => $this->faker->randomElement([
                'sabado',
                'domingo',
            ]),

        ]);
    }
}
