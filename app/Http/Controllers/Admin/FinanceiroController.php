<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function historico() { 
        return response()->json(['message' => ' Histórico financeiro'], 200); 
    }
    public function fluxoCaixa() { 
        return response()->json(['message' => ' Fluxo de caixa'], 200); 
    }
}
