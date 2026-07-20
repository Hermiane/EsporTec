<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private function clientes()
    {
        return Usuario::whereDoesntHave('funcionariosArena', fn ($q) => $q->where('ativo', true))
            ->whereDoesntHave('administradoresArena', fn ($q) => $q->where('ativo', true))
            ->whereDoesntHave('superAdmin', fn ($q) => $q->where('ativo', true));
    }

    public function index(Request $request)
    {
        $filtro = $request->validate(['busca' => ['nullable', 'string', 'max:100']])['busca'] ?? null;
        return response()->json($this->clientes()->when($filtro, fn ($q) => $q->where(fn ($u) => $u->where('nome_completo', 'like', "%{$filtro}%")->orWhere('email', 'like', "%{$filtro}%")))->select('id', 'nome_completo', 'email', 'telefone', 'ativo', 'created_at')->paginate(20));
    }

    public function show($id)
    {
        return response()->json($this->clientes()->with(['reservas.quadra.arena', 'reservas.pagamento'])->findOrFail($id));
    }
}
