<?php

namespace Database\Factories;

use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition(): array
    {
        return [

            'reservas_id' => Reserva::factory(),

            'metodo' => fake()->randomElement([
                'dinheiro',
                'pix',
                'cartao_credito',
                'cartao_debito',
            ]),

            'status' => 'pendente',

            'valor' => fake()->randomFloat(
                2,
                50,
                400
            ),

            'pix_copia_cola' => null,

            'comprovante' => null,

            'pago_em' => null,

            'confirmados_por' => null,

        ];
    }

    public function pago(): static
    {
        return $this->state(fn () => [

            'status' => 'pago',

            'pago_em' => now(),

            'confirmados_por' => Usuario::factory(),

        ]);
    }

    public function estornado(): static
    {
        return $this->state(fn () => [

            'status' => 'estornado',

        ]);
    }

    public function recusado(): static
    {
        return $this->state(fn () => [

            'status' => 'recusado',

        ]);
    }

    public function pix(): static
    {
        return $this->state(fn () => [

            'metodo' => 'pix',

            'pix_copia_cola' => fake()->uuid(),

        ]);
    }

    public function dinheiro(): static
    {
        return $this->state(fn () => [

            'metodo' => 'dinheiro',

        ]);
    }

    public function cartaoCredito(): static
    {
        return $this->state(fn () => [

            'metodo' => 'cartao_credito',

        ]);
    }

    public function cartaoDebito(): static
    {
        return $this->state(fn () => [

            'metodo' => 'cartao_debito',

        ]);
    }
}
