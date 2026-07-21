<?php

namespace Database\Seeders;

use App\Models\BloqueioQuadra;
use App\Models\Quadra;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class BloqueioQuadraSeeder extends Seeder
{
    /**
     * Popula bloqueios das quadras.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Usuários existentes.
        |--------------------------------------------------------------------------
        */

        $usuarios = Usuario::all();

        /*
        |--------------------------------------------------------------------------
        | Aproximadamente metade das quadras possuirá bloqueios.
        |--------------------------------------------------------------------------
        */

        Quadra::inRandomOrder()
            ->limit((int) (Quadra::count() * 0.5))
            ->get()
            ->each(function (Quadra $quadra) use ($usuarios) {

                BloqueioQuadra::factory()

                    ->count(fake()->numberBetween(1, 4))

                    ->create([

                        'quadras_id' => $quadra->id,

                        'criado_por' => $usuarios->random()->id,

                    ]);
            });

        /*
        |--------------------------------------------------------------------------
        | Alguns bloqueios são especificamente para manutenção.
        |--------------------------------------------------------------------------
        */

        BloqueioQuadra::inRandomOrder()
            ->limit(8)
            ->get()
            ->each(function (BloqueioQuadra $bloqueio) {

                $bloqueio->update([

                    'tipo' => 'manutencao',

                ]);
            });

        /*
        |--------------------------------------------------------------------------
        | Alguns bloqueios são para eventos.
        |--------------------------------------------------------------------------
        */

        BloqueioQuadra::inRandomOrder()
            ->limit(5)
            ->get()
            ->each(function (BloqueioQuadra $bloqueio) {

                $bloqueio->update([

                    'tipo' => 'evento',

                ]);
            });
    }
}