<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Carbon\Carbon;

class AgendaController extends Controller
{
    // RF11 - Ver agenda geral
    public function index() 
    { 
        $agendas = Reserva::whereIn('status', ['agendada', 'confirmada'])
            ->with(['usuario:id,nome', 'quadra:id,nome'])
            ->orderBy('data')
            ->orderBy('hora_inicio')
            ->get();
            
        return response()->json($agendas, 200); 
    }
    
    // Agenda do dia
    public function dia() 
    { 
        $agendas = Reserva::whereDate('data', Carbon::today())
            ->whereIn('status', ['agendada', 'confirmada'])
            ->with(['usuario:id,nome,telefone', 'quadra:id,nome'])
            ->orderBy('hora_inicio')
            ->get();
            
        return response()->json($agendas, 200); 
    }
    
    // Agenda da semana
    public function semana() 
    { 
        $agendas = Reserva::whereBetween('data', [
                Carbon::now()->startOfWeek(), 
                Carbon::now()->endOfWeek()
            ])
            ->whereIn('status', ['agendada', 'confirmada'])
            ->with(['usuario:id,nome', 'quadra:id,nome'])
            ->orderBy('data')
            ->orderBy('hora_inicio')
            ->get();
            
        return response()->json($agendas, 200); 
    }
}