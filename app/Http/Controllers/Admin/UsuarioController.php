<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->validate(['tipo' => ['nullable', 'in:funcionario,administrador']])['tipo'] ?? null;
        $funcionarios = FuncionarioArena::with(['usuario', 'arena'])->when($tipo === 'administrador', fn ($q) => $q->whereRaw('1 = 0'))->get()->map(fn ($v) => ['tipo' => 'funcionario', 'vinculo' => $v]);
        $administradores = AdminArena::with(['usuario', 'arena'])->when($tipo === 'funcionario', fn ($q) => $q->whereRaw('1 = 0'))->get()->map(fn ($v) => ['tipo' => 'administrador', 'vinculo' => $v]);
        return response()->json($funcionarios->concat($administradores)->values());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => ['required', 'exists:usuarios,id'], 'arenas_id' => ['required', 'exists:arenas,id'],
            'tipo' => ['required', 'in:funcionario,administrador'], 'cargo' => ['required', 'string', 'max:50'],
            'turno' => ['required_if:tipo,funcionario', 'in:manha,tarde,noite,integral'], 'is_dono' => ['nullable', 'boolean'],
        ]);
        $model = $data['tipo'] === 'funcionario'
            ? FuncionarioArena::create(['usuarios_id' => $data['usuarios_id'], 'arenas_id' => $data['arenas_id'], 'cargo' => $data['cargo'], 'turno' => $data['turno'], 'criado_por' => $request->user()->id, 'ativo' => true])
            : AdminArena::create(['usuarios_id' => $data['usuarios_id'], 'arenas_id' => $data['arenas_id'], 'cargo' => $data['cargo'], 'is_dono' => $data['is_dono'] ?? false, 'criado_por' => $request->user()->id, 'ativo' => true]);
        return response()->json($model->load(['usuario', 'arena']), 201);
    }

    public function show(Request $request, $id)
    {
        $usuario = Usuario::with(['funcionariosArena.arena', 'administradoresArena.arena', 'superAdmin'])->findOrFail($id);
        return response()->json($usuario);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['arenas_id' => ['required', 'exists:arenas,id'], 'tipo' => ['required', 'in:funcionario,administrador'], 'cargo' => ['sometimes', 'string', 'max:50'], 'turno' => ['sometimes', 'in:manha,tarde,noite,integral'], 'ativo' => ['sometimes', 'boolean'], 'is_dono' => ['sometimes', 'boolean']]);
        $model = $data['tipo'] === 'funcionario'
            ? FuncionarioArena::where('usuarios_id', $id)->where('arenas_id', $data['arenas_id'])->firstOrFail()
            : AdminArena::where('usuarios_id', $id)->where('arenas_id', $data['arenas_id'])->firstOrFail();
        $model->update(collect($data)->except(['arenas_id', 'tipo'])->all());
        return response()->json($model->fresh(['usuario', 'arena']));
    }

    public function inativar(Request $request, $id)
    {
        $data = $request->validate(['arenas_id' => ['required', 'exists:arenas,id'], 'tipo' => ['required', 'in:funcionario,administrador']]);
        $model = $data['tipo'] === 'funcionario'
            ? FuncionarioArena::where('usuarios_id', $id)->where('arenas_id', $data['arenas_id'])->firstOrFail()
            : AdminArena::where('usuarios_id', $id)->where('arenas_id', $data['arenas_id'])->firstOrFail();
        $model->update(['ativo' => false]);
        return response()->json(['message' => 'Vínculo inativado.']);
    }
}
