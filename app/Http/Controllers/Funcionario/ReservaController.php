<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    // RF13 - Modificar horário
    public function updateHorario(Request $request, $id) 
    { 
        $request->validate([
            'data' => 'sometimes|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio'
        ]);
        
        $reserva = Reserva::findOrFail($id);
        
        $reserva->update([
            'data' => $request->data ?? $reserva->data,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'alteradas_por' => Auth::id() // ID do funcionário logado
        ]);
        
        return response()->json([
            'message' => 'Horário modificado com sucesso', 
            'data' => $reserva->load(['usuario', 'quadra'])
        ], 200); 
    }
    
    // RF13 - Cancelar reserva
    public function cancelar(Request $request, $id) 
    { 
        $reserva = Reserva::findOrFail($id);
        
        $reserva->update([
            'status' => 'cancelada',
            'cancelada_em' => now(),
            'cancelados_por' => Auth::id(),
            'observacao' => $request->motivo ?? 'Cancelada a pedido do cliente'
        ]);
        
        return response()->json([
            'message' => 'Reserva cancelada', 
            'data' => $reserva
        ], 200); 
    }
    
    // Bônus: Confirmar reserva
    public function confirmar($id)
    {
        $reserva = Reserva::findOrFail($id);
        
        $reserva->update([
            'status' => 'confirmada',
        ]);
        
        return response()->json(['message' => 'Reserva confirmada', 'data' => $reserva], 200);
    }
}