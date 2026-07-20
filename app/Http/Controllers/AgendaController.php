<?php

namespace App\Http\Controllers;

use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\Reserva;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function dia(Request $request) { return $this->listar($request, now()->toDateString(), now()->toDateString()); }
    public function semana(Request $request) { return $this->listar($request, now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()); }

    public function alterarHorario(Request $request, $id)
    {
        $data = $request->validate(['data' => ['required', 'date', 'after_or_equal:today'], 'hora_inicio' => ['required', 'date_format:H:i'], 'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio']]);
        $reserva = Reserva::with('quadra')->findOrFail($id);
        abort_unless($this->temAcesso($request->user()->id, $reserva->quadra->arenas_id), 403);
        abort_if($reserva->status === 'cancelada', 422, 'Reserva cancelada não pode ser alterada.');
        $conflito = Reserva::where('quadras_id', $reserva->quadras_id)->where('data', $data['data'])->where('id', '!=', $reserva->id)->whereIn('status', ['pendente','confirmada'])->where('hora_inicio', '<', $data['hora_fim'])->where('hora_fim', '>', $data['hora_inicio'])->exists();
        abort_if($conflito, 409, 'Horário indisponível.');
        $reserva->update($data + ['alteradas_por' => $request->user()->id]);
        return response()->json($reserva->fresh());
    }

    private function listar(Request $request, string $inicio, string $fim)
    {
        $userId = $request->user()->id;
        return response()->json(Reserva::with(['usuario','quadra.arena'])->whereBetween('data', [$inicio, $fim])->whereHas('quadra', fn ($q) => $q->whereIn('arenas_id', $this->arenaIds($userId)))->orderBy('data')->orderBy('hora_inicio')->get());
    }
    private function arenaIds(int $id): array { return array_merge(AdminArena::where('usuarios_id',$id)->where('ativo',true)->pluck('arenas_id')->all(), FuncionarioArena::where('usuarios_id',$id)->where('ativo',true)->pluck('arenas_id')->all()); }
    private function temAcesso(int $id, int $arena): bool { return in_array($arena, $this->arenaIds($id), true); }
}
