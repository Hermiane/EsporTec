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
        $pagamento = Pagamento::findOrFail($id);
        
        $pagamento->update([
            'status' => 'pago',
            'pago_em' => now(),
            'confirmados_por' => Auth::id() // pega o id do funcionário logado
        ]);
        
        return response()->json([
            'message' => 'Pagamento confirmado no local', 
            'data' => $pagamento->load('reserva', 'confirmadoPor')
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
        $pagamentos = Pagamento::where('reserva_id', $reserva_id)->get();
        return response()->json($pagamentos, 200);
    }
}