<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Configuracao;
use Illuminate\Database\Seeder;

class ConfiguracaoSeeder extends Seeder
{
    /**
     * Popula as configurações das arenas.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Cada arena recebe um conjunto completo
        | de configurações do sistema.
        |--------------------------------------------------------------------------
        */

        Arena::all()->each(function (Arena $arena) {

            Configuracao::factory()->create([
                'arenas_id' => $arena->id,
                'chave' => 'tempo_cancelamento',
                'valor' => '60',
                'descricao' => 'Tempo máximo para cancelamento da reserva.',
            ]);

            Configuracao::factory()->create([
                'arenas_id' => $arena->id,
                'chave' => 'tempo_reserva',
                'valor' => '120',
                'descricao' => 'Tempo padrão da reserva em minutos.',
            ]);

            Configuracao::factory()->create([
                'arenas_id' => $arena->id,
                'chave' => 'aceita_pix',
                'valor' => 'true',
                'descricao' => 'Define se a arena aceita pagamentos via PIX.',
            ]);

            Configuracao::factory()->create([
                'arenas_id' => $arena->id,
                'chave' => 'aceita_cartao',
                'valor' => 'true',
                'descricao' => 'Define se a arena aceita cartão.',
            ]);

            Configuracao::factory()->create([
                'arenas_id' => $arena->id,
                'chave' => 'limite_reservas',
                'valor' => '3',
                'descricao' => 'Quantidade máxima de reservas simultâneas.',
            ]);

            Configuracao::factory()->create([
                'arenas_id' => $arena->id,
                'chave' => 'dias_antecedencia',
                'valor' => '30',
                'descricao' => 'Quantidade máxima de dias para reservar.',
            ]);
        });
    }
}