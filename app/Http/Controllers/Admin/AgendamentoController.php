<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index() { return response()->json(['message' => ' Listar agendamentos'], 200); }
    public function store(Request $request) { return response()->json(['message' => ' Criar agendamento'], 200); }
    public function update(Request $request, $id) { return response()->json(['message' => ' Alterar agendamento'], 200); }
    public function confirmar($id) { return response()->json(['message' => ' Confirmar agendamento'], 200); }
    public function cancelar($id) { return response()->json(['message' => ' Cancelar agendamento'], 200); }
}
