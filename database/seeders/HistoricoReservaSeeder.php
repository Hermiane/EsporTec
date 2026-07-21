<?php

namespace Database\Seeders;

use App\Models\HistoricoReserva;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class HistoricoReservaSeeder extends Seeder
{
    /**
     * Popula a tabela de históricos das reservas.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Dados existentes
        |--------------------------------------------------------------------------
        */

        $reservas = Reserva::all();

        $usuarios = Usuario::all();

        if ($reservas->isEmpty() || $usuarios->isEmpty()) {

            return;

        }

        /*
        |--------------------------------------------------------------------------
        | Histórico de cada reserva
        |--------------------------------------------------------------------------
        */

        foreach ($reservas as $reserva) {

            /*
            |--------------------------------------------------------------------------
            | Toda reserva nasce criada
            |--------------------------------------------------------------------------
            */

            HistoricoReserva::factory()
                ->criada()
                ->make([
                    'reservas_id' => $reserva->id,
                    'usuarios_id' => $reserva->reservas_usuarios_id,
                ])
                ->save();

            /*
            |--------------------------------------------------------------------------
            | Reserva confirmada
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $reserva->status,
                    ['confirmada', 'concluida']
                )
            ) {

                HistoricoReserva::factory()
                    ->confirmada()
                    ->make([
                        'reservas_id' => $reserva->id,
                        'usuarios_id' => $usuarios->random()->id,
                        'campo_alterado' => 'status',
                        'valor_antigo' => 'pendente',
                        'valor_novo' => 'confirmada',
                    ])
                    ->save();

            }

            /*
            |--------------------------------------------------------------------------
            | Reserva alterada
            |--------------------------------------------------------------------------
            */

            if ($reserva->alteradas_por !== null) {

                HistoricoReserva::factory()
                    ->alterada()
                    ->make([
                        'reservas_id' => $reserva->id,
                        'usuarios_id' => $reserva->alteradas_por,
                        'campo_alterado' => fake()->randomElement([
                            'data',
                            'hora_inicio',
                            'hora_fim',
                            'observacao',
                        ]),
                        'valor_antigo' => fake()->word(),
                        'valor_novo' => fake()->word(),
                    ])
                    ->save();

            }

            /*
            |--------------------------------------------------------------------------
            | Reserva cancelada
            |--------------------------------------------------------------------------
            */

            if ($reserva->status === 'cancelada') {

                HistoricoReserva::factory()
                    ->cancelada()
                    ->make([
                        'reservas_id' => $reserva->id,
                        'usuarios_id' => $reserva->cancelados_por,
                        'campo_alterado' => 'status',
                        'valor_antigo' => 'confirmada',
                        'valor_novo' => 'cancelada',
                        'motivo' => fake()->sentence(),
                    ])
                    ->save();

            }

            /*
            |--------------------------------------------------------------------------
            | Algumas reservas sofreram remarcação
            |--------------------------------------------------------------------------
            */

            if (fake()->boolean(15)) {

                HistoricoReserva::factory()
                    ->remarcada()
                    ->make([
                        'reservas_id' => $reserva->id,
                        'usuarios_id' => $usuarios->random()->id,
                        'campo_alterado' => 'data',
                        'valor_antigo' => now()->subDays(3)->toDateString(),
                        'valor_novo' => now()->addDays(5)->toDateString(),
                    ])
                    ->save();

            }

            /*
            |--------------------------------------------------------------------------
            | Algumas reservas apenas permaneceram sem alterações
            |--------------------------------------------------------------------------
            */

            if (fake()->boolean(20)) {

                HistoricoReserva::factory()
                    ->make([
                        'reservas_id' => $reserva->id,
                        'usuarios_id' => $usuarios->random()->id,
                        'acao' => 'mantida',
                    ])
                    ->save();

            }

        }
    }
}
