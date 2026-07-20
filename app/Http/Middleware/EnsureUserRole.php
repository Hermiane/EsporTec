<?php

namespace App\Http\Middleware;

use App\Models\AdminArena;
use App\Models\FuncionarioArena;
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

        $isSuperAdmin = $user->superAdmin()->where('ativo', true)->exists();

        if ($role === 'admin' && !$isSuperAdmin) {
            abort(403, 'Acesso restrito a super administradores.');
        }

        if ($role === 'equipe' && !$isSuperAdmin) {
            $hasArenaRole = AdminArena::where('usuarios_id', $user->id)->where('ativo', true)->exists()
                || FuncionarioArena::where('usuarios_id', $user->id)->where('ativo', true)->exists();

            if (!$hasArenaRole) {
                abort(403, 'Acesso restrito à equipe da arena.');
            }
        }

        return $next($request);
    }
}
