<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Oferta;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfertaFactory extends Factory
{
    protected $model = Oferta::class;

    public function definition(): array
    {
        return [

            'arenas_id' => Arena::factory(),

            'titulo' => fake()->sentence(3),

            'descricao' => fake()->paragraph(),

            'desconto_percent' => fake()->randomFloat(2, 5, 70),

            'valida_ate' => now()->addDays(fake()->numberBetween(5, 90)),

            'tipo' => fake()->randomElement([
                'aniversario',
                'fidelidade',
                'manual',
            ]),

            'publico_alvo' => fake()->randomElement([
                'todos',
                'fiel',
                'vip',
                'inativo',
                'individual',
            ]),

            'ativo' => true,

            'criado_por' => Usuario::factory(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function aniversario(): static
    {
        return $this->state(fn () => [

            'tipo' => 'aniversario',

        ]);
    }

    public function fidelidade(): static
    {
        return $this->state(fn () => [

            'tipo' => 'fidelidade',

        ]);
    }

    public function manual(): static
    {
        return $this->state(fn () => [

            'tipo' => 'manual',

        ]);
    }

    public function expirada(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

            'valida_ate' => now()->subDay(),

        ]);
    }

    public function todos(): static
    {
        return $this->state(fn () => [

            'publico_alvo' => 'todos',

        ]);
    }

    public function semResponsavel(): static
    {
        return $this->state(fn () => [

            'criado_por' => null,

        ]);
    }
}
