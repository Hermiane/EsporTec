<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloqueioQuadra;
use App\Models\HorarioFuncionamento;
use App\Models\Pagamento;
use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\SuperAdmin;
use App\Models\Usuario;
use App\Support\ArenaAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    use ArenaAuthorization;

    public function dashboard(Request $request)
    {
        $d = $request->validate(['arena_id' => ['nullable', 'exists:arenas,id']]);
        $superAdmin = $this->isSuperAdmin($request);
        $arenaIds = isset($d['arena_id']) ? [(int) $d['arena_id']] : $this->arenaIdsPermitidos($request);
        if (isset($d['arena_id'])) $this->autorizarArena($request, (int) $d['arena_id']);

        $quadras = Quadra::query()->when(!$superAdmin || isset($d['arena_id']), fn ($q) => $q->whereIn('arenas_id', $arenaIds));
        $quadraIds = (clone $quadras)->pluck('id');
        $reservas = Reserva::whereIn('quadras_id', $quadraIds);
        $pagamentos = Pagamento::whereHas('reserva', fn ($q) => $q->whereIn('quadras_id', $quadraIds));
        $clientesIds = (clone $reservas)->distinct()->pluck('reservas_usuarios_id');
        $inicioMes = now()->startOfMonth(); $fimMes = now()->endOfMonth();
        $inicioAnterior = now()->subMonthNoOverflow()->startOfMonth(); $fimAnterior = now()->subMonthNoOverflow()->endOfMonth();
        $receitaMes = (float) (clone $pagamentos)->where('status', 'pago')->whereBetween('pago_em', [$inicioMes, $fimMes])->sum('valor');
        $receitaAnterior = (float) (clone $pagamentos)->where('status', 'pago')->whereBetween('pago_em', [$inicioAnterior, $fimAnterior])->sum('valor');
        $variacao = $receitaAnterior > 0 ? round((($receitaMes - $receitaAnterior) / $receitaAnterior) * 100, 1) : null;

        $proximas = (clone $reservas)->with(['quadra:id,nome', 'usuario:id,nome_completo'])->whereDate('data', '>=', today())->whereIn('status', ['pendente', 'confirmada'])->orderBy('data')->orderBy('hora_inicio')->limit(5)->get();
        $atividades = collect()
            ->merge((clone $reservas)->with(['usuario:id,nome_completo', 'quadra:id,nome'])->latest()->limit(5)->get()->map(fn ($r) => ['tipo' => 'reserva', 'texto' => "Reserva {$r->status}", 'detalhe' => $r->usuario?->nome_completo, 'data' => $r->updated_at, 'icone' => 'bi-calendar-check', 'cor' => '#DBEAFE', 'cor_texto' => '#2563EB']))
            ->merge((clone $pagamentos)->with('reserva.quadra:id,nome')->where('status', 'pago')->latest('pago_em')->limit(5)->get()->map(fn ($p) => ['tipo' => 'pagamento', 'texto' => 'Pagamento confirmado', 'detalhe' => 'R$ '.number_format((float) $p->valor, 2, ',', '.'), 'data' => $p->pago_em ?? $p->updated_at, 'icone' => 'bi-cash-stack', 'cor' => '#D1FAE5', 'cor_texto' => '#059669']))
            ->sortByDesc('data')->take(5)->values();

        return response()->json([
            'stats' => ['reservas_hoje' => (clone $reservas)->whereDate('data', today())->count(), 'reservas_confirmadas' => (clone $reservas)->whereDate('data', today())->where('status', 'confirmada')->count(), 'receita_mes' => $receitaMes, 'receita_variacao' => $variacao, 'total_clientes' => $clientesIds->count(), 'clientes_novos_semana' => Usuario::whereIn('id', $clientesIds)->where('created_at', '>=', now()->subWeek())->count(), 'pendentes' => (clone $reservas)->where('status', 'pendente')->count()],
            'arenas' => \App\Models\Arena::when(!$superAdmin, fn ($q) => $q->whereIn('id', $arenaIds))->where('ativo', true)->get(['id', 'nome']),
            'proximas_reservas' => $proximas,
            'atividades' => $atividades,
        ]);
    }

    public function promoverAdmin(Request $request, $id)
    {
        abort_unless($this->isSuperAdmin($request), 403, 'Apenas superadministradores podem promover usuários.');
        $d = $request->validate(['cargo' => ['required', 'string'], 'motivo' => ['nullable', 'string']]);
        $usuario = Usuario::findOrFail($id);
        abort_if($usuario->superAdmin, 422, 'Usuário já é superadministrador.');
        SuperAdmin::create(['usuarios_id' => $usuario->id, 'cargo' => $d['cargo'], 'motivo' => $d['motivo'] ?? null, 'ativo' => true, 'criado_por' => $request->user()->id]);
        return response()->json(['message' => 'Usuário promovido a superadministrador.']);
    }

    public function toggleAtivo(Request $request, $id)
    {
        abort_unless($this->isSuperAdmin($request), 403, 'Apenas superadministradores podem alterar contas globais.');
        $usuario = Usuario::findOrFail($id); $usuario->update(['ativo' => !$usuario->ativo]);
        return response()->json(['message' => $usuario->ativo ? 'Usuário ativado.' : 'Usuário inativado.']);
    }

    public function listarQuadras(Request $request)
    {
        $ids = $this->arenaIdsPermitidos($request);
        return response()->json(Quadra::with('arena')->when(!$this->isSuperAdmin($request), fn ($q) => $q->whereIn('arenas_id', $ids))->get());
    }

    public function storeQuadra(Request $request)
    {
        $d = $request->validate(['arenas_id' => ['nullable', 'exists:arenas,id'], 'nome' => ['required', 'string', 'max:255'], 'descricao' => ['nullable', 'string'], 'tipo' => ['required', 'in:society,futsal,futebol,misto'], 'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], 'capacidade_jogador' => ['required', 'integer', 'min:1'], 'coberta' => ['required', 'boolean'], 'preco_hora' => ['required', 'numeric', 'min:0'], 'ativo' => ['boolean']]);
        $arenaPadrao = $this->arenaIdsPermitidos($request)[0] ?? null;
        $d['arenas_id'] = $d['arenas_id'] ?? $arenaPadrao; abort_unless($d['arenas_id'], 422, 'Nenhuma arena vinculada à conta.');
        $this->autorizarArena($request, (int) $d['arenas_id']);
        $d['descricao'] = $d['descricao'] ?? ''; $d['foto'] = $request->hasFile('foto') ? '/storage/'.$request->file('foto')->store('quadras', 'public') : 'https://via.placeholder.com/800x500?text=Quadra';
        return response()->json(['message' => 'Quadra criada.', 'data' => Quadra::create($d)], 201);
    }

    public function updateQuadra(Request $request, $id)
    {
        $quadra = Quadra::findOrFail($id); $this->autorizarArena($request, (int) $quadra->arenas_id);
        $d = $request->validate(['nome' => ['sometimes', 'string', 'max:255'], 'preco_hora' => ['sometimes', 'numeric', 'min:0'], 'ativo' => ['sometimes', 'boolean'], 'coberta' => ['sometimes', 'boolean'], 'capacidade_jogador' => ['sometimes', 'integer', 'min:1']]);
        $quadra->update($d); return response()->json(['message' => 'Quadra atualizada.', 'data' => $quadra->fresh()]);
    }

    public function horariosQuadra(Request $request, $id)
    {
        $quadra = Quadra::findOrFail($id);
        $this->autorizarArena($request, (int) $quadra->arenas_id);

        return response()->json(
            $quadra->horariosFuncionamento()->orderBy('id')->get(['id', 'dia_semana', 'hora_inicio', 'hora_fim', 'ativo']),
        );
    }

    public function salvarHorariosQuadra(Request $request, $id)
    {
        $quadra = Quadra::findOrFail($id);
        $this->autorizarArena($request, (int) $quadra->arenas_id);

        $dados = $request->validate([
            'horarios' => ['required', 'array', 'size:7'],
            'horarios.*.dia_semana' => ['required', 'in:segunda-feira,terca-feira,quarta-feira,quinta-feira,sexta-feira,sabado,domingo'],
            'horarios.*.ativo' => ['required', 'boolean'],
            'horarios.*.hora_inicio' => ['required', 'date_format:H:i'],
            'horarios.*.hora_fim' => ['required', 'date_format:H:i'],
        ]);

        foreach ($dados['horarios'] as $horario) {
            abort_if($horario['ativo'] && $horario['hora_inicio'] >= $horario['hora_fim'], 422, 'O horário inicial deve ser anterior ao final.');

            HorarioFuncionamento::updateOrCreate(
                ['quadras_id' => $quadra->id, 'dia_semana' => $horario['dia_semana']],
                [
                    'hora_inicio' => $horario['hora_inicio'],
                    'hora_fim' => $horario['hora_fim'],
                    'ativo' => $horario['ativo'],
                ],
            );
        }

        return response()->json(['message' => 'Horários da quadra atualizados.']);
    }

    public function bloqueiosQuadras(Request $request)
    {
        $arenaIds = $this->arenaIdsPermitidos($request);

        return response()->json(
            BloqueioQuadra::with('quadra:id,nome,arenas_id')
                ->whereHas('quadra', fn ($query) => $query->whereIn('arenas_id', $arenaIds))
                ->orderByDesc('data')->orderBy('hora_inicio')->get(),
        );
    }

    public function salvarBloqueioQuadra(Request $request)
    {
        $dados = $request->validate([
            'quadras_id' => ['required', 'exists:quadras,id'],
            'data' => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['nullable', 'date_format:H:i'],
            'hora_fim' => ['nullable', 'date_format:H:i'],
            'motivo' => ['nullable', 'string', 'max:500'],
        ]);

        $quadra = Quadra::findOrFail($dados['quadras_id']);
        $this->autorizarArena($request, (int) $quadra->arenas_id);
        $inicio = $dados['hora_inicio'] ?? '00:00';
        $fim = $dados['hora_fim'] ?? '23:59';
        abort_if($inicio >= $fim, 422, 'O horário inicial deve ser anterior ao final.');

        $bloqueio = BloqueioQuadra::create([
            'quadras_id' => $quadra->id,
            'criado_por' => $request->user()->id,
            'data' => $dados['data'],
            'hora_inicio' => $inicio,
            'hora_fim' => $fim,
            'motivo' => $dados['motivo'] ?? 'Bloqueio operacional',
            'tipo' => 'outros',
        ]);

        return response()->json(['message' => 'Bloqueio registrado.', 'data' => $bloqueio->load('quadra:id,nome')], 201);
    }

    public function excluirBloqueioQuadra(Request $request, $id)
    {
        $bloqueio = BloqueioQuadra::with('quadra')->findOrFail($id);
        $this->autorizarArena($request, (int) $bloqueio->quadra->arenas_id);
        $bloqueio->delete();

        return response()->json(['message' => 'Bloqueio removido.']);
    }

    public function relatorioFinanceiro(Request $request)
    {
        $d = $request->validate(['data_inicio' => ['nullable', 'date'], 'data_fim' => ['nullable', 'date']]);
        $ids = $this->arenaIdsPermitidos($request); $inicio = $d['data_inicio'] ?? now()->startOfMonth(); $fim = $d['data_fim'] ?? now()->endOfMonth();
        $pagamentos = Pagamento::where('status', 'pago')->whereBetween('pago_em', [$inicio, $fim])->whereHas('reserva.quadra', fn ($q) => $q->when(!$this->isSuperAdmin($request), fn ($q) => $q->whereIn('arenas_id', $ids)))->with(['reserva.quadra:id,nome,preco_hora', 'reserva.usuario:id,nome_completo'])->get();
        return response()->json(['periodo' => ['inicio' => $inicio, 'fim' => $fim], 'total_geral' => $pagamentos->sum('valor'), 'qtd_pagamentos' => $pagamentos->count(), 'faturamento_por_quadra' => $pagamentos->groupBy('reserva.quadra.nome')->map(fn ($itens) => ['total' => $itens->sum('valor'), 'qtd_reservas' => $itens->count()]), 'pagamentos' => $pagamentos]);
    }

    public function todasReservas(Request $request)
    {
        $d = $request->validate(['status' => ['nullable', 'string'], 'data_inicio' => ['nullable', 'date']]); $ids = $this->arenaIdsPermitidos($request);
        $reservas = Reserva::with(['usuario:id,nome_completo,email,telefone', 'quadra:id,nome,preco_hora,coberta,arenas_id', 'pagamento'])->whereHas('quadra', fn ($q) => $q->when(!$this->isSuperAdmin($request), fn ($q) => $q->whereIn('arenas_id', $ids)))->when($d['status'] ?? null, fn ($q, $status) => $q->where('status', $status))->when($d['data_inicio'] ?? null, fn ($q, $data) => $q->whereDate('data', '>=', $data))->orderByDesc('data')->orderByDesc('hora_inicio')->paginate(20);
        return response()->json($reservas);
    }

    public function agendamentos(Request $request)
    {
        $ids = $this->arenaIdsPermitidos($request);
        return response()->json(Reserva::with(['usuario:id,nome_completo,telefone', 'quadra:id,nome,arenas_id', 'pagamento'])->whereHas('quadra', fn ($q) => $q->when(!$this->isSuperAdmin($request), fn ($q) => $q->whereIn('arenas_id', $ids)))->orderByDesc('data')->orderByDesc('hora_inicio')->get());
    }

    public function confirmarReserva(Request $request, $id)
    {
        $reserva = Reserva::with('quadra')->findOrFail($id);
        $this->autorizarArena($request, (int) $reserva->quadra->arenas_id);

        abort_unless($reserva->status === 'pendente', 422, 'Apenas reservas pendentes podem ser confirmadas.');

        $reserva->update([
            'status' => 'confirmada',
            'alteradas_por' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Reserva confirmada. O pagamento permanece pendente até ser realizado.',
            'data' => $reserva->fresh(['pagamento', 'quadra']),
        ]);
    }
}
