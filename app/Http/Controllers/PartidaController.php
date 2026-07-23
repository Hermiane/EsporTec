<?php

namespace App\Http\Controllers;

use App\Models\JogadorPartida;
use App\Models\Partida;
use App\Models\Reserva;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartidaController extends Controller
{
    public function show(string $codigo): View
    {
        $partida = Partida::with([
            'reserva.usuario:id,nome_completo',
            'reserva.quadra.arena:id,nome',
            'jogadores' => fn ($query) => $query
                ->whereIn('status', ['confirmado', 'pendente'])
                ->orderByRaw("CASE WHEN status = 'confirmado' THEN 0 ELSE 1 END")
                ->orderBy('id'),
        ])->where('link_partida', $codigo)->firstOrFail();

        return view('partida', compact('partida'));
    }

    public function entrar(Request $request, string $codigo): RedirectResponse
    {
        $dados = $request->validate(['nome_jogador' => ['required', 'string', 'min:2', 'max:100']]);

        $status = DB::transaction(function () use ($codigo, $dados): string {
            $partida = Partida::where('link_partida', $codigo)->lockForUpdate()->firstOrFail();
            abort_unless($partida->ativo && $partida->reserva->status === 'confirmada', 422, 'Esta partida não está aceitando participantes.');
            abort_if($partida->reserva->data->isBefore(now()->startOfDay()), 422, 'Esta partida já aconteceu.');

            $confirmados = JogadorPartida::where('partidas_id', $partida->id)->where('status', 'confirmado')->count();
            $status = $confirmados < $partida->max_jogador ? 'confirmado' : 'pendente';
            JogadorPartida::create([
                'partidas_id' => $partida->id,
                'nome_jogador' => trim($dados['nome_jogador']),
                'status' => $status,
            ]);
            return $status;
        });

        return back()->with('success', $status === 'confirmado'
            ? 'Seu nome foi adicionado à lista de participantes.'
            : 'A lista está cheia. Seu nome foi adicionado à fila de espera.');
    }

    public function criarLink(Request $request, Reserva $reserva): JsonResponse
    {
        abort_unless($reserva->reservas_usuarios_id === $request->user()->id, 403, 'Apenas o responsável pela reserva pode criar o link.');
        abort_unless($reserva->status === 'confirmada', 422, 'O link será liberado quando a reserva estiver confirmada.');

        $partida = DB::transaction(function () use ($reserva): Partida {
            $reserva = Reserva::with('quadra')->lockForUpdate()->findOrFail($reserva->id);
            return Partida::firstOrCreate(
                ['reservas_id' => $reserva->id],
                ['link_partida' => (string) Str::uuid(), 'max_jogador' => $reserva->quantidade_jogadores ?: $reserva->quadra->capacidade_jogador, 'ativo' => true],
            );
        });

        return response()->json([
            'partida_id' => $partida->id,
            'link' => route('partida.show', $partida->link_partida),
            'caminho' => route('partida.show', $partida->link_partida, false),
            'capacidade' => $partida->max_jogador,
        ]);
    }

    public function removerJogador(Request $request, Partida $partida, JogadorPartida $jogador): JsonResponse
    {
        $partida->loadMissing('reserva');
        abort_unless($partida->reserva->reservas_usuarios_id === $request->user()->id, 403, 'Apenas o responsável pela reserva pode retirar participantes.');
        abort_unless($jogador->partidas_id === $partida->id && in_array($jogador->status, ['confirmado', 'pendente'], true), 404);

        $promovido = DB::transaction(function () use ($partida, $jogador): ?JogadorPartida {
            $partida = Partida::lockForUpdate()->findOrFail($partida->id);
            $jogador = JogadorPartida::lockForUpdate()->findOrFail($jogador->id);
            $liberouVaga = $jogador->status === 'confirmado';
            $jogador->update(['status' => 'recusado']);

            if (! $liberouVaga) return null;
            $proximo = JogadorPartida::where('partidas_id', $partida->id)->where('status', 'pendente')->orderBy('id')->lockForUpdate()->first();
            $proximo?->update(['status' => 'confirmado']);
            return $proximo;
        });

        return response()->json([
            'message' => $promovido ? "Participante removido e {$promovido->nome_jogador} promovido da espera." : 'Participante removido.',
            'promovido' => $promovido,
        ]);
    }
}
