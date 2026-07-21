<?php

namespace Database\Seeders;

use App\Models\AdminArena;
use App\Models\Arena;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class AdminArenaSeeder extends Seeder
{
    /**
     * Popula os administradores das arenas.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();

        /*
        |--------------------------------------------------------------------------
        | Cada arena possui um único proprietário.
        |--------------------------------------------------------------------------
        */

        Arena::all()->each(function (Arena $arena) use ($usuarios) {

            $dono = $usuarios->find($arena->criado_por);

            AdminArena::factory()

                ->dono()

                ->create([

                    'arenas_id' => $arena->id,

                    'usuarios_id' => $dono->id,

                    'criado_por' => $dono->id,

                ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Administradores adicionais.
        |--------------------------------------------------------------------------
        */

        Arena::all()->each(function (Arena $arena) use ($usuarios) {

            $quantidade = fake()->numberBetween(1, 3);

            $administradores = $usuarios
                ->where('id', '<>', $arena->criado_por)
                ->shuffle()
                ->take($quantidade);

           foreach ($administradores as $usuario) {

                AdminArena::factory()->create([

                    'arenas_id'   => $arena->id,

                    'usuarios_id' => $usuario->id,

                    'criado_por'  => $arena->criado_por,

                ]);
            }
      });

        /*
        |--------------------------------------------------------------------------
        | Alguns administradores tornam-se inativos.
        |--------------------------------------------------------------------------
        */

        AdminArena::where('is_dono', false)

            ->inRandomOrder()

            ->limit(5)

            ->get()

            ->each(function (AdminArena $admin) {

                $admin->update([

                    'ativo' => false,

                ]);
            });
    }
}