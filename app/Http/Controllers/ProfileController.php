<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    // MOSTRA O FORM DE EDITAR PERFIL
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    // ATUALIZA NOME E EMAIL
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nome_completo' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:191', 'unique:usuarios,email,'.$user->id],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verificacao = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Perfil atualizado!');
    }

    // ATUALIZA A SENHA
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'senha_hash' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Senha alterada!');
    }

    // DELETA A CONTA
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
