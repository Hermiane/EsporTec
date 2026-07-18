<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ReservaController;

use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FinanceiroController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\ClienteController as AdminClienteController;
use App\Http\Controllers\Auth\PasswordResetController;
// MÓDULO CLIENTE
// REQUISITO 1: Cadastro autônomo
// REQUISITO 4: Histórico

Route::post('/auth/registro', [AuthController::class, 'registrar']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/recuperar-senha', [AuthController::class, 'solicitarReset']);
Route::post('/auth/redefinir-senha', [AuthController::class, 'redefinirSenha']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/publico/arenas', [PublicoController::class, 'arenas']);
Route::get('/publico/arenas/{id}', [PublicoController::class, 'arena']);
Route::get('/publico/quadras/{id}', [PublicoController::class, 'quadra']);

// ===== API AUTENTICADA (front) =====
Route::middleware('auth:sanctum')->group(function () {
    // GET /api/quadras
    Route::get('/quadras', [ReservaController::class, 'quadrasDisponiveis']);

    // POST /api/reservas
    Route::post('/reservas', [ReservaController::class, 'store']);

    // Pagamentos do cliente
    Route::post('/pagamentos', [PagamentoController::class, 'store']);

    // Atualizações/cancelamento (se necessário pelo front)
    Route::patch('/reservas/{id}/status', [ReservaController::class, 'updateStatus']);
    Route::patch('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar']);
});


// ===== ROTAS DO CLIENTE LOGADO =====
Route::middleware('auth:sanctum')->prefix('cliente')->group(function () {
 Route::get('/quadras', [ReservaController::class, 'quadrasDisponiveis']);
 Route::get('/quadras/{id}/horarios', [ReservaController::class, 'horariosDisponiveis']);
 Route::get('/reservas', [ReservaController::class, 'minhasReservas']);
 Route::post('/pagamentos', [PagamentoController::class, 'store']);
 Route::get('/pagamentos/reservas/{reserva_id}', [PagamentoController::class, 'porReserva']);
});

// ===== ROTAS DO FUNCIONÁRIO/ADMIN =====
use App\Http\Controllers\PagamentoController as FuncPagamentoController;
Route::middleware(['auth:sanctum', 'papel:equipe'])->prefix('funcionario')->group(function () {
    Route::get('/agenda/dia', [AgendaController::class, 'dia']);
    Route::get('/agenda/semana', [AgendaController::class, 'semana']);
    Route::patch('/reservas/{id}/horario', [AgendaController::class, 'alterarHorario']);
    Route::get('/pagamentos/pendentes', [FuncPagamentoController::class, 'pendentes']);
    Route::patch('/pagamentos/{id}/confirmar', [FuncPagamentoController::class, 'confirmar']);
    Route::patch('/pagamentos/{id}/recusar', [FuncPagamentoController::class, 'recusar']);

    // Versões POST (legacy) removidas para evitar duplicidade de rotas.
});
// ===== MÓDULO ADMIN =====
Route::middleware(['auth:sanctum', 'papel:admin'])->prefix('admin')->group(function () {
 
 // Financeiro
 Route::get('/financeiro/fluxo-caixa', [FinanceiroController::class, 'fluxoCaixa']);

 
 // Usuários
 Route::get('/usuarios', [UsuarioController::class, 'index']);
 Route::post('/usuarios', [UsuarioController::class, 'store']);
 Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
 Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
 Route::delete('/usuarios/{id}', [UsuarioController::class, 'inativar']);
 Route::put('/usuarios/{id}/promover', [AdminController::class, 'promoverAdmin']);
 Route::put('/usuarios/{id}/toggle', [AdminController::class, 'toggleAtivo']);
 
 // Clientes - gestão pelo admin
 Route::get('/clientes', [AdminClienteController::class, 'index']);
 Route::get('/clientes/{id}', [AdminClienteController::class, 'show']);
 
 // Quadras - gestão pelo admin
 Route::get('/quadras', [App\Http\Controllers\Admin\AdminController::class, 'listarQuadras']);
 Route::post('/quadras', [App\Http\Controllers\Admin\AdminController::class, 'storeQuadra']);
 Route::put('/quadras/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateQuadra']);
 
 // Relatórios
 Route::get('/relatorio', [App\Http\Controllers\Admin\AdminController::class, 'relatorioFinanceiro']);
 Route::get('/reservas', [App\Http\Controllers\Admin\AdminController::class, 'todasReservas']);
});
// ===== MÓDULO FUNCIONÁRIO =====
// Password Reset
//Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
//Route::post('/reset-password', [PasswordResetController::class, 'reset']);
