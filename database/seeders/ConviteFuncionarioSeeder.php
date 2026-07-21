<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\ConviteFuncionario;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ConviteFuncionarioSeeder extends Seeder
{
    /**
     * Popula os convites enviados pelas arenas.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();

        Arena::all()->each(function (Arena $arena) use ($usuarios) {

            ConviteFuncionario::factory()

                ->count(fake()->numberBetween(2, 5))

                ->create([

                    'arenas_id' => $arena->id,

                    'enviados_por' => $arena->criado_por,

                ]);

        });

        /*
        |--------------------------------------------------------------------------
        | Alguns convites aceitos.
        |--------------------------------------------------------------------------
        */

        ConviteFuncionario::where('status', 'pendente')

            ->inRandomOrder()

            ->limit(8)

            ->get()

            ->each(function (ConviteFuncionario $convite) use ($usuarios) {

                $usuario = $usuarios->random();

                $convite->update([

                    'status' => 'aceitado',

                    'aceitados_por' => $usuario->id,

                ]);

            });

        /*
        |--------------------------------------------------------------------------
        | Alguns convites expirados.
        |--------------------------------------------------------------------------
        */

        ConviteFuncionario::where('status', 'pendente')

            ->inRandomOrder()

            ->limit(5)

            ->get()

            ->each(function (ConviteFuncionario $convite) {

                $convite->update([

                    'status' => 'expirado',

                    'expirado_em' => now()->subDay(),

                ]);

            });

        /*
        |--------------------------------------------------------------------------
        | Alguns convites cancelados.
        |--------------------------------------------------------------------------
        */

        ConviteFuncionario::where('status', 'pendente')

            ->inRandomOrder()

            ->limit(3)

            ->get()

            ->each(function (ConviteFuncionario $convite) {

                $convite->update([

                    'status' => 'cancelado',

                ]);

            });
    }
}
