<?php

namespace Database\Seeders;

use App\Models\FuncionarioArena;
use App\Models\FuncionarioPermissao;
use App\Models\Permissao;
use Illuminate\Database\Seeder;

class FuncionarioPermissaoSeeder extends Seeder
{
    /**
     * Popula as permissões dos funcionários.
     */
    public function run(): void
    {
        $permissoes = Permissao::all();

        FuncionarioArena::all()->each(function (FuncionarioArena $funcionario) use ($permissoes) {

            $quantidade = fake()->numberBetween(1, 4);

            $permissoes
                ->random($quantidade)
                ->each(function (Permissao $permissao) use ($funcionario) {

                    FuncionarioPermissao::firstOrCreate([

                        'funcionarios_id' => $funcionario->id,

                        'permissoes_id' => $permissao->id,

                    ], [

                        'concedido_por' => $funcionario->criado_por,

                    ]);

                });

        });
    }
}
