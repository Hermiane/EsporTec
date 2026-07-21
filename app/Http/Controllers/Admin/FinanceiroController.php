<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\Despesa;
use App\Models\Pagamento;
use App\Support\ArenaAuthorization;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    use ArenaAuthorization;

    public function fluxoCaixa(Request $request)
    {
        $d = $request->validate(['arenas_id' => ['required', 'exists:arenas,id'], 'inicio' => ['nullable', 'date'], 'fim' => ['nullable', 'date']]);
        $this->autorizarArena($request, (int) $d['arenas_id']);
        $inicio = $d['inicio'] ?? now()->startOfMonth(); $fim = $d['fim'] ?? now()->endOfMonth();
        $naArena = fn ($q) => $q->where('arenas_id', $d['arenas_id']);
        $entradas = Pagamento::where('status', 'pago')->whereHas('reserva.quadra', $naArena)->whereBetween('pago_em', [$inicio, $fim])->sum('valor');
        $reembolsos = Pagamento::where('status', 'estornado')->where('tipo', 'reembolso')->whereHas('reserva.quadra', $naArena)->whereBetween('pago_em', [$inicio, $fim])->sum('valor');
        $despesas = Despesa::where('arenas_id', $d['arenas_id'])->whereBetween('data_despesas', [$inicio, $fim])->sum('valor');
        return response()->json(compact('inicio', 'fim', 'entradas', 'reembolsos', 'despesas') + ['resultado_liquido' => (float) $entradas - (float) $reembolsos - (float) $despesas]);
    }

    public function resumo(Request $request)
    {
        $ids = $this->arenaIdsPermitidos($request); $arenaId = $request->integer('arena_id') ?: ($ids[0] ?? null);
        abort_unless($arenaId, 422, 'Nenhuma arena vinculada à conta.'); $this->autorizarArena($request, $arenaId);
        $inicio = $request->filled('mes') ? now()->parse($request->input('mes').'-01')->startOfMonth() : now()->startOfMonth(); $fim = (clone $inicio)->endOfMonth();
        $entradas = (float) Pagamento::where('status', 'pago')->whereBetween('pago_em', [$inicio, $fim])->whereHas('reserva.quadra', fn ($q) => $q->where('arenas_id', $arenaId))->sum('valor');
        $despesas = Despesa::where('arenas_id', $arenaId)->whereBetween('data_despesas', [$inicio, $fim])->get(); $saidas = (float) $despesas->sum('valor');
        return response()->json(['stats' => ['entradas' => $entradas, 'saidas' => $saidas, 'saldo' => $entradas - $saidas, 'margem' => $entradas > 0 ? round((($entradas - $saidas) / $entradas) * 100, 1) : 0, 'entradas_variacao' => 0, 'saidas_variacao' => 0, 'melhor_semana' => '-', 'maior_entrada' => $entradas], 'grafico_semanal' => ['labels' => ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'], 'entradas' => [0, 0, 0, 0], 'saidas' => [0, 0, 0, 0]], 'grafico_categorias' => ['labels' => $despesas->groupBy('categoria')->keys()->values(), 'values' => $despesas->groupBy('categoria')->map(fn ($itens) => (float) $itens->sum('valor'))->values(), 'colors' => ['#2D815D', '#1F5C42', '#94A3B8', '#CBD5E1']], 'despesas_recentes' => $despesas->sortByDesc('data_despesas')->take(10)->values()]);
    }

    public function despesas(Request $request)
    {
        $d = $request->validate(['arenas_id' => ['required', 'exists:arenas,id']]);
        $this->autorizarArena($request, (int) $d['arenas_id']);
        return response()->json(Despesa::where('arenas_id', $d['arenas_id'])->paginate(20));
    }

    public function registrarDespesa(Request $request)
    {
        $d = $request->validate(['arenas_id' => ['required', 'exists:arenas,id'], 'descricao' => ['required', 'string'], 'categoria' => ['required', 'in:salario,manutencao,conta,marketing,equipamento,outros'], 'valor' => ['required', 'numeric', 'min:0'], 'data_despesas' => ['required', 'date'], 'semana_do_mes' => ['required', 'integer', 'between:1,5'], 'recorrente' => ['boolean'], 'recorrencia' => ['nullable', 'in:diaria,semanal,mensal,anual'], 'observacao' => ['required', 'string']]);
        $this->autorizarArena($request, (int) $d['arenas_id']);
        return response()->json(Despesa::create($d + ['registrado_por' => $request->user()->id]), 201);
    }

    public function politica(Request $request)
    {
        $d = $request->validate(['arenas_id' => ['required', 'exists:arenas,id'], 'adiantamento_ativo' => ['required', 'boolean'], 'adiantamento_percentual' => ['nullable', 'numeric', 'between:0,100'], 'adiantamento_valor_minimo' => ['nullable', 'numeric', 'min:0'], 'cancelamento_horas' => ['nullable', 'integer', 'min:0'], 'cancelamento_retencao_percentual' => ['nullable', 'numeric', 'between:0,100']]);
        $this->autorizarArena($request, (int) $d['arenas_id']);
        foreach (collect($d)->except('arenas_id') as $chave => $valor) Configuracao::updateOrCreate(['arenas_id' => $d['arenas_id'], 'chave' => $chave], ['valor' => (string) $valor, 'descricao' => 'Política financeira da arena']);
        return response()->json(['message' => 'Política atualizada.']);
    }
}
