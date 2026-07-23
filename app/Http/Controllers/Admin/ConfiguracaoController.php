<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arena;
use App\Models\Configuracao;
use App\Models\HorarioFuncionamento;
use App\Support\ArenaAuthorization;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    use ArenaAuthorization;

    private function arenaAtual(Request $request): Arena
    {
        $id = $request->input('arena_id') ?: $this->arenaIdsPermitidos($request)[0] ?? null;
        abort_unless($id, 422, 'Nenhuma arena vinculada à conta.'); $this->autorizarArena($request, (int) $id);
        return Arena::findOrFail($id);
    }

    public function show(Request $request)
    {
        $arena = $this->arenaAtual($request);
        $config = Configuracao::where('arenas_id', $arena->id)->pluck('valor', 'chave');
        $horarios = HorarioFuncionamento::whereHas('quadra', fn ($q) => $q->where('arenas_id', $arena->id))
            ->where('ativo', true);
        $horario = (clone $horarios)->first();

        return response()->json([
            'arena' => [
                'nome' => $arena->nome, 'cnpj' => $arena->cnpj,
                'logradouro' => $arena->logradouro, 'numero' => $arena->numero,
                'bairro' => $arena->bairro, 'cidade' => $arena->cidade,
                'uf' => $arena->estado, 'referencia' => $arena->ponto_referencia,
                'telefone' => $arena->telefone, 'email' => $arena->email,
            ],
            'horarios' => [
                'abertura' => optional($horario)->hora_inicio,
                'fechamento' => optional($horario)->hora_fim,
                'dias' => $horarios->pluck('dia_semana')->unique()->values()->all(),
            ],
            'regras' => $config->only(['antecedencia_minima', 'multa_cancelamento', 'duracao_padrao', 'max_reservas_cliente'])->all(),
            'pagamentos' => [
                'pix_tipo' => $arena->pix_tipo,
                'pix_chave' => $arena->pix_chave,
                'aceitar_pix' => filter_var($config->get('aceitar_pix', true), FILTER_VALIDATE_BOOLEAN),
                'aceitar_cartao_credito' => filter_var($config->get('aceitar_cartao_credito', true), FILTER_VALIDATE_BOOLEAN),
                'aceitar_cartao_debito' => filter_var($config->get('aceitar_cartao_debito', true), FILTER_VALIDATE_BOOLEAN),
                'aceitar_dinheiro' => filter_var($config->get('aceitar_dinheiro', true), FILTER_VALIDATE_BOOLEAN),
            ],
            'notificacoes' => [
                'email_confirmacao' => filter_var($config->get('email_confirmacao', true), FILTER_VALIDATE_BOOLEAN),
                'lembrete_automatico' => filter_var($config->get('lembrete_automatico', true), FILTER_VALIDATE_BOOLEAN),
                'solicitar_feedback' => filter_var($config->get('solicitar_feedback', true), FILTER_VALIDATE_BOOLEAN),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $arena = $this->arenaAtual($request); $d = $request->validate(['arena' => ['required', 'array'], 'horarios' => ['nullable', 'array'], 'regras' => ['nullable', 'array'], 'pagamentos' => ['nullable', 'array'], 'notificacoes' => ['nullable', 'array']]);
        $arena->update(['nome' => $d['arena']['nome'], 'cnpj' => $d['arena']['cnpj'], 'logradouro' => $d['arena']['logradouro'], 'numero' => $d['arena']['numero'] ?? null, 'bairro' => $d['arena']['bairro'], 'cidade' => $d['arena']['cidade'], 'estado' => $d['arena']['uf'], 'ponto_referencia' => $d['arena']['referencia'] ?? null, 'telefone' => preg_replace('/\D/', '', $d['arena']['telefone']), 'email' => $d['arena']['email'], 'pix_tipo' => $d['pagamentos']['pix_tipo'], 'pix_chave' => $d['pagamentos']['pix_chave']]);
        foreach (['regras', 'pagamentos', 'notificacoes'] as $grupo) foreach (($d[$grupo] ?? []) as $chave => $valor) Configuracao::updateOrCreate(['arenas_id' => $arena->id, 'chave' => $chave], ['valor' => is_bool($valor) ? ($valor ? '1' : '0') : (string) $valor, 'descricao' => 'Configuração da arena']);
        if (!empty($d['horarios']['abertura']) && !empty($d['horarios']['fechamento'])) {
            $horarios = HorarioFuncionamento::whereHas('quadra', fn ($q) => $q->where('arenas_id', $arena->id));
            $horarios->update(['hora_inicio' => $d['horarios']['abertura'], 'hora_fim' => $d['horarios']['fechamento']]);
            $diasAtivos = $d['horarios']['dias'] ?? [];
            $horarios->whereIn('dia_semana', $diasAtivos)->update(['ativo' => true]);
            $horarios->whereNotIn('dia_semana', $diasAtivos)->update(['ativo' => false]);
        }
        return response()->json(['message' => 'Configurações atualizadas.']);
    }
}
