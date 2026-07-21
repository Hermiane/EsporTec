<?php

namespace Database\Seeders;

use App\Models\PessoaFisica;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class PessoaFisicaSeeder extends Seeder
{
    /**
     * Popula a tabela de pessoas físicas.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Apenas usuários que ainda não possuem CPF
        |--------------------------------------------------------------------------
        */

        Usuario::doesntHave('pessoaFisica')
            ->get()
            ->each(function (Usuario $usuario) {

                PessoaFisica::factory()->create([

                    'usuarios_id' => $usuario->id,

                ]);

            });

        /*
        |--------------------------------------------------------------------------
        | Marca parte dos CPFs como verificados
        |--------------------------------------------------------------------------
        */

        PessoaFisica::inRandomOrder()
            ->limit(
                (int) (PessoaFisica::count() * 0.80)
            )
            ->update([

                'cpf_verificado' => true,

            ]);
    }
}