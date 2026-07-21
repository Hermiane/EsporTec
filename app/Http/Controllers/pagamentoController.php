<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Configuracao;
use App\Models\Reserva;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagamentoController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reserva_id' => ['required', 'exists:reservas,id'],
            'valor' => ['required', 'numeric', 'min:0'],
            'metodo' => ['required', 'in:dinheiro,pix,cartao_credito,cartao_debito'],
            'pix_copia_cola' => ['required_if:metodo,pix', 'string'],
            'comprovante' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $reserva = Reserva::with('quadra')->findOrFail($validated['reserva_id']);
        $this->authorize('create', [Pagamento::class, $reserva]);
        if ($reserva->status !== 'pendente') {
            return response()->json(['message' => 'Apenas reservas pendentes podem receber pagamento'], 422);
        }

        if ($request->hasFile('comprovante')) {
            $validated['comprovante'] = $request->file('comprovante')->store('comprovantes', 'public');
        }

        $pagamento = DB::transaction(function () use ($validated, $reserva) {
            $pago = Pagamento::where('reservas_id', $reserva->id)->where('status', 'pago')->sum('valor');
            $restante = max(0, (float) $reserva->valor_total - (float) $pago);
            abort_if($restante <= 0, 422, 'Esta reserva já está quitada.');
            $config = Configuracao::where('arenas_id', $reserva->quadra->arenas_id)->whereIn('chave', ['adiantamento_ativo', 'adiantamento_percentual', 'adiantamento_valor_minimo'])->pluck('valor', 'chave');
            $adiantamentoAtivo = filter_var($config->get('adiantamento_ativo', false), FILTER_VALIDATE_BOOLEAN);
            $percentual = (float) $config->get('adiantamento_percentual', 50);
            $minimo = (float) $config->get('adiantamento_valor_minimo', 40);
            $valorEsperado = $pago == 0 && $adiantamentoAtivo ? min($restante, max((float) $reserva->valor_total * $percentual / 100, $minimo)) : $restante;
            abort_unless(round((float) $validated['valor'], 2) === round($valorEsperado, 2), 422, 'Valor do pagamento não corresponde à política da arena.');

            return Pagamento::create([
                'reservas_id' => $validated['reserva_id'],
                'valor' => $validated['valor'],
                'metodo' => $validated['metodo'],
                'pix_copia_cola' => $validated['pix_copia_cola'] ?? null,
                'comprovante' => $validated['comprovante'] ?? null,
                'status' => 'pendente',
                'tipo' => $pago == 0 && $adiantamentoAtivo ? 'adiantamento' : ($pago == 0 ? 'integral' : 'saldo'),
            ]);
        });

        return response()->json($pagamento, 201);
    }

    public function confirmar(Request $request, $id)
    {
        $pagamento = Pagamento::with('reserva.quadra')->findOrFail($id);
        $this->authorize('confirmar', $pagamento);
        if ($pagamento->status !== 'pendente') {
            return response()->json(['message' => 'Apenas pagamentos pendentes podem ser confirmados'], 422);
        }

        return DB::transaction(function () use ($pagamento) {
            $pagamento->update([
                'status' => 'pago',
                'confirmados_por' => auth()->id(),
                'pago_em' => now(),
            ]);

            $pagamento->reserva()->update(['status' => 'confirmada']);

            return response()->json($pagamento->fresh(['reserva', 'confirmadoPor']));
        });
    }

    public function recusar(Request $request, $id)
    {
        $pagamento = Pagamento::with('reserva.quadra')->findOrFail($id);
        $this->authorize('confirmar', $pagamento);
        if ($pagamento->status !== 'pendente') {
            return response()->json(['message' => 'Apenas pagamentos pendentes podem ser recusados'], 422);
        }

        $pagamento->update([
            'status' => 'recusado',
            'confirmados_por' => null,
            'pago_em' => null,
        ]);

        return response()->json($pagamento->fresh('reserva'));
    }

    public function pendentes()
    {
        $this->authorize('viewAny', Pagamento::class);

        $user = auth()->user();
        $query = Pagamento::where('status', 'pendente')
            ->with(['reserva.usuario', 'reserva.quadra.arena']);

        if (!$user->superAdmin()->where('ativo', true)->exists()) {
            $query->whereHas('reserva.quadra', function ($quadras) use ($user) {
                $quadras->whereIn('arenas_id', function ($arenaIds) use ($user) {
                    $arenaIds->select('arenas_id')
                        ->from('admins_arenas')
                        ->where('usuarios_id', $user->id)
                        ->where('ativo', true)
                        ->union(
                            DB::table('funcionarios_arenas')
                                ->select('arenas_id')
                                ->where('usuarios_id', $user->id)
                                ->where('ativo', true)
                        );
                });
            });
        }

        return response()->json($query->get());
    }

    public function index()
    {
        $pagamentos = Pagamento::whereHas('reserva', function ($reservas) {
            $reservas->where('reservas_usuarios_id', auth()->id());
        })->with('reserva')->get();

        return response()->json($pagamentos);
    }

    public function porReserva($reservaId)
    {
        $reserva = Reserva::findOrFail($reservaId);
        $this->authorize('view', $reserva);

        return response()->json(Pagamento::where('reservas_id', $reservaId)->get());
    }
}
