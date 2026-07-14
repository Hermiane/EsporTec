<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Cliente\ReservaController;
use App\Http\Controllers\Cliente\PagamentoController;
use App\Http\Controllers\Admin\AgendamentoController;
use App\Http\Controllers\Admin\FinanceiroController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\ClienteController as AdminClienteController;
use App\Http\Controllers\Auth\PasswordResetController;
// MÓDULO CLIENTE
// REQUISITO 1: Cadastro autônomo
Route::post('/clientes', [ClienteController::class, 'store']);
// REQUISITO 4: Histórico
Route::get('/clientes/{id}/historico', [ClienteController::class, 'historico']);
// REQUISITO 2: Agendamento - ATUALIZADO
Route::post('/reservas', [ReservaController::class, 'store']);
Route::patch('/reservas/{id}/status', [ReservaController::class, 'updateStatus']); // NOVA
Route::patch('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar']); // NOVA
// REQUISITO 3: Pagamento - ATUALIZADO
Route::post('/pagamentos', [PagamentoController::class, 'store']); // NOVA
Route::patch('/pagamentos/{id}/confirmar', [PagamentoController::class, 'confirmar']); // NOVA
Route::patch('/pagamentos/{id}/recusar', [PagamentoController::class, 'recusar']); // NOVA
// ===== ROTAS DO CLIENTE LOGADO =====
Route::prefix('cliente')->group(function () {
 Route::get('/quadras', [ReservaController::class, 'quadrasDisponiveis']);
 Route::get('/quadras/{id}/horarios', [ReservaController::class, 'horariosDisponiveis']);
 Route::get('/reservas', [ReservaController::class, 'minhasReservas']);
 Route::post('/pagamentos', [PagamentoController::class, 'store']);
 Route::get('/pagamentos/reservas/{reserva_id}', [PagamentoController::class, 'pagamentoPorReserva']);
});
// ===== MÓDULO ADMIN =====
Route::prefix('admin')->group(function () {
 
 // Agendamentos
 Route::get('/agendamentos', [AgendamentoController::class, 'index']);
 Route::get('/agendamentos/{id}', [AgendamentoController::class, 'show']);
 Route::post('/agendamentos', [AgendamentoController::class, 'store']);
 Route::patch('/agendamentos/{id}/confirmar', [AgendamentoController::class, 'confirmar']);
 Route::patch('/agendamentos/{id}/cancelar', [AgendamentoController::class, 'cancelar']);
 
 // Financeiro
 Route::get('/financeiro/fluxo-caixa', [FinanceiroController::class, 'fluxoCaixa']);
 
 // Usuários
 Route::get('/usuarios', [UsuarioController::class, 'index']);
 Route::post('/usuarios', [UsuarioController::class, 'store']);
 Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
 Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
 Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
 Route::put('/usuarios/{id}/promover', [UsuarioController::class, 'promoverAdmin']);
 Route::put('/usuarios/{id}/toggle', [UsuarioController::class, 'toggleAtivo']);
 
 // Clientes - gestão pelo admin
 Route::get('/clientes', [AdminClienteController::class, 'index']);
 Route::get('/clientes/{id}', [AdminClienteController::class, 'show']);
 Route::put('/clientes/{id}', [AdminClienteController::class, 'update']);
 
 // Quadras - gestão pelo admin
 Route::get('/quadras', [App\Http\Controllers\Admin\AdminController::class, 'listarQuadras']);
 Route::post('/quadras', [App\Http\Controllers\Admin\AdminController::class, 'storeQuadra']);
 Route::put('/quadras/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateQuadra']);
 
 // Relatórios
 Route::get('/relatorio', [App\Http\Controllers\Admin\AdminController::class, 'relatorioFinanceiro']);
 Route::get('/reservas', [App\Http\Controllers\Admin\AdminController::class, 'todasReservas']);
});
// ===== MÓDULO FUNCIONÁRIO =====
Route::prefix('funcionario')->group(function () {
 Route::get('/agenda', [AgendamentoController::class, 'agendaFuncionario']);
 Route::get('/agenda/semana', [AgendamentoController::class, 'agendaSemana']);
 Route::get('/agenda/dia', [AgendamentoController::class, 'agendaDia']);
 Route::patch('/agendamentos/{id}/confirmar', [AgendamentoController::class, 'confirmar']);
 Route::patch('/agendamentos/{id}/cancelar', [AgendamentoController::class, 'cancelar']);
});
// Password Reset
//Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
//Route::post('/reset-password', [PasswordResetController::class, 'reset']);