<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\PadraoVisita;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class PadraoVisitaSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $arenas = Arena::all();

        if (
            $usuarios->isEmpty() ||
            $arenas->isEmpty()
        ) {
            return;
        }

        foreach ($usuarios as $usuario) {

            /*
             * Cada usuário frequenta entre
             * uma e três arenas.
             */
            $arenasUsuario = $arenas->random(
                min(
                    fake()->numberBetween(1, 3),
                    $arenas->count()
                )
            );

            foreach ($arenasUsuario as $arena) {

                /*
                 * Dias realmente frequentados
                 * pelo usuário.
                 */
                $diasSemana = collect(range(0, 6))
                    ->shuffle()
                    ->take(fake()->numberBetween(1, 4));

                foreach ($diasSemana as $diaSemana) {

                    PadraoVisita::create([

                        'usuarios_id' => $usuario->id,

                        'arenas_id' => $arena->id,

                        'dia_semana' => $diaSemana,

                        /*
                         * Número de visitas
                         * registradas.
                         */
                        'frequencia' => fake()->numberBetween(
                            1,
                            80
                        ),

                        /*
                         * Última visita recente.
                         */
                        'ultima_visita' => fake()->dateTimeBetween(
                            '-6 months',
                            'now'
                        ),

                        'created_at' => now(),

                        'updated_at' => now(),

                    ]);
                }
            }
        }
    }
}