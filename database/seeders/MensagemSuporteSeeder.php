<?php

namespace Database\Seeders;

use App\Models\MensagemSuporte;
use App\Models\Suporte;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class MensagemSuporteSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $suportes = Suporte::all();
        $usuarios = Usuario::all();

        if ($suportes->isEmpty()) {
            return;
        }

        /**
         * Mensagens normalmente enviadas
         * pelos clientes.
         */
        $mensagensCliente = [

            'Olá, estou enfrentando um problema e preciso de ajuda.',

            'Poderiam verificar esta situação, por favor?',

            'O erro continua acontecendo mesmo após atualizar a página.',

            'Consegui reproduzir o problema novamente.',

            'Existe alguma previsão para resolver este chamado?',

            'Obrigado pelo retorno. Aguardo novas informações.',

            'Realizei os testes solicitados e o problema permanece.',

            'Agora o sistema voltou a funcionar normalmente.',

        ];

        /**
         * Respostas normalmente enviadas
         * pela equipe de suporte.
         */
        $mensagensEquipe = [

            'Recebemos sua solicitação e já iniciamos a análise.',

            'Nossa equipe técnica está verificando o ocorrido.',

            'Poderia enviar mais detalhes para facilitar a análise?',

            'Identificamos a causa do problema e estamos realizando a correção.',

            'O procedimento foi concluído. Poderia confirmar se o problema foi resolvido?',

            'Obrigado pelo retorno. Permanecemos à disposição.',

            'O chamado será encerrado caso não haja novas manifestações.',

            'A correção foi aplicada com sucesso.',

        ];

        foreach ($suportes as $suporte) {

            $quantidadeMensagens = fake()->numberBetween(1, 8);

            for ($i = 1; $i <= $quantidadeMensagens; $i++) {

                /*
                 * Primeira mensagem normalmente
                 * é enviada pelo cliente.
                 */
                $cliente = $i === 1 || fake()->boolean(60);

                MensagemSuporte::create([

                    'suportes_id' => $suporte->id,

                    /*
                     * Alguns chamados podem ser
                     * enviados por usuários anônimos.
                     */
                    'usuarios_id' => fake()->boolean(90) && $usuarios->isNotEmpty()
                        ? $usuarios->random()->id
                        : null,

                    'mensagem' => $cliente
                        ? fake()->randomElement($mensagensCliente)
                        : fake()->randomElement($mensagensEquipe),

                    'created_at' => fake()->dateTimeBetween(
                        $suporte->created_at,
                        'now'
                    ),

                    'updated_at' => now(),

                ]);
            }
        }
    }
}