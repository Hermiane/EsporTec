<?php

namespace Database\Factories;

use App\Models\ResetarSenha;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ResetarSenhaFactory extends Factory
{
    protected $model = ResetarSenha::class;

    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'email' => fake()->safeEmail(),

            'codigo' => strtoupper(Str::random(6)),

            'tentativa' => fake()->numberBetween(0, 3),

            'usado' => false,

            'expira_em' => now()->addMinutes(30),

            'tipo' => fake()->randomElement([
                'resetar_senha',
                'alterar_email',
            ]),

            'ip' => fake()->ipv4(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    /**
     * Código utilizado.
     */
    public function usado(): static
    {
        return $this->state(fn () => [

            'usado' => true,

        ]);
    }

    /**
     * Código expirado.
     */
    public function expirado(): static
    {
        return $this->state(fn () => [

            'expira_em' => now()->subMinutes(30),

        ]);
    }

    /**
     * Recuperação de senha.
     */
    public function resetarSenha(): static
    {
        return $this->state(fn () => [

            'tipo' => 'resetar_senha',

        ]);
    }

    /**
     * Alteração de e-mail.
     */
    public function alterarEmail(): static
    {
        return $this->state(fn () => [

            'tipo' => 'alterar_email',

        ]);
    }

    /**
     * Máximo de tentativas.
     */
    public function maxTentativas(): static
    {
        return $this->state(fn () => [

            'tentativa' => 5,

        ]);
    }

    /**
     * Solicitação recém criada.
     */
    public function recemCriado(): static
    {
        return $this->state(fn () => [

            'tentativa' => 0,

            'usado' => false,

            'expira_em' => now()->addMinutes(30),

        ]);
    }

    /**
     * Sem IP registrado.
     */
    public function semIp(): static
    {
        return $this->state(fn () => [

            'ip' => null,

        ]);
    }

    /**
     * Solicitação via IPv6.
     */
    public function ipv6(): static
    {
        return $this->state(fn () => [

            'ip' => fake()->ipv6(),

        ]);
    }
}
