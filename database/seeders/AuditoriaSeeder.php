<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Auditoria;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class AuditoriaSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $arenas = Arena::all();

        if ($usuarios->isEmpty()) {
            return;
        }

        $acoes = [

            [
                'acao' => 'LOGIN',
                'descricao' => 'Usuário realizou login no sistema.',
                'tabela' => 'usuarios',
            ],

            [
                'acao' => 'LOGOUT',
                'descricao' => 'Usuário realizou logout do sistema.',
                'tabela' => 'usuarios',
            ],

            [
                'acao' => 'CREATE',
                'descricao' => 'Registro criado no sistema.',
                'tabela' => fake()->randomElement([
                    'reservas',
                    'quadras',
                    'pagamentos',
                    'ofertas',
                    'feedbacks',
                    'suportes',
                    'usuarios',
                    'arenas',
                ]),
            ],

            [
                'acao' => 'UPDATE',
                'descricao' => 'Registro atualizado.',
                'tabela' => fake()->randomElement([
                    'reservas',
                    'quadras',
                    'pagamentos',
                    'ofertas',
                    'feedbacks',
                    'suportes',
                ]),
            ],

            [
                'acao' => 'DELETE',
                'descricao' => 'Registro removido.',
                'tabela' => fake()->randomElement([
                    'reservas',
                    'ofertas',
                    'feedbacks',
                ]),
            ],

            [
                'acao' => 'EXPORT',
                'descricao' => 'Exportação de dados realizada.',
                'tabela' => fake()->randomElement([
                    'reservas',
                    'pagamentos',
                    'usuarios',
                ]),
            ],

            [
                'acao' => 'IMPORT',
                'descricao' => 'Importação de dados realizada.',
                'tabela' => fake()->randomElement([
                    'usuarios',
                    'quadras',
                    'ofertas',
                ]),
            ],

        ];

        foreach ($usuarios as $usuario) {

            $quantidade = fake()->numberBetween(2, 8);

            for ($i = 0; $i < $quantidade; $i++) {

                $evento = fake()->randomElement($acoes);

                Auditoria::create([

                    'usuarios_id' => fake()->boolean(95)
                        ? $usuario->id
                        : null,

                    'arenas_id' => $arenas->isNotEmpty() && fake()->boolean(75)
                        ? $arenas->random()->id
                        : null,

                    'acao' => $evento['acao'],

                    'descricao' => $evento['descricao'],

                    'tabela_afetada' => $evento['tabela'],

                    'registro_id' => fake()->numberBetween(
                        1,
                        1000
                    ),

                    'ip' => fake()->boolean(80)
                        ? fake()->ipv4()
                        : fake()->ipv6(),

                    'created_at' => fake()->dateTimeBetween(
                        '-6 months',
                        'now'
                    ),

                    'updated_at' => now(),

                ]);
            }
        }
    }
}