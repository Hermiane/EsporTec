<?php

namespace Database\Factories;

use App\Models\FuncionarioArena;
use App\Models\FuncionarioPermissao;
use App\Models\Permissao;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioPermissaoFactory extends Factory
{
    protected $model = FuncionarioPermissao::class;

    public function definition(): array
    {
        return [

            'funcionarios_id' => FuncionarioArena::factory(),

            'permissoes_id' => Permissao::factory(),

            'concedido_por' => Usuario::factory(),

        ];
    }
}
