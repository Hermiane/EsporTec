<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Model correspondente.
     *
     * @var class-string<Usuario>
     */
    protected $model = Usuario::class;

    /**
     * Senha utilizada por padrão.
     */
    protected static ?string $password = null;

    /**
     * Define os valores padrão do usuário.
     */
    public function definition(): array
    {
        return [

            'nome_completo' => fake()->name(),

            'nome_usuario' => fake()->unique()->userName(),

            'email' => fake()->unique()->safeEmail(),

            'senha_hash' => static::$password ??= Hash::make('password'),

            'telefone' => fake()->unique()->numerify('###########'),

            'data_nascimento' => fake()->dateTimeBetween(
                '-70 years',
                '-18 years'
            )->format('Y-m-d'),

            'foto_perfil' => null,

            'email_marketing' => fake()->boolean(25),

            'ativo' => true,

            'relembrar_token' => null,

            'email_verificacao' => now(),

            'login_tentativa' => 0,

            'login_bloqueado_ate' => null,
        ];
    }

    /**
     * Usuário com e-mail ainda não verificado.
     */
    public function naoVerificado(): static
    {
        return $this->state(fn () => [

            'email_verificacao' => null,

        ]);
    }

    /**
     * Usuário inativo.
     */
    public function inativo(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }

    /**
     * Usuário inscrito no marketing.
     */
    public function marketing(): static
    {
        return $this->state(fn () => [

            'email_marketing' => true,

        ]);
    }

    /**
     * Usuário temporariamente bloqueado.
     */
    public function bloqueado(): static
    {
        return $this->state(fn () => [

            'login_tentativa' => 5,

            'login_bloqueado_ate' => now()->addMinutes(30),

        ]);
    }

    /**
     * Gera um token "Lembrar-me".
     */
    public function comRememberToken(): static
    {
        return $this->state(fn () => [

            'relembrar_token' => Str::random(64),

        ]);
    }

    /**
     * Usuário com foto de perfil.
     */
    public function comFoto(): static
    {
        return $this->state(fn () => [

            'foto_perfil' => 'usuarios/perfis/'.fake()->uuid().'.jpg',

        ]);
    }
}
