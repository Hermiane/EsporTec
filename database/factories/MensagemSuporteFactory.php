<?php

namespace Database\Factories;

use App\Models\MensagemSuporte;
use App\Models\Suporte;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class MensagemSuporteFactory extends Factory
{
    protected $model = MensagemSuporte::class;

    public function definition(): array
    {
        return [

            'suportes_id' => Suporte::factory(),

            'usuarios_id' => Usuario::factory(),

            'mensagem' => fake()->paragraph(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function usuarioAnonimo(): static
    {
        return $this->state(fn () => [

            'usuarios_id' => null,

        ]);
    }

    public function respostaCurta(): static
    {
        return $this->state(fn () => [

            'mensagem' => fake()->sentence(),

        ]);
    }

    public function respostaLonga(): static
    {
        return $this->state(fn () => [

            'mensagem' => fake()->paragraphs(4, true),

        ]);
    }
}
