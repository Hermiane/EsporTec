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
            'usuario_id' => ['required', 'exists:usuarios,id'],
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

        $reserva = Reserva::create($validated);

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
        $quadras = \App\Models\Quadra::where('ativa', 1)->get();
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