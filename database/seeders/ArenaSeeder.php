<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ArenaSeeder extends Seeder
{
    /**
     * Popula a tabela de arenas.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();

        if ($usuarios->isEmpty()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Arenas comuns
        |--------------------------------------------------------------------------
        */

        Arena::factory()
            ->count(25)
            ->make()
            ->each(function (Arena $arena) use ($usuarios) {

                $arena->criado_por = $usuarios->random()->id;

                $arena->save();

            });

        /*
        |--------------------------------------------------------------------------
        | Arenas sem foto
        |--------------------------------------------------------------------------
        */

        Arena::factory()
            ->count(5)
            ->semFoto()
            ->make()
            ->each(function (Arena $arena) use ($usuarios) {

                $arena->criado_por = $usuarios->random()->id;

                $arena->save();

            });

        /*
        |--------------------------------------------------------------------------
        | Arenas inativas
        |--------------------------------------------------------------------------
        */

        Arena::factory()
            ->count(3)
            ->inativa()
            ->make()
            ->each(function (Arena $arena) use ($usuarios) {

                $arena->criado_por = $usuarios->random()->id;

                $arena->save();

            });
    }
}