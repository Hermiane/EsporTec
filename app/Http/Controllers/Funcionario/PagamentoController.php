<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function confirmar($id)
    {
      $pagamento = Pagamento::with('reserva')->findOrFail($id);
      if($pagamento->status != 'pendente') {
          return response()->json(['message' => 'Pagamento já foi confirmado.'], 400);
      }
      if (auth()->user()->arena_id != $pagamento->reserva->arena_id) {
          return response()->json(['message' => 'Não autorizado'], 403);
      }

     // Valida se o admin é da mesma arena
     if (auth()->user()->arena_id != $pagamento->reserva->arena_id) {
        return response()->json(['message' => 'Não autorizado'], 403);
     }

     $pagamento->update([
        'status' => 'confirmado', // troquei de 'pago' pra 'confirmado'
        'pago_em' => now(),
        'confirmado_por' => auth()->id() // corrigi: era confirmados_por
     ]);

     // Atualiza a reserva também
     $pagamento->reserva->update(['status' => 'confirmada']);

     return response()->json([
        'message' => 'Pagamento confirmado no local',
        'data' => $pagamento->load('reserva', 'confirmadoPor')
     ], 200);
    }

    public function recusar(Request $request, $id)
    {
     $pagamento = Pagamento::with('reserva')->findOrFail($id);

     // Valida se o admin é da mesma arena
     if (auth()->user()->arena_id != $pagamento->reserva->arena_id) {
        return response()->json(['message' => 'Não autorizado'], 403);
     }

     $pagamento->update([
        'status' => 'recusado',
        'confirmado_por' => auth()->id(), // registra quem recusou
        'motivo_recusa' => $request->motivo ?? null // opcional
     ]);

     // Cancela a reserva e libera o horário
     $pagamento->reserva->update(['status' => 'cancelada']);

     return response()->json([
        'message' => 'Pagamento recusado. Horário liberado.',
        'data' => $pagamento->load('reserva')
     ], 200);
    }

    
    
    public function pendentes() 
    { 
        $pendentes = Pagamento::where('status', 'pendente')
            ->with(['reserva.usuario', 'reserva.quadra'])
            ->get();
            
        return response()->json($pendentes, 200); 
    }
    
    // Bônus: listar todos os pagamentos de uma reserva
    public function porReserva($reserva_id)
    {
        $pagamentos = Pagamento::where('reservas_id', $reserva_id)->get();
        return response()->json($pagamentos, 200);
    }
}
