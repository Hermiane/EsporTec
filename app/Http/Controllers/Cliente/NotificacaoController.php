<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Notificacao;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Notificacao::query()
                ->where('usuarios_id', $request->user()->id)
                ->latest('enviada_em')
                ->get()
                ->map(fn (Notificacao $notificacao) => [
                    'id' => $notificacao->id,
                    'tipo' => $notificacao->tipo,
                    'titulo' => $notificacao->titulo,
                    'mensagem' => $notificacao->mensagem,
                    'lida' => $notificacao->lida,
                    'enviada_em' => $notificacao->enviada_em?->toIso8601String(),
                ])
        );
    }

    public function ler(Request $request, Notificacao $notificacao)
    {
        abort_unless((int) $notificacao->usuarios_id === (int) $request->user()->id, 403);

        $notificacao->update(['lida' => true]);

        return response()->json(['message' => 'Notificação marcada como lida.']);
    }
}
