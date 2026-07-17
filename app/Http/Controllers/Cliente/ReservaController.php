<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservaController extends Controller
{
    // AGENDAMENTO: agora com quadra, usuario, hora_inicio/fim
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quadra_id' => ['required', 'exists:quadras,id'],
            'data' => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'valor_total' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', Rule::in(['pendente', 'confirmada', 'concluida', 'cancelada'])],
            'observacao' => ['nullable', 'string'],
        ]);

        // Se não mandar status, define como pendente
        if (!isset($validated['status'])) {
            $validated['status'] = 'pendente';
        }

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        // Confere se a quadra pertence à arena do usuário logado
        // (no projeto: vínculo via funcionario_arena)
        $arena = auth()->user()->arena()->first();

        $arenaId = $arena?->id;
        if (!$arenaId) {
            return response()->json(['message' => 'Usuário sem arena vinculada'], 403);
        }


        $quadra = \App\Models\Quadra::findOrFail($validated['quadra_id']);
        if ((int) $quadra->arenas_id !== (int) $arenaId) {
            return response()->json(['message' => 'Quadra não pertence à sua arena'], 403);
        }

        // Conflito: mesma quadra + mesma data + intervalos se sobrepõem
        // Considerar conflito os status: pendente, confirmada, paga
        $statusConflito = ['pendente', 'confirmada', 'paga'];

        $conflito = Reserva::where('quadras_id', $validated['quadra_id'])
            ->where('data', $validated['data'])
            ->whereIn('status', $statusConflito)
            ->where(function ($q) use ($validated) {
                $q->where(function ($q2) use ($validated) {
                    $q2->where('hora_inicio', '<', $validated['hora_fim'])
                        ->where('hora_fim', '>', $validated['hora_inicio']);
                });
            })
            ->exists();

        if ($conflito) {
            return response()->json(['message' => 'Horário indisponível (conflito de reserva).'], 409);
        }

        $reserva = Reserva::create([
            'reservas_usuarios_id' => $userId,
            'quadras_id' => $validated['quadra_id'],
            'data' => $validated['data'],
            'hora_inicio' => $validated['hora_inicio'],
            'hora_fim' => $validated['hora_fim'],
            'valor_total' => $validated['valor_total'],
            'status' => $validated['status'],
            'observacao' => $validated['observacao'] ?? null,
            'alteradas_por' => $userId,
        ]);

        return response()->json($reserva, 201);
    }


    // ATUALIZAR STATUS DA RESERVA
    public function updateStatus(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pendente', 'confirmada', 'concluida', 'cancelada'])],
            'alteradas_por' => ['required', 'exists:usuarios,id'] // quem alterou
        ]);

        $validated['alteradas_por'] = $validated['alteradas_por'] ?? $reserva->alteradas_por;
        $reserva->update($validated);

        return response()->json($reserva);
    }

    public function quadrasDisponiveis()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        // No seu projeto, o vínculo arena <-> usuário via tabela funcionarios_arenas.
        // Aqui usamos a mesma relação do model User (funcionario_arena/arenas).
        $arena = $user->arena()->first();
        $arenaId = $arena?->id;
        if (!$arenaId) {
            return response()->json(['message' => 'Usuário sem arena vinculada'], 403);
        }

        $quadras = \App\Models\Quadra::where('arenas_id', $arenaId)

            ->where('ativa', 1)
            ->get();

        return response()->json($quadras);
    }


    public function horariosDisponiveis($id)
    {
        // Por enquanto retorna horários fixos pra teste
        $horarios = [
            '08:00', '09:00', '10:00', '11:00',
            '14:00', '15:00', '16:00', '17:00',
            '18:00', '19:00', '20:00', '21:00',
        ];

        return response()->json($horarios);
    }

    public function minhasReservas()
    {
        // Por enquanto retorna vazio. Depois  pega pelo user logado
        return response()->json([]);
    }


    // CANCELAR RESERVA
    public function cancelar(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        
        $validated = $request->validate([
            'cancelado_por' => ['required', 'exists:usuarios,id'],
            'observacao' => ['nullable', 'string']
        ]);

        $reserva->update([
            'status' => 'cancelada',
            'cancelados_por' => $validated['cancelado_por'],
            'cancelada_em' => now(),
            'observacao' => $validated['observacao'] ?? $reserva->observacao
        ]);

        return response()->json($reserva);
    }
}