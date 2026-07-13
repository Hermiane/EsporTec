<?php

namespace Database\Factories;

use App\Models\SuperAdmin;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SuperAdmin>
 */
class SuperAdminFactory extends Factory
{
    /**
     * Model correspondente.
     *
     * @var class-string<SuperAdmin>
     */
    protected $model = SuperAdmin::class;

    /**
     * Define os valores padrão do Super Administrador.
     */
    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'cargo' => fake()->randomElement([
                'Super Administrador',
                'Administrador Geral',
                'Administrador Master',
            ]),

            'motivo' => fake()->optional()->sentence(),

            'ultimo_acesso' => fake()->optional()->dateTimeBetween(
                '-30 days',
                'now'
            ),

            'criado_por' => Usuario::factory(),

            'ativo' => true,
        ];
    }

    /**
     * Super Administrador inativo.
     */
    public function inativo(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }

    /**
     * Super Administrador sem último acesso.
     */
    public function semUltimoAcesso(): static
    {
        return $this->state(fn () => [

            'ultimo_acesso' => null,

        ]);
    }

    /**
     * Super Administrador promovido pelo sistema.
     */
    public function semCriador(): static
    {
        return $this->state(fn () => [

            'criado_por' => null,

        ]);
    }

    /**
     * Super Administrador com o cargo de Administrador Master.
     */
    public function administradorMaster(): static
    {
        return $this->state(fn () => [

            'cargo' => 'Administrador Master',

            'ativo' => true,

        ]);
    }
}
