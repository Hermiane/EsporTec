<?php

namespace App\Http\Controllers;

use App\Models\AdminArena;
use App\Models\BloqueioQuadra;
use App\Models\Configuracao;
use App\Models\Feedback;
use App\Models\FuncionarioArena;
use App\Models\Pagamento;
use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quadra_id' => ['required', 'exists:quadras,id'],
            'data' => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'valor_total' => ['required', 'numeric', 'min:0'],
            'quantidade_jogadores' => ['required', 'integer', 'min:1'],
            'observacao' => ['nullable', 'string'],
        ]);
        $userId = $this->usuarioAutenticado()->id;

        $quadra = Quadra::with('horariosFuncionamento')->findOrFail($validated['quadra_id']);
        if (!$quadra->ativo) {
            return response()->json(['message' => 'Quadra inativa'], 403);
        }
        if ($validated['quantidade_jogadores'] > $quadra->capacidade_jogador) {
            return response()->json([
                'message' => "A quantidade máxima para esta quadra é de {$quadra->capacidade_jogador} jogadores.",
            ], 422);
        }

        if (!$this->estaNoHorarioFuncionamento($quadra, $validated['data'], $validated['hora_inicio'], $validated['hora_fim'])) {
            return response()->json(['message' => 'Horário fora do funcionamento da quadra'], 422);
        }

        $reserva = DB::transaction(function () use ($validated, $userId) {
                // Serializa reservas da mesma quadra, inclusive quando ainda não há conflito gravado.
                Quadra::whereKey($validated['quadra_id'])->lockForUpdate()->firstOrFail();
                $hasConflitoReserva = Reserva::where('quadras_id', $validated['quadra_id'])
                    ->where('data', $validated['data'])
                    ->whereIn('status', ['pendente', 'confirmada'])
                    ->where('hora_inicio', '<', $validated['hora_fim'])
                    ->where('hora_fim', '>', $validated['hora_inicio'])
                    ->lockForUpdate()
                    ->exists();

                $hasBloqueio = BloqueioQuadra::where('quadras_id', $validated['quadra_id'])
                    ->where('data', $validated['data'])
                    ->where('hora_inicio', '<', $validated['hora_fim'])
                    ->where('hora_fim', '>', $validated['hora_inicio'])
                    ->lockForUpdate()
                    ->exists();

                if ($hasConflitoReserva || $hasBloqueio) {
                    abort(409, 'Horário indisponível.');
                }

                return Reserva::create([
                    'reservas_usuarios_id' => $userId,
                    'quadras_id' => $validated['quadra_id'],
                    'data' => $validated['data'],
                    'hora_inicio' => $validated['hora_inicio'],
                    'hora_fim' => $validated['hora_fim'],
                    'valor_total' => $validated['valor_total'],
                    'quantidade_jogadores' => $validated['quantidade_jogadores'],
                    'status' => 'pendente',
                    'observacao' => $validated['observacao'] ?? null,
                    'alteradas_por' => $userId,
                ]);
            });

        return response()->json($reserva, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $reserva = Reserva::with('quadra')->findOrFail($id);
        $userId = $this->usuarioAutenticado()->id;
        if (!$this->podeGerirArena($userId, $reserva->quadra->arenas_id)) {
            abort(403, 'Não autorizado.');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['concluida', 'cancelada'])],
        ]);

        if ($validated['status'] === 'concluida' && $reserva->status !== 'confirmada') {
            return response()->json(['message' => 'Apenas reservas confirmadas podem ser concluídas'], 422);
        }

        if ($validated['status'] === 'cancelada' && !in_array($reserva->status, ['pendente', 'confirmada'], true)) {
            return response()->json(['message' => 'Esta reserva não pode ser cancelada'], 422);
        }

        $data = ['status' => $validated['status'], 'alteradas_por' => $userId];
        if ($validated['status'] === 'cancelada') {
            $data += ['cancelados_por' => $userId, 'cancelada_em' => now()];
        }
        $reserva->update($data);

        return response()->json($reserva->fresh());
    }

    public function quadrasDisponiveis(Request $request)
    {
        $arenaId = $request->integer('arena');
        $busca = trim((string) $request->query('busca', ''));

        return response()->json(
            Quadra::with('arena')
                ->where('ativo', true)
                ->whereHas('arena', fn ($q) => $q->where('ativo', true)->where('status_aprovacao', 'aprovada'))
                ->when($arenaId, fn ($query) => $query->where('arenas_id', $arenaId))
                ->when($busca !== '', fn ($query) => $query->where(function ($filtro) use ($busca) {
                    $filtro->where('nome', 'like', "%{$busca}%")
                        ->orWhere('tipo', 'like', "%{$busca}%")
                        ->orWhereHas('arena', fn ($arena) => $arena->where('nome', 'like', "%{$busca}%"));
                }))
                ->orderBy('nome')
                ->get(),
        );
    }

    public function horariosDisponiveis(Request $request, $id)
    {
        $validated = $request->validate([
            'data' => ['required', 'date', 'after_or_equal:today'],
            'duracao' => ['nullable', 'integer', 'min:30', 'max:240'],
        ]);
        $duracao = $validated['duracao'] ?? 60;
        $quadra = Quadra::with('horariosFuncionamento')
            ->where('ativo', true)
            ->whereHas('arena', fn ($q) => $q->where('ativo', true)->where('status_aprovacao', 'aprovada'))
            ->findOrFail($id);
        $diaSemana = $this->diaSemana(Carbon::parse($validated['data']));
        $bloqueios = BloqueioQuadra::where('quadras_id', $quadra->id)->where('data', $validated['data'])->get();
        $reservas = Reserva::where('quadras_id', $quadra->id)->where('data', $validated['data'])
            ->whereIn('status', ['pendente', 'confirmada'])->get();

        $horarios = [];
        foreach ($quadra->horariosFuncionamento->where('dia_semana', $diaSemana)->where('ativo', true) as $funcionamento) {
            $inicio = Carbon::createFromFormat('H:i:s', $funcionamento->hora_inicio);
            $fim = Carbon::createFromFormat('H:i:s', $funcionamento->hora_fim);
            while ($inicio->copy()->addMinutes($duracao)->lte($fim)) {
                $termino = $inicio->copy()->addMinutes($duracao);
                $ocupado = $reservas->contains(fn ($reserva) => $reserva->hora_inicio < $termino->format('H:i:s') && $reserva->hora_fim > $inicio->format('H:i:s'))
                    || $bloqueios->contains(fn ($bloqueio) => $bloqueio->hora_inicio < $termino->format('H:i:s') && $bloqueio->hora_fim > $inicio->format('H:i:s'));
                if (!$ocupado) {
                    $horarios[] = $inicio->format('H:i');
                }
                $inicio->addMinutes($duracao);
            }
        }

        return response()->json([
            'horarios_disponiveis' => array_values(array_unique($horarios)),
            'bloqueios' => $bloqueios->map(fn ($bloqueio) => [
                'hora_inicio' => substr($bloqueio->hora_inicio, 0, 5),
                'hora_fim' => substr($bloqueio->hora_fim, 0, 5),
                'motivo' => $bloqueio->motivo,
            ])->values(),
        ]);
    }

    public function minhasReservas()
    {
        return response()->json(
            Reserva::where('reservas_usuarios_id', $this->usuarioAutenticado()->id)
                ->with(['quadra.arena', 'pagamento', 'partida', 'feedbacks'])
                ->orderByDesc('data')
                ->orderByDesc('hora_inicio')
                ->get()
        );
    }

    public function avaliar(Request $request, Reserva $reserva)
    {
        $usuario = $this->usuarioAutenticado();
        abort_unless($reserva->reservas_usuarios_id === $usuario->id, 403, 'Apenas o responsável pela reserva pode avaliá-la.');
        abort_unless($reserva->status === 'concluida', 422, 'A avaliação fica disponível após a conclusão da reserva.');

        $dados = $request->validate([
            'nota' => ['required', 'integer', 'between:1,5'],
            'comentario' => ['nullable', 'string', 'max:2000'],
        ]);

        $feedback = DB::transaction(function () use ($reserva, $usuario, $dados) {
            $reserva = Reserva::with('quadra')->lockForUpdate()->findOrFail($reserva->id);
            abort_if(
                Feedback::where('reservas_id', $reserva->id)->where('momento', 'pos_jogo')->exists(),
                422,
                'Esta reserva já foi avaliada.',
            );

            return Feedback::create([
                'reservas_id' => $reserva->id,
                'usuarios_id' => $usuario->id,
                'arenas_id' => $reserva->quadra->arenas_id,
                'momento' => 'pos_jogo',
                'nota' => $dados['nota'],
                'comentario' => $dados['comentario'] ?? null,
                'visivel' => true,
            ]);
        });

        return response()->json(['message' => 'Avaliação enviada com sucesso.', 'avaliacao' => $feedback], 201);
    }

    public function cancelar(Request $request, $id)
    {
        $reserva = Reserva::with('quadra')->findOrFail($id);
        $userId = $this->usuarioAutenticado()->id;
        $isOwner = $reserva->reservas_usuarios_id === $userId;
        if (!$isOwner && !$this->podeGerirArena($userId, $reserva->quadra->arenas_id)) {
            abort(403, 'Não autorizado.');
        }
        if (!in_array($reserva->status, ['pendente', 'confirmada'], true)) {
            return response()->json(['message' => 'Esta reserva não pode ser cancelada'], 422);
        }

        $validated = $request->validate(['observacao' => ['nullable', 'string']]);
        $resultado = DB::transaction(function () use ($reserva, $userId, $validated) {
            $config = Configuracao::where('arenas_id', $reserva->quadra->arenas_id)
                ->whereIn('chave', ['cancelamento_horas', 'cancelamento_retencao_percentual'])
                ->pluck('valor', 'chave');
            $limite = (int) $config->get('cancelamento_horas', 0);
            $retencao = (float) $config->get('cancelamento_retencao_percentual', 0);
            $inicio = Carbon::parse($reserva->data->format('Y-m-d').' '.$reserva->hora_inicio);
            if ($limite > 0 && now()->diffInHours($inicio, false) < $limite) {
                $retencao = 100;
            }
            $pago = (float) Pagamento::where('reservas_id', $reserva->id)->where('status', 'pago')->sum('valor');
            $reembolso = round($pago * (1 - $retencao / 100), 2);
            if ($reembolso > 0) {
                $metodo = Pagamento::where('reservas_id', $reserva->id)->where('status', 'pago')->latest('pago_em')->value('metodo') ?? 'pix';
                Pagamento::create(['reservas_id' => $reserva->id, 'metodo' => $metodo, 'tipo' => 'reembolso', 'status' => 'estornado', 'valor' => $reembolso, 'pago_em' => now(), 'confirmados_por' => $userId]);
            }
            $reserva->update([
            'status' => 'cancelada',
            'cancelados_por' => $userId,
            'cancelada_em' => now(),
            'observacao' => $validated['observacao'] ?? $reserva->observacao,
            ]);
            return ['retencao_percentual' => $retencao, 'valor_pago' => $pago, 'valor_reembolso' => $reembolso];
        });

        return response()->json(['reserva' => $reserva->fresh(), 'cancelamento' => $resultado]);
    }
 
    public function remarcar(Request $request, $id)
    {
        $reserva = Reserva::with('quadra.horariosFuncionamento')->findOrFail($id);
        $userId = $this->usuarioAutenticado()->id;
        $isOwner = $reserva->reservas_usuarios_id === $userId;
        if (!$isOwner && !$this->podeGerirArena($userId, $reserva->quadra->arenas_id)) {
            abort(403, 'Não autorizado.');
        }
        if (!in_array($reserva->status, ['pendente', 'confirmada'], true)) {
            return response()->json(['message' => 'Esta reserva não pode ser remarcada'], 422);
        }

        $validated = $request->validate([
            'data' => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'motivo' => ['nullable', 'string'],
        ]);

        if (!$this->estaNoHorarioFuncionamento($reserva->quadra, $validated['data'], $validated['hora_inicio'], $validated['hora_fim'])) {
            return response()->json(['message' => 'Horário fora do funcionamento da quadra'], 422);
        }

        $reservaAtualizada = DB::transaction(function () use ($reserva, $validated, $userId) {
            Quadra::whereKey($reserva->quadras_id)->lockForUpdate()->firstOrFail();

            $hasConflito = Reserva::where('quadras_id', $reserva->quadras_id)
                ->where('id', '!=', $reserva->id)
                ->where('data', $validated['data'])
                ->whereIn('status', ['pendente', 'confirmada'])
                ->where('hora_inicio', '<', $validated['hora_fim'])
                ->where('hora_fim', '>', $validated['hora_inicio'])
                ->lockForUpdate()
                ->exists();

            $hasBloqueio = BloqueioQuadra::where('quadras_id', $reserva->quadras_id)
                ->where('data', $validated['data'])
                ->where('hora_inicio', '<', $validated['hora_fim'])
                ->where('hora_fim', '>', $validated['hora_inicio'])
                ->lockForUpdate()
                ->exists();

            if ($hasConflito || $hasBloqueio) {
                abort(409, 'Horário indisponível.');
            }

            $reserva->update([
                'data' => $validated['data'],
                'hora_inicio' => $validated['hora_inicio'],
                'hora_fim' => $validated['hora_fim'],
                'observacao' => $validated['motivo'] ?? $reserva->observacao,
                'alteradas_por' => $userId,
            ]);

            return $reserva->fresh();
        });

        return response()->json(['message' => 'Reserva remarcada com sucesso.', 'reserva' => $reservaAtualizada]);
    }

    private function estaNoHorarioFuncionamento(Quadra $quadra, string $data, string $inicio, string $fim): bool
    {
        $diaSemana = $this->diaSemana(Carbon::parse($data));
        return $quadra->horariosFuncionamento
            ->where('dia_semana', $diaSemana)
            ->where('ativo', true)
            ->contains(fn ($horario) => $inicio >= substr($horario->hora_inicio, 0, 5) && $fim <= substr($horario->hora_fim, 0, 5));
    }

    private function diaSemana(Carbon $data): string
    {
        return ['segunda-feira', 'terca-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sabado', 'domingo'][$data->dayOfWeekIso - 1];
    }

    private function podeGerirArena(?int $userId, int $arenaId): bool
    {
        if (!$userId) {
            return false;
        }

        return AdminArena::where('usuarios_id', $userId)->where('arenas_id', $arenaId)->where('ativo', true)->exists()
            || FuncionarioArena::where('usuarios_id', $userId)->where('arenas_id', $arenaId)->where('ativo', true)->exists()
            || \App\Models\SuperAdmin::where('usuarios_id', $userId)->where('ativo', true)->exists();
    }

    private function usuarioAutenticado(): Usuario
    {
        $user = Auth::user();
        if (!$user instanceof Usuario) {
            abort(401, 'Não autenticado.');
        }

        return $user;
    }
}
