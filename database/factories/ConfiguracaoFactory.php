<?php

namespace Database\Factories;

use App\Models\Arena;
use App\Models\Configuracao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Configuracao>
 */
class ConfiguracaoFactory extends Factory
{
    /**
     * Model correspondente.
     *
     * @var class-string<Configuracao>
     */
    protected $model = Configuracao::class;

    /**
     * Configurações possíveis.
     */
    protected array $configuracoes = [

        [
            'chave' => 'tempo_cancelamento',
            'valor' => '60',
            'descricao' => 'Tempo máximo para cancelamento da reserva.',
        ],

        [
            'chave' => 'tempo_reserva',
            'valor' => '120',
            'descricao' => 'Tempo padrão da reserva em minutos.',
        ],

        [
            'chave' => 'aceita_pix',
            'valor' => 'true',
            'descricao' => 'Define se a arena aceita pagamentos via PIX.',
        ],

        [
            'chave' => 'aceita_cartao',
            'valor' => 'true',
            'descricao' => 'Define se a arena aceita cartão.',
        ],

        [
            'chave' => 'limite_reservas',
            'valor' => '3',
            'descricao' => 'Quantidade máxima de reservas simultâneas.',
        ],

        [
            'chave' => 'dias_antecedencia',
            'valor' => '30',
            'descricao' => 'Quantidade máxima de dias para reservar.',
        ],
    ];

    /**
     * Estado padrão.
     */
    public function definition(): array
    {
        $config = fake()->randomElement(
            $this->configuracoes
        );

        return [

            'arenas_id' => Arena::factory(),

            'chave' => $config['chave'],

            'valor' => $config['valor'],

            'descricao' => $config['descricao'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    /**
     * Configuração PIX habilitado.
     */
    public function pix(): static
    {
        return $this->state(fn () => [

            'chave' => 'aceita_pix',

            'valor' => 'true',

            'descricao' => 'Pagamento via PIX habilitado.',

        ]);
    }

    /**
     * Configuração Cartão.
     */
    public function cartao(): static
    {
        return $this->state(fn () => [

            'chave' => 'aceita_cartao',

            'valor' => 'true',

            'descricao' => 'Pagamento via cartão habilitado.',

        ]);
    }

    /**
     * Tempo padrão de reserva.
     */
    public function tempoReserva(int $minutos): static
    {
        return $this->state(fn () => [

            'chave' => 'tempo_reserva',

            'valor' => (string) $minutos,

            'descricao' => 'Tempo padrão das reservas.',

        ]);
    }

    /**
     * Limite de reservas.
     */
    public function limiteReservas(int $quantidade): static
    {
        return $this->state(fn () => [

            'chave' => 'limite_reservas',

            'valor' => (string) $quantidade,

            'descricao' => 'Quantidade máxima de reservas.',

        ]);
    }
}
