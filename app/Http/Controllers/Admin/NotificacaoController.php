<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notificacao;
use App\Support\ArenaAuthorization;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    use ArenaAuthorization;

    public function index(Request $request)
    {
        $ids = $this->arenaIdsPermitidos($request);
        return response()->json(Notificacao::when(!$this->isSuperAdmin($request), fn ($q) => $q->whereIn('arenas_id', $ids))->latest('enviada_em')->get()->map(fn ($n) => ['id' => $n->id, 'tipo' => $n->tipo, 'titulo' => $n->titulo, 'mensagem' => $n->mensagem, 'lida' => $n->lida, 'tempo' => optional($n->enviada_em)->format('d/m/Y H:i'), 'icone' => 'bi-bell']));
    }

    public function marcarTodas(Request $request)
    {
        $ids = $this->arenaIdsPermitidos($request);
        Notificacao::when(!$this->isSuperAdmin($request), fn ($q) => $q->whereIn('arenas_id', $ids))->where('lida', false)->update(['lida' => true]);
        return response()->json(['message' => 'Notificações marcadas como lidas.']);
    }

    public function ler(Request $request, Notificacao $notificacao)
    {
        $this->autorizarArena($request, (int) $notificacao->arenas_id);
        $notificacao->update(['lida' => true]);
        return response()->json(['message' => 'Notificação marcada como lida.']);
    }
}
