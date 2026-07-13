<?php

namespace Database\Factories;

use App\Models\Oferta;
use App\Models\Reserva;
use App\Models\UsoOferta;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsoOfertaFactory extends Factory
{
    protected $model = UsoOferta::class;

    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'ofertas_id' => Oferta::factory(),

            'reservas_id' => Reserva::factory(),

            'enviada_em' => fake()->dateTimeBetween('-30 days'),

            'utilizada' => fake()->boolean(60),

            'utilizada_em' => fake()->optional(0.6)
                ->dateTimeBetween('-30 days'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function utilizada(): static
    {
        return $this->state(fn () => [

            'utilizada' => true,

            'utilizada_em' => now(),

        ]);
    }

    public function naoUtilizada(): static
    {
        return $this->state(fn () => [

            'utilizada' => false,

            'utilizada_em' => null,

        ]);
    }

    public function enviadaHoje(): static
    {
        return $this->state(fn () => [

            'enviada_em' => now(),

        ]);
    }
}
