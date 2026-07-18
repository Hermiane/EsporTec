<?php

namespace App\Policies;

use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\Usuario;

class PagamentoPolicy
{
    public function viewAny(Usuario $user): bool
    {
        return $this->ehSuperAdministrador($user)
            || AdminArena::where('usuarios_id', $user->id)->where('ativo', true)->exists()
            || FuncionarioArena::where('usuarios_id', $user->id)->where('ativo', true)->exists();
    }

    public function view(Usuario $user, Reserva $reserva): bool
    {
        if ($this->ehSuperAdministrador($user) || $user->id === $reserva->reservas_usuarios_id) {
            return true;
        }

        return $this->temAcessoArena($user, $reserva->quadra->arenas_id);
    }

    public function create(Usuario $user, Reserva $reserva): bool
    {
        return $user->id === $reserva->reservas_usuarios_id;
    }

    public function confirmar(Usuario $user, Pagamento $pagamento): bool
    {
        return $this->ehSuperAdministrador($user)
            || $this->temAcessoArena($user, $pagamento->reserva->quadra->arenas_id);
    }

    public function update(Usuario $user, Pagamento $pagamento): bool
    {
        return false;
    }

    public function delete(Usuario $user, Pagamento $pagamento): bool
    {
        return false;
    }

    private function ehSuperAdministrador(Usuario $user): bool
    {
        return $user->superAdmin()->where('ativo', true)->exists();
    }

    private function temAcessoArena(Usuario $user, int $arenaId): bool
    {
        return AdminArena::where('usuarios_id', $user->id)
            ->where('arenas_id', $arenaId)
            ->where('ativo', true)
            ->exists()
            || FuncionarioArena::where('usuarios_id', $user->id)
                ->where('arenas_id', $arenaId)
                ->where('ativo', true)
                ->exists();
    }
}
