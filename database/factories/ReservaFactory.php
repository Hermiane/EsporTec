<?php

namespace Database\Factories;

use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition(): array
    {
        $horaInicio = fake()->randomElement([
            '08:00:00',
            '09:00:00',
            '10:00:00',
            '14:00:00',
            '15:00:00',
            '16:00:00',
            '18:00:00',
            '19:00:00',
            '20:00:00',
        ]);

        $horaFim = date(
            'H:i:s',
            strtotime($horaInicio.' +1 hour')
        );

        return [

            'reservas_usuarios_id' => Usuario::factory(),

            'quadras_id' => Quadra::factory(),

            'alteradas_por' => null,

            'data' => fake()->dateTimeBetween('+1 day', '+3 months'),

            'hora_inicio' => $horaInicio,

            'hora_fim' => $horaFim,

            'valor_total' => fake()->randomFloat(
                2,
                50,
                400
            ),

            'status' => 'pendente',

            'observacao' => fake()->optional()->sentence(),

            'cancelados_por' => null,

            'cancelada_em' => null,
        ];
    }

    public function confirmada(): static
    {
        return $this->state(fn () => [

            'status' => 'confirmada',

        ]);
    }

    public function concluida(): static
    {
        return $this->state(fn () => [

            'status' => 'concluida',

        ]);
    }

    public function cancelada(): static
    {
        return $this->state(fn () => [

            'status' => 'cancelada',

            'cancelados_por' => Usuario::factory(),

            'cancelada_em' => now(),

        ]);
    }

    public function alterada(): static
    {
        return $this->state(fn () => [

            'alteradas_por' => Usuario::factory(),

        ]);
    }
}
