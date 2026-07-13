<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Notificacao;
use App\Models\Oferta;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacaoFactory extends Factory
{
    protected $model = Notificacao::class;

    public function definition(): array
    {
        return [

            'usuarios_id' => Usuario::factory(),

            'arenas_id' => Arena::factory(),

            'ofertas_id' => fake()->boolean(40)
                ? Oferta::factory()
                : null,

            'destinatario' => fake()->randomElement([
                'cliente',
                'funcionario',
                'admin',
                'dono_arena',
                'todos_clientes',
                'todos_funcionarios',
                'todos',
            ]),

            'tipo' => fake()->randomElement([
                'aniversario',
                'aviso',
                'oferta',
                'fidelidade',
                'inativo',
                'confirmacao',
                'manual',
                'cancelamento',
                'remarcacao',
                'suporte',
                'sistema',
            ]),

            'titulo' => fake()->sentence(4),

            'mensagem' => fake()->paragraph(),

            'lida' => fake()->boolean(40),

            'criado_por' => Usuario::factory(),

            'enviada_em' => fake()->dateTimeBetween('-30 days'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Estados
    |--------------------------------------------------------------------------
    */

    public function lida(): static
    {
        return $this->state(fn () => [

            'lida' => true,

        ]);
    }

    public function naoLida(): static
    {
        return $this->state(fn () => [

            'lida' => false,

        ]);
    }

    public function oferta(): static
    {
        return $this->state(fn () => [

            'tipo' => 'oferta',

            'ofertas_id' => Oferta::factory(),

        ]);
    }

    public function sistema(): static
    {
        return $this->state(fn () => [

            'tipo' => 'sistema',

            'ofertas_id' => null,

        ]);
    }

    public function todosClientes(): static
    {
        return $this->state(fn () => [

            'usuarios_id' => null,

            'destinatario' => 'todos_clientes',

        ]);
    }

    public function todos(): static
    {
        return $this->state(fn () => [

            'usuarios_id' => null,

            'destinatario' => 'todos',

        ]);
    }

    public function semArena(): static
    {
        return $this->state(fn () => [

            'arenas_id' => null,

        ]);
    }

    public function semOferta(): static
    {
        return $this->state(fn () => [

            'ofertas_id' => null,

        ]);
    }

    public function semResponsavel(): static
    {
        return $this->state(fn () => [

            'criado_por' => null,

        ]);
    }
}
