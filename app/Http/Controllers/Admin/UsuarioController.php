<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\Usuario;
use App\Support\ArenaAuthorization;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    use ArenaAuthorization;

    public function index(Request $request)
    {
        $d = $request->validate(['tipo' => ['nullable', 'in:funcionario,administrador']]); $ids = $this->arenaIdsPermitidos($request);
        // A tela de equipe representa apenas os vínculos ativos da arena atual.
        // Contas de superadmin não são membros da equipe de uma arena por si só.
        $funcionarios = FuncionarioArena::with(['usuario', 'arena'])
            ->where('ativo', true)
            ->whereIn('arenas_id', $ids)
            ->when(($d['tipo'] ?? null) === 'administrador', fn ($q) => $q->whereRaw('1=0'))
            ->get()
            ->map(fn ($v) => ['tipo' => 'funcionario', 'vinculo' => $v]);
        $administradores = AdminArena::with(['usuario', 'arena'])
            ->where('ativo', true)
            ->whereIn('arenas_id', $ids)
            ->when(($d['tipo'] ?? null) === 'funcionario', fn ($q) => $q->whereRaw('1=0'))
            ->get()
            ->map(fn ($v) => ['tipo' => 'administrador', 'vinculo' => $v]);
        return response()->json($funcionarios->concat($administradores)->map(function ($item) {
            $vinculo = $item['vinculo']; $usuario = $vinculo->usuario;
            return ['id' => $usuario->id, 'nome' => $usuario->nome_completo, 'email' => $usuario->email, 'telefone' => $usuario->telefone, 'perfil' => $item['tipo'] === 'administrador' ? 'admin' : 'funcionario', 'ativo' => $vinculo->ativo, 'arenas_id' => $vinculo->arenas_id, 'cargo' => $vinculo->cargo, 'turno' => $vinculo->turno ?? null];
        })->values());
    }

    public function store(Request $request)
    {
        $d = $request->validate(['usuarios_id' => ['required', 'exists:usuarios,id'], 'arenas_id' => ['required', 'exists:arenas,id'], 'tipo' => ['required', 'in:funcionario,administrador'], 'cargo' => ['required', 'string', 'max:50'], 'turno' => ['required_if:tipo,funcionario', 'in:manha,tarde,noite,integral'], 'is_dono' => ['nullable', 'boolean']]);
        $this->autorizarArena($request, (int) $d['arenas_id']);
        $model = $d['tipo'] === 'funcionario' ? FuncionarioArena::create(['usuarios_id' => $d['usuarios_id'], 'arenas_id' => $d['arenas_id'], 'cargo' => $d['cargo'], 'turno' => $d['turno'], 'criado_por' => $request->user()->id, 'ativo' => true]) : AdminArena::create(['usuarios_id' => $d['usuarios_id'], 'arenas_id' => $d['arenas_id'], 'cargo' => $d['cargo'], 'is_dono' => $d['is_dono'] ?? false, 'criado_por' => $request->user()->id, 'ativo' => true]);
        return response()->json($model->load(['usuario', 'arena']), 201);
    }

    public function show(Request $request, $id)
    {
        $ids = $this->arenaIdsPermitidos($request);
        $usuario = Usuario::with(['funcionariosArena.arena', 'administradoresArena.arena'])->where(function ($q) use ($ids, $request) { $q->whereHas('funcionariosArena', fn ($v) => $v->when(!$this->isSuperAdmin($request), fn ($v) => $v->whereIn('arenas_id', $ids)))->orWhereHas('administradoresArena', fn ($v) => $v->when(!$this->isSuperAdmin($request), fn ($v) => $v->whereIn('arenas_id', $ids))); })->findOrFail($id);
        return response()->json($usuario);
    }

    public function update(Request $request, $id)
    {
        $d = $request->validate(['arenas_id' => ['required', 'exists:arenas,id'], 'tipo' => ['required', 'in:funcionario,administrador'], 'cargo' => ['sometimes', 'string', 'max:50'], 'turno' => ['sometimes', 'in:manha,tarde,noite,integral'], 'ativo' => ['sometimes', 'boolean'], 'is_dono' => ['sometimes', 'boolean']]); $this->autorizarArena($request, (int) $d['arenas_id']);
        $model = $d['tipo'] === 'funcionario' ? FuncionarioArena::where('usuarios_id', $id)->where('arenas_id', $d['arenas_id'])->firstOrFail() : AdminArena::where('usuarios_id', $id)->where('arenas_id', $d['arenas_id'])->firstOrFail();
        $model->update(collect($d)->except(['arenas_id', 'tipo'])->all()); return response()->json($model->fresh(['usuario', 'arena']));
    }

    public function inativar(Request $request, $id)
    {
        $d = $request->validate(['arenas_id' => ['required', 'exists:arenas,id'], 'tipo' => ['required', 'in:funcionario,administrador']]); $this->autorizarArena($request, (int) $d['arenas_id']);
        $model = $d['tipo'] === 'funcionario' ? FuncionarioArena::where('usuarios_id', $id)->where('arenas_id', $d['arenas_id'])->firstOrFail() : AdminArena::where('usuarios_id', $id)->where('arenas_id', $d['arenas_id'])->firstOrFail();
        $model->update(['ativo' => false]); return response()->json(['message' => 'Vínculo inativado.']);
    }
}
