<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Despesa;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DespesaSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $arenas = Arena::all();
        $usuarios = Usuario::all();

        if (
            $arenas->isEmpty() ||
            $usuarios->isEmpty()
        ) {
            return;
        }

        /**
         * Categorias disponíveis.
         */
        $categorias = [
            'salario',
            'manutencao',
            'conta',
            'marketing',
            'equipamento',
            'outros',
        ];

        /**
         * Gera despesas para cada arena.
         */
        foreach ($arenas as $arena) {

            $quantidade = fake()->numberBetween(8, 20);

            for ($i = 0; $i < $quantidade; $i++) {

                $categoria = fake()->randomElement($categorias);

                $recorrente = fake()->boolean(35);

                Despesa::create([

                    'arenas_id' => $arena->id,

                    'registrado_por' => $usuarios->random()->id,

                    'descricao' => match ($categoria) {

                        'salario' =>
                            fake()->randomElement([
                                'Pagamento de funcionário',
                                'Folha salarial mensal',
                                'Pagamento de estagiário',
                            ]),

                        'manutencao' =>
                            fake()->randomElement([
                                'Manutenção da iluminação',
                                'Troca da rede da quadra',
                                'Reparo do gramado sintético',
                                'Pintura da quadra',
                            ]),

                        'conta' =>
                            fake()->randomElement([
                                'Conta de energia',
                                'Conta de água',
                                'Internet',
                                'Telefone',
                            ]),

                        'marketing' =>
                            fake()->randomElement([
                                'Campanha no Instagram',
                                'Anúncio patrocinado',
                                'Material gráfico',
                            ]),

                        'equipamento' =>
                            fake()->randomElement([
                                'Compra de bolas',
                                'Compra de coletes',
                                'Compra de cones',
                                'Compra de redes',
                            ]),

                        default =>
                            fake()->sentence(),

                    },

                    'categoria' => $categoria,

                    'valor' => match ($categoria) {

                        'salario' => fake()->randomFloat(
                            2,
                            1500,
                            6000
                        ),

                        'marketing' => fake()->randomFloat(
                            2,
                            100,
                            2000
                        ),

                        'equipamento' => fake()->randomFloat(
                            2,
                            50,
                            2500
                        ),

                        'manutencao' => fake()->randomFloat(
                            2,
                            100,
                            3500
                        ),

                        'conta' => fake()->randomFloat(
                            2,
                            80,
                            1500
                        ),

                        default => fake()->randomFloat(
                            2,
                            20,
                            1000
                        ),

                    },

                    'data_despesas' => fake()->dateTimeBetween(
                        '-12 months',
                        'now'
                    ),

                    'semana_do_mes' => fake()->numberBetween(
                        1,
                        5
                    ),

                    'recorrente' => $recorrente,

                    'recorrencia' => $recorrente
                        ? fake()->randomElement([
                            'diaria',
                            'semanal',
                            'mensal',
                            'anual',
                        ])
                        : null,

                    'comprovante' => fake()->boolean(60)
                        ? 'comprovantes/' .
                        fake()->uuid() .
                        '.pdf'
                        : null,

                    'observacao' => fake()->realText(120),

                    'created_at' => now(),

                    'updated_at' => now(),

                ]);
            }
        }
    }
}