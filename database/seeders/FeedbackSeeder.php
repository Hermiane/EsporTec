<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Feedback;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $reservas = Reserva::all();

        if ($reservas->isEmpty()) {
            $this->command->warn('Nenhuma reserva encontrada. FeedbackSeeder ignorado.');

            return;
        }

        foreach ($reservas as $reserva) {

            // Um feedback após o pagamento
            Feedback::factory()
                ->posPagamento()
                ->state([
                    'reservas_id'   => $reserva->id,
                    'usuarios_id'   => $reserva->reservas_usuarios_id,
                    'arenas_id'     => $reserva->quadra->arenas_id,
                ])
                ->create();

            // Apenas parte das reservas recebe feedback pós-jogo
            if (fake()->boolean(70)) {

                Feedback::factory()
                    ->posJogo()
                    ->state([
                        'reservas_id'   => $reserva->id,
                        'usuarios_id'   => $reserva->reservas_usuarios_id,
                        'arenas_id'     => $reserva->quadra->arenas_id,
                    ])
                    ->create();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Feedbacks respondidos pela arena
        |--------------------------------------------------------------------------
        */

        $feedbacks = Feedback::whereNull('respondido_por')
            ->inRandomOrder()
            ->take((int) (Feedback::count() * 0.40))
            ->get();

        foreach ($feedbacks as $feedback) {

            $administrador = Usuario::inRandomOrder()->first();

            if ($administrador) {

                $feedback->update([
                    'respondido_por' => $administrador->id,
                    'resposta'       => fake()->paragraph(),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Alguns feedbacks ocultos
        |--------------------------------------------------------------------------
        */

        Feedback::inRandomOrder()
            ->take((int) (Feedback::count() * 0.15))
            ->update([
                'visivel' => false,
            ]);
    }
}