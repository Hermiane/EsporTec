<?php

namespace Database\Seeders;

use App\Models\HorarioFuncionamento;
use App\Models\Quadra;
use Illuminate\Database\Seeder;

class HorarioFuncionamentoSeeder extends Seeder
{
    /**
     * Popula os horários de funcionamento das quadras.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Dias da semana
        |--------------------------------------------------------------------------
        */

        $dias = [

            'segunda-feira',
            'terca-feira',
            'quarta-feira',
            'quinta-feira',
            'sexta-feira',
            'sabado',
            'domingo',

        ];

        /*
        |--------------------------------------------------------------------------
        | Cada quadra recebe horário para todos os dias.
        |--------------------------------------------------------------------------
        */

        Quadra::all()->each(function (Quadra $quadra) use ($dias) {

            foreach ($dias as $dia) {

                HorarioFuncionamento::factory()->create([

                    'quadras_id' => $quadra->id,

                    'dia_semana' => $dia,

                    'hora_inicio' => '08:00:00',

                    'hora_fim' => '22:00:00',

                    'ativo' => true,

                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Alguns horários ficam indisponíveis.
        |--------------------------------------------------------------------------
        */

        HorarioFuncionamento::inRandomOrder()
            ->limit(10)
            ->get()
            ->each(function (HorarioFuncionamento $horario) {

                $horario->update([

                    'ativo' => false,

                ]);
            });
    }
}