<?php

namespace Database\Factories;

use App\Models\AdminArena;
use App\Models\AdminPermissao;
use App\Models\Permissao;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminPermissaoFactory extends Factory
{
    protected $model = AdminPermissao::class;

    public function definition(): array
    {
        return [

            'admins_arenas_id' => AdminArena::factory(),

            'permissoes_id' => Permissao::factory(),

            'concedido_por' => Usuario::factory(),

        ];
    }
}
