<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () { return view('auth.login'); });
Route::get('/criar-conta', function () { return view('auth.criar-conta'); });
Route::get('/recuperar-senha', function () { return view('auth.recuperar-senha'); });
Route::get('/painel', function () { return view('cliente.painel'); });
Route::get('/nova-reserva', function () { return view('cliente.nova-reserva'); });
Route::get('/minhas-reservas', function () { return view('cliente.minhas-reservas'); });
Route::get('/notificacoes', function () { return view('cliente.notificacoes'); });
Route::get('/perfil', function () { return view('cliente.perfil'); });
Route::get('/detalhes-quadra', function () { return view('detalhes-quadra'); });
Route::get('/painel-funcionario', function () { return view('funcionario.painel'); });
Route::get('/funcionario/perfil', function () { return view('funcionario.perfil'); });
Route::get('/admin/agendamentos', function () { return view('admin.agendamentos'); });
Route::get('/admin/financeiro', function () { return view('admin.financeiro'); });
Route::get('/admin/pessoas', function () { return view('admin.pessoas'); });
Route::get('/admin/clientes', function () { return view('admin.clientes'); });
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/admin/configuracoes', function () { return view('admin.configuracoes'); });
Route::get('/teste', function () { return view('teste-navegacao'); });
Route::get('/funcionario/perfil', function () { return view('funcionario.perfil'); });