<?php

namespace App\Http\Controllers;

use App\Models\AdminArena;
use App\Models\BloqueioQuadra;
use App\Models\Configuracao;
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
        'quadra_id' => 'required|exists:quadras,id',
        'data' => 'required|date',
        'hora_inicio' => 'required',
        'hora_fim' => 'required',
        'valor_total' => 'required|numeric',
        'usuario_id' => 'nullable|exists:usuarios,id',
        'cliente_nome' => 'nullable|string|max:100',
        'observacao' => 'nullable|string',
    ]);

    // Se não tem usuario_id mas tem cliente_nome, cria usuário temporário
    $usuarioId = $validated['usuario_id'] ?? null;
    
    if (!$usuarioId && !empty($validated['cliente_nome'])) {
        $usuarioTemp = Usuario::firstOrCreate(
            ['email' => 'convidado_' . time() . '@temp.local'],
            [
                'nome_completo' => $validated['cliente_nome'],
                'nome_usuario' => 'convidado_' . time(),
                'senha_hash' => Hash::make('temp123'),
                'telefone' => null,
                'data_nascimento' => null,
                'ativo' => true
            ]
        );
        $usuarioId = $usuarioTemp->id;
    }

    $reserva = Reserva::create([
        'reservas_usuarios_id' => $usuarioId,
        'quadras_id' => $validated['quadra_id'],
        'data' => $validated['data'],
        'hora_inicio' => $validated['hora_inicio'],
        'hora_fim' => $validated['hora_fim'],
        'valor_total' => $validated['valor_total'],
        'status' => 'pendente',
        'observacao' => $validated['observacao'] ?? null,
        'alteradas_por' => null,
    ]);

    return response()->json($reserva->load('usuario', 'quadra'), 201);
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

    public function quadrasDisponiveis()
    {

        return response()->json(Quadra::with('arena')->where('ativo', true)->whereHas('arena', fn ($q) => $q->where('ativo', true)->where('status_aprovacao', 'aprovada'))->get());

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
                ->with(['quadra.arena', 'pagamento'])
                ->orderByDesc('data')
                ->orderByDesc('hora_inicio')
                ->get()
        );
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

    //  MÉTODO PARA REMARCAR RESERVA
public function remarcar(Request $request, $id)
{
    $reserva = Reserva::where('id', $id)
        ->where('reservas_usuarios_id', auth()->id())
        ->firstOrFail();
    
    // Só permite remarcar se não estiver cancelada/concluída
    if (in_array($reserva->status, ['cancelada', 'concluida'])) {
        return response()->json(['message' => 'Esta reserva não pode ser remarcada.'], 422);
    }
    
    $validated = $request->validate([
        'data' => 'required|date|after_or_equal:today',
        'hora_inicio' => 'required',
        'hora_fim' => 'required|after:hora_inicio',
        'motivo' => 'nullable|string|max:255'
    ]);
    
    // Atualiza a reserva
    $reserva->update([
        'data' => $validated['data'],
        'hora_inicio' => $validated['hora_inicio'],
        'hora_fim' => $validated['hora_fim'],
        'alteradas_por' => auth()->id(),
        'alterada_em' => now(),
        'observacao' => $validated['motivo'] ? 
            ($reserva->observacao ? $reserva->observacao . "\n\n[Remarcada] " . $validated['motivo'] : "[Remarcada] " . $validated['motivo']) 
            : $reserva->observacao
    ]);
    
    return response()->json([
        'message' => 'Reserva remarcada com sucesso.',
        'reserva' => $reserva->load('quadra', 'usuario')
    ]);
}
}
