<?php

namespace Database\Factories;

use App\Models\Permissao;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissaoFactory extends Factory
{
    protected $model = Permissao::class;

    public function definition(): array
    {
        $permissoes = [
            'Gerenciar Reservas',
            'Gerenciar Quadras',
            'Gerenciar Funcionários',
            'Gerenciar Administradores',
            'Gerenciar Financeiro',
            'Gerenciar Ofertas',
            'Gerenciar Arena',
            'Visualizar Relatórios',
            'Gerenciar Configurações',
            'Gerenciar Notificações',
        ];

        $titulo = fake()->unique()->randomElement($permissoes);

        return [

            'titulo' => $titulo,

            'descricao' => fake()->sentence(),

        ];
    }
}
