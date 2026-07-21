<?php

namespace Database\Seeders;

use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class PagamentoSeeder extends Seeder
{
    /**
     * Popula a tabela de pagamentos.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Reservas existentes
        |--------------------------------------------------------------------------
        */

        $reservas = Reserva::all();

        /*
        |--------------------------------------------------------------------------
        | Usuários do sistema
        |--------------------------------------------------------------------------
        */

        $usuarios = Usuario::all();

        if ($reservas->isEmpty()) {

            return;

        }

        /*
        |--------------------------------------------------------------------------
        | Um pagamento para cada reserva
        |--------------------------------------------------------------------------
        */

        foreach ($reservas as $reserva) {

            $factory = Pagamento::factory();

            /*
            |--------------------------------------------------------------------------
            | Pagamentos pagos
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $reserva->status,
                    ['confirmada', 'concluida']
                )
            ) {

                $factory = $factory->pago();

            }

            /*
            |--------------------------------------------------------------------------
            | Pagamentos PIX
            |--------------------------------------------------------------------------
            */

            if (fake()->boolean(35)) {

                $factory = $factory->pix();

            }

            /*
            |--------------------------------------------------------------------------
            | Pagamentos estornados
            |--------------------------------------------------------------------------
            */

            if (
                $reserva->status === 'cancelada'
                && fake()->boolean(25)
            ) {

                $factory = $factory->estornado();

            }

            $pagamento = $factory->make();

            /*
            |--------------------------------------------------------------------------
            | Relacionamentos
            |--------------------------------------------------------------------------
            */

            $pagamento->reservas_id = $reserva->id;

            /*
            |--------------------------------------------------------------------------
            | Valor sempre igual ao da reserva
            |--------------------------------------------------------------------------
            */

            $pagamento->valor = $reserva->valor_total;

            /*
            |--------------------------------------------------------------------------
            | Usuário que confirmou
            |--------------------------------------------------------------------------
            */

            if ($pagamento->status === 'pago') {

                $pagamento->confirmados_por = $usuarios->random()->id;

            } else {

                $pagamento->confirmados_por = null;

                $pagamento->pago_em = null;

            }

            $pagamento->save();
        }
    }
}