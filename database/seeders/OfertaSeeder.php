<?php

namespace Database\Seeders;

use App\Models\AdminArena;
use App\Models\Arena;
use App\Models\Oferta;
use Illuminate\Database\Seeder;

class OfertaSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        Arena::with('administradores')
            ->get()
            ->each(function (Arena $arena) {

                /**
                 * Procura o dono da arena.
                 */
                $dono = $arena->administradores()
                    ->where('is_dono', true)
                    ->first();

                /**
                 * Caso não exista administrador,
                 * ignora a arena.
                 */
                if (! $dono instanceof AdminArena) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Oferta de Aniversário
                |--------------------------------------------------------------------------
                */
                Oferta::factory()
                    ->aniversario()
                    ->create([

                        'arenas_id' => $arena->id,

                        'criado_por' => $dono->usuarios_id,

                    ]);

                /*
                |--------------------------------------------------------------------------
                | Oferta Fidelidade
                |--------------------------------------------------------------------------
                */
                Oferta::factory()
                    ->fidelidade()
                    ->create([

                        'arenas_id' => $arena->id,

                        'criado_por' => $dono->usuarios_id,

                    ]);

                /*
                |--------------------------------------------------------------------------
                | Oferta Manual
                |--------------------------------------------------------------------------
                */
                Oferta::factory()
                    ->manual()
                    ->create([

                        'arenas_id' => $arena->id,

                        'criado_por' => $dono->usuarios_id,

                    ]);

                /*
                |--------------------------------------------------------------------------
                | Oferta Expirada
                |--------------------------------------------------------------------------
                */
                Oferta::factory()
                    ->expirada()
                    ->create([

                        'arenas_id' => $arena->id,

                        'criado_por' => $dono->usuarios_id,

                    ]);

                /*
                |--------------------------------------------------------------------------
                | Ofertas Aleatórias
                |--------------------------------------------------------------------------
                */
                Oferta::factory()
                    ->count(fake()->numberBetween(2, 5))
                    ->create([

                        'arenas_id' => $arena->id,

                        'criado_por' => $dono->usuarios_id,

                    ]);
            });
    }
}