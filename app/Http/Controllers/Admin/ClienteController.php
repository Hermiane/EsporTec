<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Support\ArenaAuthorization;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use ArenaAuthorization;

    private function clientesDaArena(Request $request)
    {
        $ids = $this->arenaIdsPermitidos($request);
        return Usuario::whereDoesntHave('funcionariosArena', fn ($q) => $q->where('ativo', true))->whereDoesntHave('administradoresArena', fn ($q) => $q->where('ativo', true))->whereDoesntHave('superAdmin', fn ($q) => $q->where('ativo', true))->whereHas('reservas.quadra', fn ($q) => $q->when(!$this->isSuperAdmin($request), fn ($q) => $q->whereIn('arenas_id', $ids)));
    }

    public function index(Request $request)
    {
        $d = $request->validate(['busca' => ['nullable', 'string', 'max:100']]);
        return response()->json($this->clientesDaArena($request)->when($d['busca'] ?? null, fn ($q, $busca) => $q->where(fn ($u) => $u->where('nome_completo', 'like', "%{$busca}%")->orWhere('email', 'like', "%{$busca}%")))->withCount('reservas')->select('id', 'nome_completo', 'email', 'telefone', 'ativo', 'created_at')->get()->map(fn ($u) => ['id' => $u->id, 'nome' => $u->nome_completo, 'email' => $u->email, 'telefone' => $u->telefone, 'reservas' => $u->reservas_count, 'ultima_visita' => $u->updated_at?->toDateString()]));
    }

    public function show(Request $request, $id)
    {
        return response()->json($this->clientesDaArena($request)->with(['reservas' => fn ($q) => $q->whereHas('quadra', fn ($quadra) => $quadra->when(!$this->isSuperAdmin($request), fn ($quadra) => $quadra->whereIn('arenas_id', $this->arenaIdsPermitidos($request))))->with(['quadra.arena', 'pagamento'])])->findOrFail($id));
    }
}
