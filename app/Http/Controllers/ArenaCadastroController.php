<?php

namespace App\Http\Controllers;

use App\Models\AdminArena;
use App\Models\Arena;
use App\Models\Auditoria;
use App\Models\Despesa;
use App\Models\HorarioFuncionamento;
use App\Models\Pagamento;
use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\SuperAdmin;
use App\Models\Suporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ArenaCadastroController extends Controller
{
    public function solicitar(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:50'],
            'cnpj' => ['required', 'string', 'max:18', 'unique:arenas,cnpj'],
            'responsavel' => ['required', 'string', 'max:100'],
            'telefone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:50', 'unique:arenas,email'],
            'logradouro' => ['required', 'string', 'max:60'],
            'numero' => ['nullable', 'string', 'max:10'],
            'bairro' => ['required', 'string', 'max:20'],
            'cidade' => ['required', 'string', 'max:32'],
            'estado' => ['required', 'string', 'size:2'],
            'ponto_referencia' => ['nullable', 'string', 'max:100'],
            'tipo_quadra' => ['required', 'in:society,futsal,misto,futebol'],
            'quantidade_quadras' => ['required', 'integer', 'min:1', 'max:20'],
            'quadras' => ['required', 'array', 'min:1'],
            'quadras.*.nome' => ['required', 'string', 'max:50'],
            'quadras.*.foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'preco_hora' => ['required', 'numeric', 'min:0'],
            'capacidade_jogador' => ['required', 'integer', 'min:1'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'descricao' => ['required', 'string'],
            'pix_tipo' => ['required', 'in:cpf,cnpj,email,telefone,aleatoria'],
            'pix_chave' => ['required', 'string', 'max:255'],
            'foto_capa' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $fotoCapa = $request->hasFile('foto_capa') ? '/storage/'.$request->file('foto_capa')->store('arenas', 'public') : null;
        $arena = DB::transaction(function () use ($dados, $request, $fotoCapa) {
            $arena = Arena::create([
                'criado_por' => $request->user()->id,
                'nome' => $dados['nome'], 'cnpj' => $dados['cnpj'],
                'logradouro' => $dados['logradouro'], 'numero' => $dados['numero'] ?? null,
                'bairro' => $dados['bairro'], 'cidade' => $dados['cidade'], 'estado' => strtoupper($dados['estado']),
                'ponto_referencia' => $dados['ponto_referencia'] ?? null,
                'telefone' => preg_replace('/\D/', '', $dados['telefone']), 'email' => $dados['email'],
                'descricao' => $dados['descricao'], 'foto_capa' => $fotoCapa, 'pix_tipo' => $dados['pix_tipo'], 'pix_chave' => $dados['pix_chave'],
                'ativo' => false, 'status_aprovacao' => 'pendente',
            ]);

            abort_unless(count($dados['quadras']) === (int) $dados['quantidade_quadras'], 422, 'Informe o nome de todas as quadras.');
            foreach ($dados['quadras'] as $dadosQuadra) {
                $fotoQuadra = isset($dadosQuadra['foto']) ? '/storage/'.$dadosQuadra['foto']->store('quadras', 'public') : ($fotoCapa ?: 'https://via.placeholder.com/800x500?text=Quadra');
                $quadra = Quadra::create([
                    'arenas_id' => $arena->id, 'nome' => $dadosQuadra['nome'], 'tipo' => $dados['tipo_quadra'],
                    'descricao' => $dados['descricao'], 'foto' => $fotoQuadra,
                    'capacidade_jogador' => $dados['capacidade_jogador'], 'preco_hora' => $dados['preco_hora'],
                    'ativo' => false,
                ]);
                foreach (['segunda-feira', 'terca-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sabado', 'domingo'] as $dia) {
                    HorarioFuncionamento::create(['quadras_id' => $quadra->id, 'dia_semana' => $dia, 'hora_inicio' => $dados['hora_inicio'], 'hora_fim' => $dados['hora_fim'], 'ativo' => false]);
                }
            }
            return $arena;
        });

        return response()->json(['message' => 'Cadastro enviado para análise.', 'arena' => $arena], 201);
    }

    public function index(Request $request)
    {
        $this->autorizarSuperAdmin($request);
        return response()->json(Arena::with('criadoPor:id,nome_completo,email')->withCount('quadras')->latest()->get());
    }

    public function dashboard(Request $request)
    {
        $this->autorizarSuperAdmin($request);
        return response()->json([
            'metricas' => [
                'arenas' => Arena::count(),
                'arenas_ativas' => Arena::where('status_aprovacao', 'aprovada')->where('ativo', true)->count(),
                'arenas_pendentes' => Arena::where('status_aprovacao', 'pendente')->count(),
                'admins_ativos' => AdminArena::where('ativo', true)->count(),
                'faturamento_confirmado' => Pagamento::where('status', 'pago')->sum('valor'),
                'chamados_abertos' => Suporte::whereIn('status', ['aberto', 'em_andamento', 'pendente'])->count(),
            ],
            'admins' => AdminArena::with(['usuario:id,nome_completo,email', 'arena:id,nome'])
                ->where('ativo', true)->latest()->limit(12)->get(),
            'logs' => Auditoria::with(['usuario:id,nome_completo', 'arena:id,nome'])
                ->latest()->limit(10)->get(),
        ]);
    }

    public function aprovar(Request $request, Arena $arena)
    {
        $this->autorizarSuperAdmin($request);
        abort_unless($arena->status_aprovacao === 'pendente', 422, 'Esta arena não está pendente de análise.');
        DB::transaction(function () use ($arena, $request) {
            $arena->update(['ativo' => true, 'status_aprovacao' => 'aprovada', 'motivo_recusa' => null, 'analisada_em' => now(), 'analisada_por' => $request->user()->id]);
            Quadra::where('arenas_id', $arena->id)->update(['ativo' => true]);
            HorarioFuncionamento::whereIn('quadras_id', $arena->quadras()->pluck('id'))->update(['ativo' => true]);
            AdminArena::updateOrCreate(['arenas_id' => $arena->id, 'usuarios_id' => $arena->criado_por], ['criado_por' => $request->user()->id, 'cargo' => 'Proprietário', 'is_dono' => true, 'ativo' => true]);
            Auditoria::create(['usuarios_id' => $request->user()->id, 'arenas_id' => $arena->id, 'acao' => 'arena_aprovada', 'descricao' => "Arena {$arena->nome} aprovada.", 'tabela_afetada' => 'arenas', 'registro_id' => $arena->id, 'ip' => $request->ip()]);
        });
        // O e-mail é enviado após a transação, para avisar somente aprovações concluídas.
        $proprietario = $arena->fresh()->criadoPor;
        $emailEnviado = false;

        if ($proprietario?->email) {
            try {
                Mail::raw(
                    "Olá, {$proprietario->nome_completo}!\n\nA arena \"{$arena->nome}\" foi aprovada pela equipe EsporTec e já está ativa na plataforma.\n\nAgora você pode acessar o painel administrativo e gerenciar suas quadras, reservas e equipe.\n\nAtenciosamente,\nEquipe EsporTec",
                    static function ($mensagem) use ($proprietario, $arena): void {
                        $mensagem->to($proprietario->email)
                            ->subject("Sua arena {$arena->nome} foi aprovada!");
                    },
                );
                $emailEnviado = true;
            } catch (\Throwable $erro) {
                // Não desfaz uma aprovação válida por uma indisponibilidade de SMTP.
                Log::warning('Falha ao enviar e-mail de aprovação da arena.', [
                    'arena_id' => $arena->id,
                    'usuario_id' => $proprietario->id,
                    'erro' => $erro->getMessage(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Arena aprovada e proprietário vinculado como administrador.',
            'email_enviado' => $emailEnviado,
            'arena' => $arena->fresh(),
        ]);
    }

    public function recusar(Request $request, Arena $arena)
    {
        $this->autorizarSuperAdmin($request);
        abort_unless($arena->status_aprovacao === 'pendente', 422, 'Esta arena não está pendente de análise.');
        $dados = $request->validate(['motivo_recusa' => ['required', 'string', 'max:1000']]);
        $arena->update(['ativo' => false, 'status_aprovacao' => 'recusada', 'motivo_recusa' => $dados['motivo_recusa'], 'analisada_em' => now(), 'analisada_por' => $request->user()->id]);
        Auditoria::create(['usuarios_id' => $request->user()->id, 'arenas_id' => $arena->id, 'acao' => 'arena_recusada', 'descricao' => "Arena {$arena->nome} recusada: {$dados['motivo_recusa']}", 'tabela_afetada' => 'arenas', 'registro_id' => $arena->id, 'ip' => $request->ip()]);
        return response()->json(['message' => 'Cadastro da arena recusado.', 'arena' => $arena->fresh()]);
    }

    public function alterarAtivacao(Request $request, Arena $arena)
    {
        $this->autorizarSuperAdmin($request);
        abort_unless($arena->status_aprovacao === 'aprovada', 422, 'Apenas arenas aprovadas podem ser ativadas ou inativadas.');
        $ativo = !$arena->ativo;
        DB::transaction(function () use ($arena, $request, $ativo) {
            $arena->update(['ativo' => $ativo]);
            Quadra::where('arenas_id', $arena->id)->update(['ativo' => $ativo]);
            HorarioFuncionamento::whereIn('quadras_id', $arena->quadras()->pluck('id'))->update(['ativo' => $ativo]);
            Auditoria::create(['usuarios_id' => $request->user()->id, 'arenas_id' => $arena->id, 'acao' => $ativo ? 'arena_ativada' : 'arena_inativada', 'descricao' => "Arena {$arena->nome} ".($ativo ? 'ativada.' : 'inativada.'), 'tabela_afetada' => 'arenas', 'registro_id' => $arena->id, 'ip' => $request->ip()]);
        });
        return response()->json(['message' => $ativo ? 'Arena ativada.' : 'Arena inativada.', 'arena' => $arena->fresh()]);
    }

    public function excluir(Request $request, Arena $arena)
    {
        $this->autorizarSuperAdmin($request);
        $possuiReservas = Reserva::whereHas('quadra', fn ($q) => $q->where('arenas_id', $arena->id))->exists();
        $possuiDespesas = Despesa::where('arenas_id', $arena->id)->exists();
        $possuiChamados = Suporte::where('arenas_id', $arena->id)->exists();
        abort_if($possuiReservas || $possuiDespesas || $possuiChamados, 422, 'Esta arena possui histórico operacional. Inative-a para removê-la da plataforma sem apagar dados.');

        DB::transaction(function () use ($arena, $request) {
            Auditoria::create(['usuarios_id' => $request->user()->id, 'arenas_id' => $arena->id, 'acao' => 'arena_excluida', 'descricao' => "Arena {$arena->nome} excluída permanentemente.", 'tabela_afetada' => 'arenas', 'registro_id' => $arena->id, 'ip' => $request->ip()]);
            $arena->delete();
        });
        return response()->json(['message' => 'Arena excluída permanentemente.']);
    }

    private function autorizarSuperAdmin(Request $request): void
    {
        abort_unless(SuperAdmin::where('usuarios_id', $request->user()->id)->where('ativo', true)->exists(), 403, 'Acesso restrito ao superadministrador.');
    }
}
