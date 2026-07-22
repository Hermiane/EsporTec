<?php

namespace App\Http\Controllers;

use App\Models\AdminArena;
use App\Models\FuncionarioArena;
use App\Models\ResetarSenha;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

    //  ESTAS 2 LINHAS CRIAM A SESSÃO WEB 
    \Illuminate\Support\Facades\Auth::login($usuario);
    $request->session()->regenerate();
    //  FIM DAS LINHAS CRÍTICAS 

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
    public function logout(Request $request) { $request->user()->currentAccessToken()?->delete(); return response()->noContent(); }
    public function solicitarReset(Request $request) { $d=$request->validate(['email'=>['required','email']]); $u=Usuario::where('email',$d['email'])->first(); if(!$u) return response()->json(['message'=>'Se o e-mail existir, o código será enviado.']); $codigo=(string)random_int(100000,999999); ResetarSenha::where('usuarios_id',$u->id)->where('usado',false)->update(['usado'=>true]); ResetarSenha::create(['usuarios_id'=>$u->id,'email'=>$u->email,'codigo'=>Hash::make($codigo),'expira_em'=>now()->addMinutes(15),'tipo'=>'resetar_senha','ip'=>$request->ip()]); Mail::raw("Seu código EsporTec é {$codigo}. Expira em 15 minutos.",fn($m)=>$m->to($u->email)->subject('Recuperação de senha')); return response()->json(['message'=>'Código de recuperação enviado.']); }
    public function redefinirSenha(Request $request) { $d=$request->validate(['email'=>['required','email'],'codigo'=>['required','digits:6'],'senha'=>['required','string','min:8','confirmed']]); $r=ResetarSenha::where('email',$d['email'])->where('usado',false)->where('expira_em','>',now())->latest()->first(); if(!$r||$r->tentativa>=5||!Hash::check($d['codigo'],$r->codigo)){ if($r)$r->increment('tentativa'); return response()->json(['message'=>'Código inválido ou expirado'],422); } $r->update(['usado'=>true]); $r->usuario->update(['senha_hash'=>Hash::make($d['senha'])]); return response()->json(['message'=>'Senha redefinida com sucesso.']); }
    public function verificarCodigoReset(Request $request) { $d=$request->validate(['email'=>['required','email'],'codigo'=>['required','digits:6']]); $r=ResetarSenha::where('email',$d['email'])->where('usado',false)->where('expira_em','>',now())->latest()->first(); if(!$r||$r->tentativa>=5||!Hash::check($d['codigo'],$r->codigo)){ if($r)$r->increment('tentativa'); return response()->json(['message'=>'Código inválido ou expirado'],422); } return response()->json(['message'=>'Código validado.']); }

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
