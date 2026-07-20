<?php

namespace App\Http\Controllers;

use App\Models\ResetarSenha;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registrar(Request $request)
    {
        $data = $request->validate([
            'nome_completo' => ['required', 'string', 'max:100'],
            'nome_usuario' => ['required', 'string', 'max:50', 'unique:usuarios,nome_usuario'],
            'email' => ['required', 'email', 'max:191', 'unique:usuarios,email'],
            'senha' => ['required', 'string', 'min:8', 'confirmed'],
            'telefone' => ['required', 'digits:11'],
            'data_nascimento' => ['required', 'date', 'before:today'],
        ]);

        $usuario = Usuario::create([
            'nome_completo' => $data['nome_completo'], 'nome_usuario' => $data['nome_usuario'],
            'email' => $data['email'], 'senha_hash' => Hash::make($data['senha']),
            'telefone' => $data['telefone'], 'data_nascimento' => $data['data_nascimento'],
        ]);

        return response()->json(['usuario' => $usuario, 'token' => $usuario->createToken('cliente')->plainTextToken], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'senha' => ['required', 'string']]);
        $usuario = Usuario::where('email', $data['email'])->where('ativo', true)->first();
        if (!$usuario || !Hash::check($data['senha'], $usuario->senha_hash)) {
            return response()->json(['message' => 'Credenciais inválidas'], 422);
        }
        return response()->json(['usuario' => $usuario, 'token' => $usuario->createToken('sessao')->plainTextToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->noContent();
    }

    public function solicitarReset(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email']]);
        $usuario = Usuario::where('email', $data['email'])->first();
        if (!$usuario) return response()->json(['message' => 'Se o e-mail existir, o código será enviado.']);
        $codigo = (string) random_int(100000, 999999);
        ResetarSenha::where('usuarios_id', $usuario->id)->where('usado', false)->update(['usado' => true]);
        ResetarSenha::create(['usuarios_id' => $usuario->id, 'email' => $usuario->email, 'codigo' => $codigo, 'expira_em' => now()->addMinutes(15), 'tipo' => 'resetar_senha', 'ip' => $request->ip()]);
        logger()->info('Código de recuperação gerado.', ['email' => $usuario->email, 'codigo' => $codigo]);
        return response()->json(['message' => 'Código de recuperação gerado.']);
    }

    public function redefinirSenha(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'codigo' => ['required', 'digits:6'], 'senha' => ['required', 'string', 'min:8', 'confirmed']]);
        $reset = ResetarSenha::where('email', $data['email'])->where('codigo', $data['codigo'])->where('usado', false)->where('expira_em', '>', now())->latest()->first();
        if (!$reset) return response()->json(['message' => 'Código inválido ou expirado'], 422);
        $reset->update(['usado' => true]);
        $reset->usuario->update(['senha_hash' => Hash::make($data['senha'])]);
        return response()->json(['message' => 'Senha redefinida com sucesso.']);
    }
}
