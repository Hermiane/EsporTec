<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Auditoria;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditoriaFactory extends Factory
{
    protected $model = Auditoria::class;

    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'arenas_id' => Arena::factory(),

            'acao' => fake()->randomElement([
                'CREATE',
                'UPDATE',
                'DELETE',
                'LOGIN',
                'LOGOUT',
                'EXPORT',
                'IMPORT',
            ]),

            'descricao' => fake()->sentence(10),

            'tabela_afetada' => fake()->randomElement([
                'usuarios',
                'arenas',
                'reservas',
                'pagamentos',
                'quadras',
                'ofertas',
                'feedbacks',
                'suportes',
            ]),

            'registro_id' => fake()->numberBetween(1, 5000),

            'ip' => fake()->ipv4(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function semArena(): static
    {
        return $this->state(fn () => [

            'arenas_id' => null,

        ]);
    }

    public function semUsuario(): static
    {
        return $this->state(fn () => [

            'usuarios_id' => null,

        ]);
    }

    public function login(): static
    {
        return $this->state(fn () => [

            'acao' => 'LOGIN',

            'descricao' => 'Usuário realizou login no sistema.',

            'tabela_afetada' => 'usuarios',

        ]);
    }

    public function logout(): static
    {
        return $this->state(fn () => [

            'acao' => 'LOGOUT',

            'descricao' => 'Usuário realizou logout do sistema.',

            'tabela_afetada' => 'usuarios',

        ]);
    }

    public function criacao(): static
    {
        return $this->state(fn () => [

            'acao' => 'CREATE',

        ]);
    }

    public function atualizacao(): static
    {
        return $this->state(fn () => [

            'acao' => 'UPDATE',

        ]);
    }

    public function exclusao(): static
    {
        return $this->state(fn () => [

            'acao' => 'DELETE',

        ]);
    }

    public function ipv6(): static
    {
        return $this->state(fn () => [

            'ip' => fake()->ipv6(),

        ]);
    }
}
