<?php

namespace Database\Seeders;

use App\Models\ResetarSenha;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ResetarSenhaSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();

        if ($usuarios->isEmpty()) {
            return;
        }

        foreach ($usuarios as $usuario) {

            /*
             * Nem todo usuário possui uma
             * solicitação de recuperação.
             */
            if (fake()->boolean(45) === false) {
                continue;
            }

            /*
             * Cada usuário possui entre
             * uma e duas solicitações.
             */
            $quantidade = fake()->numberBetween(1, 2);

            for ($i = 0; $i < $quantidade; $i++) {

                $usado = fake()->boolean(35);

                $expirado = !$usado && fake()->boolean(30);

                ResetarSenha::create([

                    'usuarios_id' => $usuario->id,

                    /*
                     * Sempre utiliza o e-mail
                     * real do usuário.
                     */
                    'email' => $usuario->email,

                    /*
                     * Código semelhante ao enviado
                     * por e-mail.
                     */
                    'codigo' => strtoupper(
                        Str::random(6)
                    ),

                    /*
                     * Tentativas realizadas.
                     */
                    'tentativa' => fake()->numberBetween(
                        0,
                        5
                    ),

                    'usado' => $usado,

                    /*
                     * Expiração coerente.
                     */
                    'expira_em' => $expirado
                        ? fake()->dateTimeBetween(
                            '-3 days',
                            '-1 hour'
                        )
                        : fake()->dateTimeBetween(
                            'now',
                            '+30 minutes'
                        ),

                    'tipo' => fake()->randomElement([
                        'resetar_senha',
                        'alterar_email',
                    ]),

                    /*
                     * IPv4 ou IPv6.
                     */
                    'ip' => fake()->boolean(80)
                        ? fake()->ipv4()
                        : fake()->ipv6(),

                    'created_at' => fake()->dateTimeBetween(
                        '-3 months',
                        'now'
                    ),

                    'updated_at' => now(),

                ]);
            }
        }
    }
}