<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ArenaCadastroController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\Cliente\NotificacaoController as ClienteNotificacaoController;

use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FinanceiroController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\ClienteController as AdminClienteController;
use App\Http\Controllers\Admin\ConfiguracaoController;
use App\Http\Controllers\Admin\NotificacaoController;
use App\Http\Controllers\Auth\PasswordResetController;
// MÓDULO CLIENTE
// REQUISITO 1: Cadastro autônomo
// REQUISITO 4: Histórico

Route::post('/auth/registro', [AuthController::class, 'registrar']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/auth/recuperar-senha', [AuthController::class, 'solicitarReset']);
    Route::post('/auth/redefinir-senha', [AuthController::class, 'redefinirSenha']);
    Route::post('/auth/verificar-codigo', [AuthController::class, 'verificarCodigoReset']);
});
Route::post('/arenas/solicitacoes', [ArenaCadastroController::class, 'solicitar']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/auth/me', [AuthController::class, 'me']);
Route::middleware('auth:sanctum')->put('/auth/perfil', [AuthController::class, 'atualizarPerfil']);
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

Route::middleware(['auth:sanctum', 'papel:super_admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [ArenaCadastroController::class, 'dashboard']);
    Route::get('/arenas', [ArenaCadastroController::class, 'index']);
    Route::get('/super-administradores', [ArenaCadastroController::class, 'superAdministradores']);
    Route::get('/usuarios/buscar', [ArenaCadastroController::class, 'buscarUsuarioSuperAdmin']);
    Route::post('/super-administradores', [ArenaCadastroController::class, 'promoverSuperAdmin']);
    Route::patch('/arenas/{arena}/aprovar', [ArenaCadastroController::class, 'aprovar']);
    Route::patch('/arenas/{arena}/recusar', [ArenaCadastroController::class, 'recusar']);
    Route::patch('/arenas/{arena}/ativacao', [ArenaCadastroController::class, 'alterarAtivacao']);
    Route::delete('/arenas/{arena}', [ArenaCadastroController::class, 'excluir']);
});


// ===== ROTAS DO CLIENTE LOGADO =====
Route::middleware('auth:sanctum')->prefix('cliente')->group(function () {
 Route::get('/quadras', [ReservaController::class, 'quadrasDisponiveis']);
 Route::get('/quadras/{id}/horarios', [ReservaController::class, 'horariosDisponiveis']);
 Route::get('/reservas', [ReservaController::class, 'minhasReservas']);
 Route::post('/reservas/{reserva}/avaliacao', [ReservaController::class, 'avaliar']);
 Route::post('/pagamentos', [PagamentoController::class, 'store']);
 Route::get('/pagamentos/reservas/{reserva_id}', [PagamentoController::class, 'porReserva']);
 Route::patch('/reservas/{id}/remarcar', [ReservaController::class, 'remarcar']);
 Route::post('/reservas/{reserva}/partida', [PartidaController::class, 'criarLink']);
 Route::delete('/partidas/{partida}/jogadores/{jogador}', [PartidaController::class, 'removerJogador']);
 Route::get('/notificacoes', [ClienteNotificacaoController::class, 'index']);
 Route::patch('/notificacoes/{notificacao}/ler', [ClienteNotificacaoController::class, 'ler']);
});

// ===== ROTAS DO FUNCIONÁRIO/ADMIN =====
use App\Http\Controllers\PagamentoController as FuncPagamentoController;
Route::middleware(['auth:sanctum', 'papel:funcionario'])->prefix('funcionario')->group(function () {
    Route::get('/painel', [AgendaController::class, 'painel']);
    Route::get('/perfil', [AgendaController::class, 'perfil']);
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
 Route::get('/dashboard', [AdminController::class, 'dashboard']);
 Route::get('/agendamentos', [AdminController::class, 'agendamentos']);
 Route::patch('/reservas/{id}/confirmar', [AdminController::class, 'confirmarReserva']);
 Route::patch('/pagamentos/{id}/confirmar', [PagamentoController::class, 'confirmar']);
 Route::patch('/pagamentos/{id}/recusar', [PagamentoController::class, 'recusar']);
 Route::get('/configuracoes', [ConfiguracaoController::class, 'show']);
 Route::put('/configuracoes', [ConfiguracaoController::class, 'update']);
 Route::get('/notificacoes', [NotificacaoController::class, 'index']);
 Route::patch('/notificacoes/marcar-todas', [NotificacaoController::class, 'marcarTodas']);
 Route::patch('/notificacoes/{notificacao}/ler', [NotificacaoController::class, 'ler']);
 
 // Financeiro
 Route::get('/financeiro', [FinanceiroController::class, 'resumo']);
 Route::get('/financeiro/fluxo-caixa', [FinanceiroController::class, 'fluxoCaixa']);
 Route::get('/financeiro/despesas', [FinanceiroController::class, 'despesas']);
 Route::post('/financeiro/despesas', [FinanceiroController::class, 'registrarDespesa']);
 Route::put('/financeiro/politica', [FinanceiroController::class, 'politica']);

 
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
 Route::get('/quadras/{id}/horarios', [App\Http\Controllers\Admin\AdminController::class, 'horariosQuadra']);
 Route::put('/quadras/{id}/horarios', [App\Http\Controllers\Admin\AdminController::class, 'salvarHorariosQuadra']);
 Route::get('/bloqueios-quadras', [App\Http\Controllers\Admin\AdminController::class, 'bloqueiosQuadras']);
 Route::post('/bloqueios-quadras', [App\Http\Controllers\Admin\AdminController::class, 'salvarBloqueioQuadra']);
 Route::delete('/bloqueios-quadras/{id}', [App\Http\Controllers\Admin\AdminController::class, 'excluirBloqueioQuadra']);
 
 // Relatórios
 Route::get('/relatorio', [App\Http\Controllers\Admin\AdminController::class, 'relatorioFinanceiro']);
 Route::get('/reservas', [App\Http\Controllers\Admin\AdminController::class, 'todasReservas']);
});
// ===== MÓDULO FUNCIONÁRIO =====
// Password Reset
//Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
//Route::post('/reset-password', [PasswordResetController::class, 'reset']);
