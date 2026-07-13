<?php

namespace Database\Factories;

use App\Models\HistoricoReserva;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoricoReservaFactory extends Factory
{
    protected $model = HistoricoReserva::class;

    public function definition(): array
    {
        return [

            'reservas_id' => Reserva::factory(),

            'usuarios_id' => Usuario::factory(),

            'acao' => fake()->randomElement([
                'criada',
                'alterada',
                'cancelada',
                'mantida',
                'confirmada',
                'reativada',
                'remarcada',
                'estornada',
            ]),

            'campo_alterado' => fake()->optional()->randomElement([
                'data',
                'hora_inicio',
                'hora_fim',
                'valor_total',
                'status',
                'observacao',
            ]),

            'valor_antigo' => fake()->optional()->word(),

            'valor_novo' => fake()->optional()->word(),

            'motivo' => fake()->optional()->sentence(),

            'ip' => fake()->ipv4(),

        ];
    }

    public function criada(): static
    {
        return $this->state(fn () => [

            'acao' => 'criada',

        ]);
    }

    public function alterada(): static
    {
        return $this->state(fn () => [

            'acao' => 'alterada',

        ]);
    }

    public function cancelada(): static
    {
        return $this->state(fn () => [

            'acao' => 'cancelada',

        ]);
    }

    public function confirmada(): static
    {
        return $this->state(fn () => [

            'acao' => 'confirmada',

        ]);
    }

    public function remarcada(): static
    {
        return $this->state(fn () => [

            'acao' => 'remarcada',

        ]);
    }

    public function estornada(): static
    {
        return $this->state(fn () => [

            'acao' => 'estornada',

        ]);
    }
}
