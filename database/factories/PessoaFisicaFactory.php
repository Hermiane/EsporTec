<?php

namespace Database\Factories;

use App\Models\PessoaFisica;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PessoaFisica>
 */
class PessoaFisicaFactory extends Factory
{
    /**
     * Model correspondente.
     *
     * @var class-string<PessoaFisica>
     */
    protected $model = PessoaFisica::class;

    /**
     * Define os valores padrão da Pessoa Física.
     */
    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'cpf' => fake()->unique()->numerify('###########'),

            'cpf_verificado' => false,
        ];
    }

    /**
     * CPF verificado.
     */
    public function verificado(): static
    {
        return $this->state(fn () => [

            'cpf_verificado' => true,

        ]);
    }

    /**
     * CPF pendente de validação.
     */
    public function naoVerificado(): static
    {
        return $this->state(fn () => [

            'cpf_verificado' => false,

        ]);
    }
}
