<?php

namespace Database\Seeders;

use App\Models\AdminArena;
use App\Models\AdminPermissao;
use App\Models\Permissao;
use Illuminate\Database\Seeder;

class AdminPermissaoSeeder extends Seeder
{
    /**
     * Popula as permissões dos administradores.
     */
    public function run(): void
    {
        $permissoes = Permissao::all();

if ($permissoes->isEmpty()) {
    throw new \RuntimeException(
        'Nenhuma permissão foi encontrada. Execute o PermissaoSeeder antes.'
    );
}

AdminArena::all()->each(function (AdminArena $admin) use ($permissoes) {

    $quantidade = fake()->numberBetween(3, min(6, $permissoes->count())
    );
    

    $permissoes
        ->random($quantidade)
        ->each(function (Permissao $permissao) use ($admin) {

            AdminPermissao::firstOrCreate(
                [
                    'admins_arenas_id' => $admin->id,
                    'permissoes_id'    => $permissao->id,
                ],
                [
                    'concedido_por'    => $admin->criado_por,
                    ]);

                });

        });
    }
}
