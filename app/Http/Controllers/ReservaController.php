<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Quadra;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            // status é forçado no create (não confiamos no body)
            'status' => ['sometimes', Rule::in(['pendente', 'confirmada', 'concluida', 'cancelada'])],
            'observacao' => ['nullable', 'string'],
        ]);

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $arena = auth()->user()->arena()->first();
        $arenaId = $arena?->id;
        if (!$arenaId) {
            return response()->json(['message' => 'Usuário sem arena vinculada'], 403);
        }

        $quadra = Quadra::findOrFail($validated['quadra_id']);
        if ((int) $quadra->arenas_id !== (int) $arenaId) {
            return response()->json(['message' => 'Quadra não pertence à sua arena'], 403);
        }

        if (!(bool) $quadra->ativa) {
            return response()->json(['message' => 'Quadra inativa'], 403);
        }

        $statusConflito = ['pendente', 'confirmada', 'paga'];

        try {
            $reserva = DB::transaction(function () use ($validated, $userId, $statusConflito) {
                // Lock explícito nas reservas conflitantes para evitar race condition
                $conflitos = Reserva::query()
                    ->where('quadras_id', $validated['quadra_id'])
                    ->where('data', $validated['data'])
                    ->whereIn('status', $statusConflito)
                    ->where(function ($q) use ($validated) {
                        $q->where(function ($q2) use ($validated) {
                            $q2->where('hora_inicio', '<', $validated['hora_fim'])
                                ->where('hora_fim', '>', $validated['hora_inicio']);
                        });
                    })
                    ->lockForUpdate()
                    ->get();

                if ($conflitos->isNotEmpty()) {
                    // Mantém o mesmo contrato que já existia
                    throw new \RuntimeException('Horário indisponível (conflito de reserva).');
                }

                // Força status pendente no create
                return Reserva::create([
                    'reservas_usuarios_id' => $userId,
                    'quadras_id' => $validated['quadra_id'],
                    'data' => $validated['data'],
                    'hora_inicio' => $validated['hora_inicio'],
                    'hora_fim' => $validated['hora_fim'],
                    'valor_total' => $validated['valor_total'],
                    'status' => 'pendente',
                    'observacao' => $validated['observacao'] ?? null,
                    'alteradas_por' => $userId,
                ]);
            });

            return response()->json($reserva, 201);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    
    }

    // ATUALIZAR STATUS DA RESERVA
    public function updateStatus(Request $request, $id)
    {
        $reserva = Reserva::with('quadra')->findOrFail($id);

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $arenaId = auth()->user()->arena()->first()?->id;
        if (!$arenaId) {
            return response()->json(['message' => 'Usuário sem arena vinculada'], 403);
        }

        if ((int) $reserva->quadra->arenas_id !== (int) $arenaId) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pendente', 'confirmada', 'concluida', 'cancelada'])],
            'alteradas_por' => ['sometimes', 'nullable', 'exists:usuarios,id'],
        ]);

        $validated['alteradas_por'] = $validated['alteradas_por'] ?? $userId;

        $reserva->update($validated);

        return response()->json($reserva);
    }


    public function quadrasDisponiveis()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $arena = $user->arena()->first();
        $arenaId = $arena?->id;
        if (!$arenaId) {
            return response()->json(['message' => 'Usuário sem arena vinculada'], 403);
        }

        $quadras = Quadra::where('arenas_id', $arenaId)
            ->where('ativa', 1)
            ->get();

        return response()->json($quadras);
    }


    public function horariosDisponiveis($id)
    {
        $horarios = [
            '08:00', '09:00', '10:00', '11:00',
            '14:00', '15:00', '16:00', '17:00',
            '18:00', '19:00', '20:00', '21:00',
        ];

        return response()->json($horarios);
    }

    public function minhasReservas()
    {
        return response()->json([]);
    }


    // CANCELAR RESERVA
    public function cancelar(Request $request, $id)
    {
        $reserva = Reserva::with('quadra')->findOrFail($id);

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $arenaId = auth()->user()->arena()->first()?->id;
        if (!$arenaId) {
            return response()->json(['message' => 'Usuário sem arena vinculada'], 403);
        }

        if ((int) $reserva->quadra->arenas_id !== (int) $arenaId) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $validated = $request->validate([
            'observacao' => ['nullable', 'string'],
        ]);

        $reserva->update([
            'status' => 'cancelada',
            'cancelados_por' => $userId,
            'cancelada_em' => now(),
            'observacao' => $validated['observacao'] ?? $reserva->observacao,
        ]);

        return response()->json($reserva);
    }
}

