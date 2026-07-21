<?php

namespace Database\Seeders;

use App\Models\Partida;
use App\Models\Quadra;
use App\Models\Reserva;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartidaSeeder extends Seeder
{
    /**
     * Popula a tabela de partidas.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Reservas elegíveis
        |--------------------------------------------------------------------------
        |
        | Apenas reservas confirmadas ou concluídas
        | podem originar partidas.
        |
        */

        $reservas = Reserva::query()
            ->whereIn('status', [
                'confirmada',
                'concluida',
            ])
            ->doesntHave('partida')
            ->with('quadra')
            ->get();

        if ($reservas->isEmpty()) {

            return;

        }

        /*
        |--------------------------------------------------------------------------
        | Criação das partidas
        |--------------------------------------------------------------------------
        */

        foreach ($reservas as $reserva) {

            /*
            |--------------------------------------------------------------------------
            | Nem toda reserva gera uma partida pública.
            |--------------------------------------------------------------------------
            */

            if (! fake()->boolean(55)) {

                continue;

            }

            /*
            |--------------------------------------------------------------------------
            | Capacidade baseada na quadra.
            |--------------------------------------------------------------------------
            */

            $capacidade = $reserva->quadra?->capacidade_jogador ?? 22;

            Partida::create([

                'reservas_id' => $reserva->id,

                'link_partida' => Str::uuid(),

                'max_jogador' => $capacidade,

                'ativo' => fake()->boolean(90),

            ]);

        }
    }
}
