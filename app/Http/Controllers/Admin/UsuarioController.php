<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index() { return response()->json(['message' => ' Listar funcionários/administradores'], 200); }
    public function store(Request $request) { return response()->json(['message' => ' Criar funcionário/administrador'], 200); }
    public function update(Request $request, $id) { return response()->json(['message' => ' Alterar funcionário/administrador'], 200); }
    public function inativar($id) { return response()->json(['message' => ' Inativar funcionário/administrador'], 200); }
}
