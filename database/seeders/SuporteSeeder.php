<?php

namespace Database\Seeders;

use App\Models\Arena;
use App\Models\Suporte;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class SuporteSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $arenas = Arena::all();
        $usuarios = Usuario::all();

        if ($arenas->isEmpty()) {
            return;
        }

        /**
         * Possíveis chamados.
         */
        $chamados = [

            [
                'titulo' => 'Erro ao confirmar reserva',
                'descricao' => 'Ao tentar confirmar uma reserva o sistema retorna erro inesperado.',
            ],

            [
                'titulo' => 'Problema no pagamento PIX',
                'descricao' => 'O pagamento foi realizado, porém continua aparecendo como pendente.',
            ],

            [
                'titulo' => 'Reserva duplicada',
                'descricao' => 'Foi identificada a criação de duas reservas para o mesmo horário.',
            ],

            [
                'titulo' => 'Falha no envio de notificações',
                'descricao' => 'Os clientes não estão recebendo notificações após a confirmação da reserva.',
            ],

            [
                'titulo' => 'Erro ao cadastrar oferta',
                'descricao' => 'Ao salvar uma nova oferta o sistema apresenta erro interno.',
            ],

            [
                'titulo' => 'Solicitação de suporte técnico',
                'descricao' => 'Necessário verificar lentidão durante o acesso ao painel administrativo.',
            ],

            [
                'titulo' => 'Problema no login',
                'descricao' => 'Usuário não consegue acessar sua conta mesmo utilizando a senha correta.',
            ],

            [
                'titulo' => 'Atualização de dados da arena',
                'descricao' => 'Solicitação para alteração das informações cadastrais da arena.',
            ],

        ];

        /**
         * Gera chamados para cada arena.
         */
        foreach ($arenas as $arena) {

            $quantidadeChamados = fake()->numberBetween(3, 8);

            for ($i = 0; $i < $quantidadeChamados; $i++) {

                $chamado = fake()->randomElement($chamados);

                $status = fake()->randomElement([
                    'aberto',
                    'em_andamento',
                    'pendente',
                    'resolvido',
                    'cancelado',
                    'fechado',
                ]);

                Suporte::create([

                    'arenas_id' => $arena->id,

                    /*
                     * Alguns chamados podem ser anônimos.
                     */
                    'usuarios_id' => fake()->boolean(90) && $usuarios->isNotEmpty()
                        ? $usuarios->random()->id
                        : null,

                    'titulo' => $chamado['titulo'],

                    'descricao' => $chamado['descricao'],

                    'status' => $status,

                    'created_at' => fake()->dateTimeBetween(
                        '-6 months',
                        'now'
                    ),

                    'updated_at' => now(),

                ]);
            }
        }
    }
}