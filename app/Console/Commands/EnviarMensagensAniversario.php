<?php

namespace App\Console\Commands;

use App\Models\Notificacao;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnviarMensagensAniversario extends Command
{
    protected $signature = 'aniversarios:enviar {--data= : Data para execução/teste no formato AAAA-MM-DD}';

    protected $description = 'Envia uma notificação aos clientes aniversariantes do dia';

    public function handle(): int
    {
        $hoje = $this->option('data')
            ? Carbon::createFromFormat('Y-m-d', $this->option('data'))->startOfDay()
            : now()->startOfDay();

        $enviadas = 0;

        Usuario::query()
            ->where('ativo', true)
            ->whereNotNull('data_nascimento')
            ->whereMonth('data_nascimento', $hoje->month)
            ->whereDay('data_nascimento', $hoje->day)
            ->each(function (Usuario $usuario) use ($hoje, &$enviadas) {
                $jaEnviada = Notificacao::query()
                    ->where('usuarios_id', $usuario->id)
                    ->where('tipo', 'aniversario')
                    ->whereYear('enviada_em', $hoje->year)
                    ->exists();

                if ($jaEnviada) {
                    return;
                }

                $primeiroNome = explode(' ', trim($usuario->nome_completo))[0];

                Notificacao::create([
                    'usuarios_id' => $usuario->id,
                    'destinatario' => 'cliente',
                    'tipo' => 'aniversario',
                    'titulo' => "Feliz aniversário, {$primeiroNome}! 🎉",
                    'mensagem' => 'A equipe EsporTec deseja a você um dia muito feliz, cheio de bons momentos e grandes partidas!',
                    'lida' => false,
                    'enviada_em' => $hoje->copy()->setTime(8, 0),
                ]);

                $enviadas++;
            });

        $this->info("Mensagens de aniversário enviadas: {$enviadas}.");

        return self::SUCCESS;
    }
}
