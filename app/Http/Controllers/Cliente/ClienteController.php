<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ClienteController extends Controller
{
    // CADASTRO AUTÔNOMO
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_completo' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'email' => ['required', 'email', 'unique:clientes,email'],
            'telefone' => ['required', 'string', 'max:20'],
            'endereco' => ['required', 'string'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $cliente = Cliente::create($validated);

        return response()->json($cliente, 201);
    }

    // HISTÓRICO: AGENDAMENTOS PASSADOS E FUTUROS
    public function historico($id)
    {
        $cliente = Cliente::findOrFail($id);
        
        $reservas = $cliente->reservas()
            ->orderBy('data', 'desc')
            ->get()
            ->groupBy(function($reserva) {
                return $reserva->data >= now()->toDateString() ? 'futuras' : 'passadas';
            });

        return response()->json($reservas);
    }
}
