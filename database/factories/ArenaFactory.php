<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Arena>
 */
class ArenaFactory extends Factory
{
    /**
     * Model correspondente.
     *
     * @var class-string<Arena>
     */
    protected $model = Arena::class;

    /**
     * Define o estado padrão.
     */
    public function definition(): array
    {
        $pixTipo = fake()->randomElement([
            'cpf',
            'cnpj',
            'email',
            'telefone',
            'aleatoria',
        ]);

        return [

            'criado_por' => Usuario::factory(),

            'nome' => fake()->company(),

            'cnpj' => fake()->unique()->numerify('##############'),

            'logradouro' => fake()->streetName(),

            'bairro' => fake()->citySuffix(),

            'numero' => fake()->buildingNumber(),

            'ponto_referencia' => fake()->optional()->sentence(4),

            'cidade' => fake()->city(),

            'estado' => fake()->stateAbbr(),

            'telefone' => fake()->numerify('###########'),

            'email' => fake()->unique()->companyEmail(),

            'foto_capa' => fake()->optional()->imageUrl(
                1200,
                600,
                'sports'
            ),

            'descricao' => fake()->paragraph(4),

            'pix_tipo' => $pixTipo,

            'pix_chave' => match ($pixTipo) {

                'cpf' => fake()->numerify('###########'),

                'cnpj' => fake()->numerify('##############'),

                'email' => fake()->companyEmail(),

                'telefone' => fake()->numerify('###########'),

                default => fake()->uuid(),
            },

            'ativo' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    /**
     * Arena inativa.
     */
    public function inativa(): static
    {
        return $this->state(fn () => [

            'ativo' => false,

        ]);
    }

    /**
     * Arena com foto.
     */
    public function comFoto(): static
    {
        return $this->state(fn () => [

            'foto_capa' => fake()->imageUrl(
                1200,
                600,
                'sports'
            ),

        ]);
    }

    /**
     * Arena sem foto.
     */
    public function semFoto(): static
    {
        return $this->state(fn () => [

            'foto_capa' => null,

        ]);
    }

    /**
     * Arena localizada em um estado específico.
     */
    public function estado(string $uf): static
    {
        return $this->state(fn () => [

            'estado' => strtoupper($uf),

        ]);
    }

    /**
     * Arena localizada em uma cidade específica.
     */
    public function cidade(string $cidade): static
    {
        return $this->state(fn () => [

            'cidade' => $cidade,

        ]);
    }
}
