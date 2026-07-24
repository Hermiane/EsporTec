<?php

namespace App\Http\Controllers;

use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\ResetarSenha;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registrar(Request $request) { $d=$request->validate(['nome_completo'=>['required','string','max:100'],'nome_usuario'=>['required','string','max:50','unique:usuarios,nome_usuario'],'email'=>['required','email','max:191','unique:usuarios,email'],'senha'=>['required','string','min:8','confirmed'],'telefone'=>['required','digits:11'],'data_nascimento'=>['required','date','before:today']]); $u=Usuario::create(['nome_completo'=>$d['nome_completo'],'nome_usuario'=>$d['nome_usuario'],'email'=>$d['email'],'senha_hash'=>Hash::make($d['senha']),'telefone'=>$d['telefone'],'data_nascimento'=>$d['data_nascimento']]); return response()->json(['usuario'=>$u,'acessos'=>$this->acessosPermitidos($u),'acesso_atual'=>'cliente','token'=>$u->createToken('cliente')->plainTextToken],201); }
   public function login(Request $request)
{
    $dados = $request->validate([
        'email' => ['required', 'email'],
        'senha' => ['required', 'string'],
        'tipo_acesso' => ['required', 'in:cliente,funcionario,admin,super_admin'],
    ]);

    $usuario = Usuario::where('email', $dados['email'])->where('ativo', true)->first();
    
    if (!$usuario || !Hash::check($dados['senha'], $usuario->senha_hash)) {
        return response()->json(['message' => 'Credenciais inválidas.'], 422);
    }

    $acessos = $this->acessosPermitidos($usuario);
    
    if (!$acessos[$dados['tipo_acesso']]) {
        return response()->json(['message' => 'Esta conta não possui permissão para a área selecionada.'], 403);
    }

    return response()->json([
        'usuario' => $usuario,
        'acessos' => $acessos,
        'acesso_atual' => $dados['tipo_acesso'],
        'token' => $usuario->createToken('sessao')->plainTextToken,
    ]);
}

    public function me(Request $request)
    {
        return response()->json([
            'usuario' => $request->user(),
            'acessos' => $this->acessosPermitidos($request->user()),
        ]);
    }
    public function atualizarPerfil(Request $request)
    {
        $usuario = $request->user();

        $dados = $request->validate([
            'nome_completo' => ['required', 'string', 'max:100'],
            'nome_usuario' => ['nullable', 'string', 'max:50'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'data_nascimento' => ['nullable', 'date', 'before:today'],
            'email_marketing' => ['nullable', 'boolean'],
            'nova_senha' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!empty($dados['nova_senha'])) {
            $usuario->senha_hash = Hash::make($dados['nova_senha']);
        }

        $usuario->nome_completo = $dados['nome_completo'];
        $usuario->nome_usuario = $dados['nome_usuario'] ?? $usuario->nome_usuario;
        $usuario->telefone = $dados['telefone'] ?? $usuario->telefone;
        $usuario->data_nascimento = $dados['data_nascimento'] ?? $usuario->data_nascimento;
        $usuario->email_marketing = $request->boolean('email_marketing');
        $usuario->save();

        return response()->json(['message' => 'Perfil atualizado com sucesso!', 'usuario' => $usuario]);
    }
    public function logout(Request $request) { $request->user()->currentAccessToken()?->delete(); return response()->noContent(); }
    public function solicitarReset(Request $request)
    {
        $dados = $request->validate(['email' => ['required', 'email']]);
        $usuario = Usuario::where('email', Str::lower($dados['email']))->first();
        if (! $usuario) return response()->json(['message' => 'Se o e-mail existir, o código será enviado.']);

        $codigo = (string) random_int(100000, 999999);
        ResetarSenha::where('usuarios_id', $usuario->id)->where('usado', false)->update(['usado' => true]);
        $reset = ResetarSenha::create(['usuarios_id' => $usuario->id, 'email' => $usuario->email, 'codigo' => Hash::make($codigo), 'expira_em' => now()->addMinutes(15), 'tipo' => 'resetar_senha', 'ip' => $request->ip()]);

        try {
            Mail::raw("Seu código de recuperação EsporTec é {$codigo}. Ele expira em 15 minutos.", fn ($mensagem) => $mensagem->to($usuario->email)->subject('Recuperação de senha — EsporTec'));
        } catch (\Throwable $erro) {
            $reset->update(['usado' => true]);
            Log::warning('Falha ao enviar código de recuperação de senha.', ['usuario_id' => $usuario->id, 'erro' => $erro->getMessage()]);
            return response()->json(['message' => 'Não foi possível enviar o código agora. Tente novamente em alguns minutos.'], 503);
        }
        return response()->json(['message' => 'Código de recuperação enviado.']);
    }

    public function redefinirSenha(Request $request)
    {
        $dados = $request->validate(['email' => ['required', 'email'], 'codigo' => ['required', 'digits:6'], 'senha' => ['required', 'string', 'min:8', 'confirmed']]);
        $reset = $this->resetValido(Str::lower($dados['email']), $dados['codigo']);
        if (! $reset) return response()->json(['message' => 'Código inválido ou expirado.'], 422);

        DB::transaction(function () use ($reset, $dados) {
            $reset->update(['usado' => true]);
            $reset->usuario->update(['senha_hash' => Hash::make($dados['senha'])]);
            $reset->usuario->tokens()->delete();
        });
        return response()->json(['message' => 'Senha redefinida com sucesso.']);
    }

    public function verificarCodigoReset(Request $request)
    {
        $dados = $request->validate(['email' => ['required', 'email'], 'codigo' => ['required', 'digits:6']]);
        if (! $this->resetValido(Str::lower($dados['email']), $dados['codigo'])) return response()->json(['message' => 'Código inválido ou expirado.'], 422);
        return response()->json(['message' => 'Código validado.']);
    }

    private function resetValido(string $email, string $codigo): ?ResetarSenha
    {
        $reset = ResetarSenha::where('email', $email)->where('usado', false)->where('expira_em', '>', now())->latest()->first();
        if (! $reset || $reset->tentativa >= 5) return null;
        if (Hash::check($codigo, $reset->codigo)) return $reset;
        $reset->increment('tentativa');
        return null;
    }

    private function acessosPermitidos(Usuario $usuario): array
    {
        $arenaAprovada = fn ($query) => $query->where('ativo', true)->where('status_aprovacao', 'aprovada');

        return [
            'cliente' => true,
            'super_admin' => $usuario->superAdmin()->where('ativo', true)->exists(),
            'admin' => AdminArena::where('usuarios_id', $usuario->id)->where('ativo', true)
                ->whereHas('arena', $arenaAprovada)->exists(),
            'funcionario' => FuncionarioArena::where('usuarios_id', $usuario->id)->where('ativo', true)
                ->whereHas('arena', $arenaAprovada)->exists(),
        ];
    }
}
