<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Pagamento;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PagamentoController extends Controller
{
    // CRIAR PAGAMENTO - Via pix ou cartão
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reserva_id' => ['required', 'exists:reservas,id'],
            'metodo' => ['required', Rule::in(['dinheiro', 'pix', 'cartao_credito', 'cartao_debito'])],
            'valor' => ['required', 'numeric', 'min:0'],
            'pix_copia_cola' => ['required_if:metodo,pix', 'string', 'nullable'],
            'comprovante' => ['nullable', 'image', 'max:2048'],
        ]);

        // Sempre começa pendente
        $validated['status'] = 'pendente';

        // Se enviou comprovante, salva o arquivo
        if ($request->hasFile('comprovante')) {
            $path = $request->file('comprovante')->store('comprovantes', 'public');
            $validated['comprovante'] = $path;
        }

        // (Opcional) evita duplicidade para a mesma reserva: Pagamento é 1:1 pela model
        $existente = Pagamento::where('reserva_id', $validated['reserva_id'])->first();
        if ($existente) {
            return response()->json([
                'message' => 'Esta reserva já possui um pagamento.'
            ], 409);
        }

        // Ajusta chave do model (reserva_id no request -> reservas_id no banco/model)
        $validated['reservas_id'] = $validated['reserva_id'];
        unset($validated['reserva_id']);

        $pagamento = Pagamento::create($validated);

        return response()->json($pagamento, 201);
    }

    // CONFIRMAR PAGAMENTO - Só admin/funcionário faz isso
    public function updateStatus(Request $request, $id)
    {
        $pagamento = Pagamento::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pago', 'pendente'])],
            'confirmados_por' => ['required_if:status,pago', 'nullable', 'exists:usuarios,id'],
        ]);

        if ($validated['status'] === 'pago') {
            $validated['pago_em'] = now();
        }

        if ($validated['status'] === 'pendente') {
            $validated['pago_em'] = null;
            $validated['confirmados_por'] = null;
        }

        $pagamento->update($validated);

        return response()->json($pagamento);
    }

    // LISTAR PAGAMENTOS DE UMA RESERVA
    public function porReserva($reserva_id)
    {
        $pagamentos = Pagamento::where('reserva_id', $reserva_id)->get();
        return response()->json($pagamentos);
    }
}

