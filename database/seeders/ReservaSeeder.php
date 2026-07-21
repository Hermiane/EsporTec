<?php

namespace Database\Seeders;

use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    /**
     * Popula a tabela de reservas.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Usuários clientes
        |--------------------------------------------------------------------------
        */

        $usuarios = Usuario::all();

        /*
        |--------------------------------------------------------------------------
        | Quadras disponíveis
        |--------------------------------------------------------------------------
        */

        $quadras = Quadra::all();

        /*
        |--------------------------------------------------------------------------
        | Validação
        |--------------------------------------------------------------------------
        */

        if ($usuarios->isEmpty() || $quadras->isEmpty()) {

            return;

        }

        /*
        |--------------------------------------------------------------------------
        | Reservas pendentes
        |--------------------------------------------------------------------------
        */

        Reserva::factory()
            ->count(50)
            ->make()
            ->each(function (Reserva $reserva) use ($usuarios, $quadras) {

                $reserva->reservas_usuarios_id = $usuarios->random()->id;

                $reserva->quadras_id = $quadras->random()->id;

                $reserva->save();

            });

        /*
        |--------------------------------------------------------------------------
        | Reservas confirmadas
        |--------------------------------------------------------------------------
        */

        Reserva::factory()
            ->count(35)
            ->confirmada()
            ->make()
            ->each(function (Reserva $reserva) use ($usuarios, $quadras) {

                $cliente = $usuarios->random();

                $reserva->reservas_usuarios_id = $cliente->id;

                $reserva->quadras_id = $quadras->random()->id;

                $reserva->save();

            });

        /*
        |--------------------------------------------------------------------------
        | Reservas concluídas
        |--------------------------------------------------------------------------
        */

        Reserva::factory()
            ->count(20)
            ->concluida()
            ->make()
            ->each(function (Reserva $reserva) use ($usuarios, $quadras) {

                $cliente = $usuarios->random();

                $reserva->reservas_usuarios_id = $cliente->id;

                $reserva->quadras_id = $quadras->random()->id;

                $reserva->save();

            });

        /*
        |--------------------------------------------------------------------------
        | Reservas canceladas
        |--------------------------------------------------------------------------
        */

        Reserva::factory()
            ->count(12)
            ->cancelada()
            ->make()
            ->each(function (Reserva $reserva) use ($usuarios, $quadras) {

                $cliente = $usuarios->random();

                $cancelador = $usuarios->random();

                $reserva->reservas_usuarios_id = $cliente->id;

                $reserva->quadras_id = $quadras->random()->id;

                $reserva->cancelados_por = $cancelador->id;

                $reserva->save();

            });

        /*
        |--------------------------------------------------------------------------
        | Reservas alteradas
        |--------------------------------------------------------------------------
        */

        Reserva::factory()
            ->count(15)
            ->alterada()
            ->make()
            ->each(function (Reserva $reserva) use ($usuarios, $quadras) {

                $cliente = $usuarios->random();

                $alterador = $usuarios->random();

                $reserva->reservas_usuarios_id = $cliente->id;

                $reserva->quadras_id = $quadras->random()->id;

                $reserva->alteradas_por = $alterador->id;

                $reserva->save();

            });

    }
}