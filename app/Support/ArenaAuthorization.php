<?php

namespace App\Support;

use App\Models\AdminArena;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;

trait ArenaAuthorization
{
    protected function isSuperAdmin(Request $request): bool
    {
        // No módulo administrativo, um usuário vinculado a uma arena deve
        // operar somente essa arena, mesmo que também tenha perfil global.
        if (AdminArena::where('usuarios_id', $request->user()->id)->where('ativo', true)->exists()) {
            return false;
        }
        return SuperAdmin::where('usuarios_id', $request->user()->id)->where('ativo', true)->exists();
    }

    protected function arenaIdsPermitidos(Request $request): array
    {
        if ($this->isSuperAdmin($request)) {
            return [];
        }

        return AdminArena::where('usuarios_id', $request->user()->id)
            ->where('ativo', true)
            ->pluck('arenas_id')->all();
    }

    protected function autorizarArena(Request $request, int $arenaId): void
    {
        if ($this->isSuperAdmin($request)) {
            return;
        }

        abort_unless(in_array($arenaId, $this->arenaIdsPermitidos($request), true), 403, 'Você não possui acesso a esta arena.');
    }
}
