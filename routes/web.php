<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');});

Route::get('/login', function () {
    return view('auth.login'); });

Route::get('/criar-conta', function () {
    return view('auth.criar-conta'); });

Route::get('/recuperar-senha', function () {
    return view('auth.recuperar-senha'); });

Route::get('/painel', function () {
     return view('cliente.painel'); });

Route::get('/nova-reserva', function () {
     return view('cliente.nova-reserva'); });

Route::get('/minhas-reservas', function () {
     return view('cliente.minhas-reservas'); });

Route::get('/notificacoes', function () {
     return view('cliente.notificacoes'); });

Route::get('/perfil', function () {
     return view('cliente.perfil'); });

Route::get('/detalhes-quadra', function () {
     return view('detalhes-quadra'); });

Route::get('/painel-funcionario', function () {
     return view('funcionario.painel'); });

Route::get('/funcionario/agenda', function () {
     return view('funcionario.agenda'); });

Route::get('/funcionario/perfil', function () {
    return view('funcionario.perfil'); });

Route::get('/funcionario/notificacoes', function () {
    return view('funcionario.notificacoes'); });

Route::get('/admin/agendamentos', function () {
     return view('admin.agendamentos'); });

Route::get('/admin/financeiro', function () {
     return view('admin.financeiro'); });

Route::get('/admin/pessoas', function () {
     return view('admin.pessoas'); });

Route::get('/admin/clientes', function () {
     return view('admin.clientes'); });

Route::get('/admin/quadras', function () {
     return view('admin.quadras'); });

Route::get('/admin/equipe', function () {
     return view('admin.equipe'); });

Route::get('/admin/dashboard', function () {
     return view('admin.dashboard'); });

Route::get('/admin/configuracoes', function () {
     return view('admin.configuracoes'); });

Route::get('/admin/logs', function () {
     return view('admin.logs'); });

Route::get('/admin/notificacoes', function () {
     return view('admin.notificacoes'); });

Route::get('/teste', function () {
     return view('teste-navegacao'); });

Route::get('/cadastrar-arena', function () {
    return view('cadastrar-arena');
});

Route::get('/partida/{codigo?}', function () {
     return view('partida');
});
