<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Despesa;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class DespesaFactory extends Factory
{
    protected $model = Despesa::class;

    public function definition(): array
    {
        $recorrente = fake()->boolean(35);

        return [

            'arenas_id' => Arena::factory(),

            'registrado_por' => Usuario::factory(),

            'descricao' => fake()->sentence(6),

            'categoria' => fake()->randomElement([
                'salario',
                'manutencao',
                'conta',
                'marketing',
                'equipamento',
                'outros',
            ]),

            'valor' => fake()->randomFloat(
                2,
                20,
                5000
            ),

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
                ? 'comprovantes/'.fake()->uuid().'.pdf'
                : null,

            'observacao' => fake()->realText(200),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    /**
     * Despesa recorrente.
     */
    public function recorrente(): static
    {
        return $this->state(fn () => [

            'recorrente' => true,

            'recorrencia' => fake()->randomElement([
                'diaria',
                'semanal',
                'mensal',
                'anual',
            ]),

        ]);
    }

    /**
     * Despesa não recorrente.
     */
    public function naoRecorrente(): static
    {
        return $this->state(fn () => [

            'recorrente' => false,

            'recorrencia' => null,

        ]);
    }

    /**
     * Despesa de salário.
     */
    public function salario(): static
    {
        return $this->state(fn () => [

            'categoria' => 'salario',

            'valor' => fake()->randomFloat(
                2,
                1200,
                6000
            ),

        ]);
    }

    /**
     * Despesa de manutenção.
     */
    public function manutencao(): static
    {
        return $this->state(fn () => [

            'categoria' => 'manutencao',

        ]);
    }

    /**
     * Despesa de marketing.
     */
    public function marketing(): static
    {
        return $this->state(fn () => [

            'categoria' => 'marketing',

        ]);
    }

    /**
     * Despesa de equipamento.
     */
    public function equipamento(): static
    {
        return $this->state(fn () => [

            'categoria' => 'equipamento',

        ]);
    }

    /**
     * Com comprovante.
     */
    public function comComprovante(): static
    {
        return $this->state(fn () => [

            'comprovante' => 'comprovantes/'.fake()->uuid().'.pdf',

        ]);
    }

    /**
     * Sem comprovante.
     */
    public function semComprovante(): static
    {
        return $this->state(fn () => [

            'comprovante' => null,

        ]);
    }

    /**
     * Sem observação.
     */
    public function semObservacao(): static
    {
        return $this->state(fn () => [

            'observacao' => null,

        ]);
    }
}
