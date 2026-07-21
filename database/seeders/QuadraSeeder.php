<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Quadra;
use Illuminate\Database\Seeder;

class QuadraSeeder extends Seeder
{
    /**
     * Popula as quadras das arenas.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Cada arena recebe entre 2 e 6 quadras.
        |--------------------------------------------------------------------------
        */

        Arena::all()->each(function (Arena $arena) {

            $quantidade = fake()->numberBetween(2, 6);

            for ($i = 1; $i <= $quantidade; $i++) {

                 Quadra::factory()->create([
                    'arenas_id' => $arena->id,
                    'nome' => "Quadra {$i}",
               ]);
           }
        });

        /*
        |--------------------------------------------------------------------------
        | Algumas quadras cobertas.
        |--------------------------------------------------------------------------
        */

        Quadra::inRandomOrder()
            ->limit(15)
            ->get()
            ->each(function (Quadra $quadra) {

                $quadra->update([
                    'coberta' => true,
                ]);
            });

        /*
        |--------------------------------------------------------------------------
        | Algumas quadras inativas.
        |--------------------------------------------------------------------------
        */

        Quadra::inRandomOrder()
            ->limit(5)
            ->get()
            ->each(function (Quadra $quadra) {

                $quadra->update([
                    'ativo' => false,
                ]);
            });
    }
}