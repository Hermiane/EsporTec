<?php

namespace App\Http\Middleware;

use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\SuperAdmin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Não autenticado.');
        }

        $isSuperAdmin = SuperAdmin::where('usuarios_id', $user->id)->where('ativo', true)->exists();
        $temAdminArenaAprovada = AdminArena::where('usuarios_id', $user->id)->where('ativo', true)
            ->whereHas('arena', fn ($arena) => $arena->where('ativo', true)->where('status_aprovacao', 'aprovada'))
            ->exists();
        $temFuncionarioArenaAprovada = FuncionarioArena::where('usuarios_id', $user->id)->where('ativo', true)
            ->whereHas('arena', fn ($arena) => $arena->where('ativo', true)->where('status_aprovacao', 'aprovada'))
            ->exists();

        if ($role === 'super_admin' && !$isSuperAdmin) {
            abort(403, 'Acesso restrito à equipe superadministradora da plataforma.');
        }

        if ($role === 'admin') {
            if (!$temAdminArenaAprovada) {
                abort(403, 'Acesso restrito a administradores de arena.');
            }
        }

        if ($role === 'funcionario' && !$temFuncionarioArenaAprovada) {
            abort(403, 'Acesso restrito a funcionários ativos da arena.');
        }

        if ($role === 'equipe' && !$temAdminArenaAprovada && !$temFuncionarioArenaAprovada) {
                abort(403, 'Acesso restrito à equipe da arena.');
        }

        return $next($request);
    }
}
