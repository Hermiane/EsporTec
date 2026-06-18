<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda do Dia - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --primary: #0F172A;
            --secondary: #3B82F6;
            --accent: #10B981;
            --bg: #F1F5F9; 
            --text: #334155; 
        }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); margin: 0; }
        
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: var(--primary); color: white; padding: 1.5rem; display: flex; flex-direction: column; }
        .sidebar-brand { font-size: 1.4rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2.5rem; display: block; }
        .nav-link { color: #94A3B8; font-weight: 500; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; transition: all 0.2s; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        
        .main { flex: 1; padding: 2rem; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--primary); margin: 0; }
        .badge-role { background: var(--secondary); color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: var(--primary); margin: 0.5rem 0; }
        .stat-label { font-size: 0.85rem; color: #64748B; font-weight: 500; }
        
        .agenda-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom th { text-align: left; padding: 1rem; color: #64748B; font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid #E2E8F0; }
        .table-custom td { padding: 1rem; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .dot-green { background: var(--accent); }
        .dot-yellow { background: #F59E0B; }
        .dot-red { background: #EF4444; }
        
        .btn-action { padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; border: none; cursor: pointer; font-weight: 600; margin-right: 0.3rem; display: inline-flex; align-items: center; gap: 0.3rem; }
        .btn-checkin { background: rgba(16, 185, 129, 0.1); color: var(--accent); }
        .btn-checkin:hover { background: var(--accent); color: white; }
        .btn-report { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
        .btn-report:hover { background: #EF4444; color: white; }
        .btn-pay { background: rgba(59,130,246,0.1); color: var(--secondary); }
        .btn-pay:hover { background: var(--secondary); color: white; }
        
        .badge-payment { padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .badge-paid { background: rgba(16,185,129,0.15); color: var(--accent); }
        .badge-pending { background: rgba(245,158,11,0.15); color: #F59E0B; }
        
        @media (max-width: 992px) { .sidebar { display: none; } }
    </style>
</head>
<body>

<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand">EsporTec <span style="font-size:0.8rem; opacity:0.7;">Área do Funcionário</span></a>
        <nav>
            <a href="/painel-funcionario" class="nav-link active"><i class="bi bi-grid"></i> Agenda do Dia</a>
            <a href="/funcionario/perfil" class="nav-link"><i class="bi bi-person"></i> Meu Perfil</a>
            <a href="#" class="nav-link" onclick="alert('Agenda Completa: Filtro por data/mês será integrado ao backend')"><i class="bi bi-calendar-check"></i> Agenda Completa</a>
            <a href="#" class="nav-link" onclick="alert('Lista de Clientes: Será puxada da tabela users (role=cliente)')"><i class="bi bi-people"></i> Clientes</a>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalManutencao"><i class="bi bi-tools"></i> Manutenção</a>
        </nav>
        <div style="margin-top: auto;">
            <a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <div class="header">
            <div>
                <h1>Agenda do Dia</h1>
                <p class="text-muted mb-0">Terça-feira, 14 de Junho de 2026</p>
            </div>
            <span class="badge-role">Funcionário Ativo</span>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Reservas Hoje</div>
                <div class="stat-value">12</div>
                <small class="text-success"><i class="bi bi-arrow-up"></i> 2 confirmadas</small>
            </div>
            <div class="stat-card">
                <div class="stat-label">Receita do Dia</div>
                <div class="stat-value">R$ 1.450</div>
                <small class="text-muted">Acumulado</small>
            </div>
            <div class="stat-card">
                <div class="stat-label">Quadras Ativas</div>
                <div class="stat-value">3/4</div>
                <small class="text-warning"><i class="bi bi-wrench"></i> 1 em manutenção</small>
            </div>
            <div class="stat-card">
                <div class="stat-label">Próximo Check-in</div>
                <div class="stat-value">14:00</div>
                <small class="text-muted">Society Premium</small>
            </div>
        </div>

        <!-- Agenda do Dia (RF10: Coluna Pagamento) -->
        <div class="agenda-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Partidas de Hoje</h4>
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalReservaManual">
                    <i class="bi bi-plus"></i> Reserva Manual
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Horário</th>
                            <th>Quadra</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Pagamento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">09:00 - 10:00</td>
                            <td>Futsal Arena</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Pedro+S&background=random&size=24" class="rounded-circle">
                                    <span>Pedro Santos</span>
                                </div>
                            </td>
                            <td><span class="status-dot dot-green"></span> Em Jogo</td>
                            <td><span class="badge-payment badge-paid">Pago (PIX)</span></td>
                            <td>
                                <button class="btn-action btn-report" onclick="alert('Relatório de manutenção aberto para Futsal Arena.')">
                                    <i class="bi bi-tools"></i> Manutenção
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">10:00 - 11:30</td>
                            <td>Beach Tennis #1</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Ana+L&background=random&size=24" class="rounded-circle">
                                    <span>Ana Lima</span>
                                </div>
                            </td>
                            <td><span class="status-dot dot-yellow"></span> Pendente</td>
                            <td>
                                <span class="badge-payment badge-pending" id="pag-status-123">Pendente (Dinheiro)</span>
                            </td>
                            <td>
                                <button class="btn-action btn-pay" onclick="atualizarPagamento('123')">
                                    <i class="bi bi-check-circle"></i> Confirmar Pgto
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">14:00 - 15:30</td>
                            <td>Society Premium</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Grupo+FC&background=random&size=24" class="rounded-circle">
                                    <span>Grupo F.C. Unidos</span>
                                </div>
                            </td>
                            <td><span class="status-dot dot-green"></span> Confirmada</td>
                            <td><span class="badge-payment badge-paid">Pago (Cartão)</span></td>
                            <td>
                                <button class="btn-action btn-checkin" onclick="checkin(this)">
                                    <i class="bi bi-check-circle"></i> Confirmar Chegada
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">19:00 - 20:30</td>
                            <td class="text-muted">Society Premium</td>
                            <td class="text-muted">João Silva</td>
                            <td><span class="status-dot" style="background:#CBD5E1;"></span> Agendado</td>
                            <td><span class="badge-payment badge-pending">Pendente (PIX)</span></td>
                            <td>
                                <button class="btn-action btn-checkin" style="opacity:0.5; cursor:not-allowed;">Aguardando</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Feedbacks dos Clientes (RF11) -->
        <div class="agenda-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-chat-square-text me-2"></i>Feedbacks Recebidos</h4>
                <span class="badge bg-secondary">Últimos 7 dias</span>
            </div>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Quadra/Data</th>
                            <th>Nota</th>
                            <th>Comentário</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>João Silva</td>
                            <td>Society Premium<br><small class="text-muted">14/06</small></td>
                            <td><span class="text-warning"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span></td>
                            <td>"Gramado impecável e iluminação excelente. Voltaremos semana que vem!"</td>
                            <td><button class="btn btn-sm btn-outline-primary" onclick="alert('Campo de resposta será implementado no backend.')">Responder</button></td>
                        </tr>
                        <tr>
                            <td>Ana Lima</td>
                            <td>Beach Tennis #1<br><small class="text-muted">10/06</small></td>
                            <td><span class="text-warning"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i></span></td>
                            <td>"Ótima quadra, mas o bebedouro estava sem água no último jogo."</td>
                            <td><button class="btn btn-sm btn-outline-primary" onclick="alert('Campo de resposta será implementado no backend.')">Responder</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Manutenção -->
<div class="modal fade" id="modalManutencao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-tools me-2"></i>Reportar Problema / Manutenção</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Quadra</label>
                    <select class="form-select">
                        <option>Futsal Arena</option>
                        <option>Society Premium</option>
                        <option>Beach Tennis #1</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Tipo de Problema</label>
                    <select class="form-select">
                        <option>Iluminação</option>
                        <option>Gramado/Piso</option>
                        <option>Rede/Trave</option>
                        <option>Limpeza</option>
                        <option>Outros</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Descrição</label>
                    <textarea class="form-control" rows="3" placeholder="Descreva o problema..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="alert('Solicitação de manutenção registrada!');bootstrap.Modal.getInstance(document.getElementById('modalManutencao')).hide()">
                    <i class="bi bi-check-circle"></i> Registrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reserva Manual -->
<div class="modal fade" id="modalReservaManual" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-clipboard me-2"></i>Nova Reserva Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Cliente</label>
                    <input type="text" class="form-control" placeholder="Nome do cliente">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Telefone</label>
                    <input type="tel" class="form-control" placeholder="(00) 00000-0000">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium">Quadra</label>
                        <select class="form-select">
                            <option>Futsal Arena</option>
                            <option>Society Premium</option>
                            <option>Beach Tennis #1</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium">Data</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium">Hora Início</label>
                        <input type="time" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium">Hora Fim</label>
                        <input type="time" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Valor (R$)</label>
                    <input type="number" step="0.01" class="form-control" placeholder="0,00">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="alert('Reserva criada com sucesso!');bootstrap.Modal.getInstance(document.getElementById('modalReservaManual')).hide()">
                    <i class="bi bi-check-circle"></i> Criar Reserva
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function checkin(btn) {
        if(confirm('Confirmar chegada do cliente e iniciar o tempo de jogo?')) {
            const row = btn.closest('tr');
            const statusCell = row.cells[3];
            statusCell.innerHTML = '<span class="status-dot dot-green"></span> Em Jogo';
            btn.style.display = 'none';
            
            const actionsCell = row.cells[4];
            const finishBtn = document.createElement('button');
            finishBtn.className = 'btn-action btn-report';
            finishBtn.innerHTML = '<i class="bi bi-flag"></i> Finalizar';
            finishBtn.onclick = function() { alert('Jogo finalizado. Quadra liberada.'); };
            actionsCell.appendChild(finishBtn);
        }
    }

    function atualizarPagamento(id) {
        if(confirm('Confirmar recebimento do pagamento?')) {
            const badge = document.getElementById('pag-status-' + id);
            badge.className = 'badge-payment badge-paid';
            badge.textContent = 'Pago (Confirmado)';
            event.target.style.display = 'none';
        }
    }
</script>
</body>
</html>