<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\FuncionarioArena;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class FuncionarioArenaSeeder extends Seeder
{
    /**
     * Popula os funcionários das arenas.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();

        /*
        |--------------------------------------------------------------------------
        | Funcionários das arenas.
        |--------------------------------------------------------------------------
        */

        /*
|--------------------------------------------------------------------------
| Funcionários das arenas.
|--------------------------------------------------------------------------
*/

Arena::all()->each(function (Arena $arena) use ($usuarios) {

    $quantidade = fake()->numberBetween(3, 8);

    $funcionarios = $usuarios
        ->where('id', '<>', $arena->criado_por)
        ->shuffle()
        ->take($quantidade);

    foreach ($funcionarios as $usuario) {

        FuncionarioArena::factory()->create([

            'arenas_id'   => $arena->id,

            'usuarios_id' => $usuario->id,

            'criado_por'  => $arena->criado_por,

        ]);
    }
});

        /*
        |--------------------------------------------------------------------------
        | Alguns funcionários tornam-se gerentes.
        |--------------------------------------------------------------------------
        */

        FuncionarioArena::inRandomOrder()

            ->limit(10)

            ->get()

            ->each(function (FuncionarioArena $funcionario) {

                $funcionario->update([

                    'cargo' => 'Gerente',

                ]);
            });

        /*
        |--------------------------------------------------------------------------
        | Alguns funcionários ficam inativos.
        |--------------------------------------------------------------------------
        */

        FuncionarioArena::inRandomOrder()

            ->limit(8)

            ->get()

            ->each(function (FuncionarioArena $funcionario) {

                $funcionario->update([

                    'ativo' => false,

                ]);
            });
    }
}