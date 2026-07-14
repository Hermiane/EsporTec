<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index() { return response()->json(['message' => ' Listar clientes'], 200); }
    public function show($id) { return response()->json(['message' => ' Detalhes do cliente'], 200); }
    
}
