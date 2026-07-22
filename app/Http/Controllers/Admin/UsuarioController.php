<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\Usuario;
use App\Support\ArenaAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    use ArenaAuthorization;

    public function index(Request $request)
    {
        $d = $request->validate(['tipo' => ['nullable', 'in:funcionario,administrador']]); $ids = $this->arenaIdsPermitidos($request);
        // A tela de equipe representa apenas os vínculos ativos da arena atual.
        // Contas de superadmin não são membros da equipe de uma arena por si só.
        $funcionarios = FuncionarioArena::with(['usuario.pessoaFisica', 'arena'])
            ->where('ativo', true)
            ->whereIn('arenas_id', $ids)
            ->when(($d['tipo'] ?? null) === 'administrador', fn ($q) => $q->whereRaw('1=0'))
            ->get()
            ->map(fn ($v) => ['tipo' => 'funcionario', 'vinculo' => $v]);
        $administradores = AdminArena::with(['usuario.pessoaFisica', 'arena'])
            ->where('ativo', true)
            ->whereIn('arenas_id', $ids)
            ->when(($d['tipo'] ?? null) === 'funcionario', fn ($q) => $q->whereRaw('1=0'))
            ->get()
            ->map(fn ($v) => ['tipo' => 'administrador', 'vinculo' => $v]);
        return response()->json($funcionarios->concat($administradores)->map(function ($item) {
            $vinculo = $item['vinculo']; $usuario = $vinculo->usuario;
            return ['id' => $usuario->id, 'nome' => $usuario->nome_completo, 'email' => $usuario->email, 'telefone' => $usuario->telefone, 'perfil' => $item['tipo'] === 'administrador' ? 'admin' : 'funcionario', 'dono' => (bool) ($vinculo->is_dono ?? false), 'ativo' => $vinculo->ativo, 'arenas_id' => $vinculo->arenas_id];
        })->values());
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:191', 'unique:usuarios,email'],
            'telefone' => ['required', 'string', 'max:20'],
            'perfil' => ['required', 'in:funcionario,admin'],
            'senha' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $arenaId = $this->arenaIdsPermitidos($request)[0] ?? null;
        abort_unless($arenaId, 403, 'Nenhuma arena disponível para cadastrar a equipe.');

        $telefone = preg_replace('/\D/', '', $d['telefone']);
        abort_unless(strlen($telefone) === 11, 422, 'Informe um telefone com DDD e 11 números.');

        $model = DB::transaction(function () use ($d, $telefone, $arenaId, $request) {
            $base = Str::limit(Str::before($d['email'], '@'), 40, '');
            $nomeUsuario = $base;
            $sufixo = 1;
            while (Usuario::where('nome_usuario', $nomeUsuario)->exists()) {
                $nomeUsuario = $base.'-'.$sufixo++;
            }

            $usuario = Usuario::create([
                'nome_completo' => $d['nome'],
                'nome_usuario' => $nomeUsuario,
                'email' => $d['email'],
                'senha_hash' => Hash::make($d['senha']),
                'telefone' => $telefone,
                'data_nascimento' => null,
                'ativo' => true,
            ]);

            return $d['perfil'] === 'funcionario'
                ? FuncionarioArena::create(['usuarios_id' => $usuario->id, 'arenas_id' => $arenaId, 'cargo' => 'Funcionário', 'turno' => 'integral', 'criado_por' => $request->user()->id, 'ativo' => true])
                : AdminArena::create(['usuarios_id' => $usuario->id, 'arenas_id' => $arenaId, 'cargo' => 'Administrador', 'is_dono' => false, 'criado_por' => $request->user()->id, 'ativo' => true]);
        });

        return response()->json($model->load(['usuario.pessoaFisica', 'arena']), 201);
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
