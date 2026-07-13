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
            --primary: #1F5C42;
            --secondary: #2D815D;
            --accent: #2D815D;
            --bg: #F1F5F9;
            --text: #334155;
        }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); margin: 0; }

        .layout { display: flex; min-height: 100vh; }
        .sidebar { 
            width: 260px; 
            background: var(--primary); 
            color: white; 
            padding: 1.5rem; 
            display: flex; 
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-brand { 
            font-size: 1.3rem; 
            font-weight: 700; 
            color: white; 
            text-decoration: none; 
            margin-bottom: 2.5rem; 
            display: flex; 
            align-items: center; 
            gap: 0.6rem;
            padding: 0.5rem;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
        }
        .sidebar-brand i { font-size: 1.8rem; }
        .sidebar-brand span { 
            font-size: 0.75rem; 
            opacity: 0.85; 
            display: block;
            font-weight: 400;
            margin-top: -0.2rem;
        }
        .nav-link { 
            color: #94A3B8; 
            font-weight: 500; 
            padding: 0.8rem 1rem; 
            border-radius: 8px; 
            margin-bottom: 0.5rem; 
            display: flex; 
            align-items: center; 
            gap: 0.8rem; 
            transition: all 0.2s; 
            text-decoration: none; 
        }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }

        .main { 
            flex: 1; 
            padding: 2rem; 
            overflow-y: auto;
            margin-left: 260px;
        }
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

        .btn-action { 
            padding: 0.4rem 0.7rem; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            border: none; 
            cursor: pointer; 
            font-weight: 600; 
            margin-right: 0.3rem; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.3rem;
            white-space: nowrap;
        }
        .btn-checkin { background: rgba(16, 185, 129, 0.1); color: var(--accent); }
        .btn-checkin:hover { background: var(--accent); color: white; }
        .btn-report { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
        .btn-report:hover { background: #EF4444; color: white; }
        .btn-pay { background: rgba(59,130,246,0.1); color: var(--secondary); }
        .btn-pay:hover { background: var(--secondary); color: white; }

        .badge-payment { 
            padding: 0.4rem 0.7rem; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            line-height: 1.4;
        }
        .badge-paid { background: rgba(16,185,129,0.15); color: var(--accent); }
        .badge-pending { background: rgba(245,158,11,0.15); color: #F59E0B; }

        /* Ajuste para telas menores */
        @media (max-width: 1200px) {
            .btn-action { padding: 0.3rem 0.5rem; font-size: 0.7rem; }
            .table-custom td { padding: 0.75rem 0.5rem; }
            .badge-payment { padding: 0.3rem 0.5rem; font-size: 0.7rem; }
        }
        @media (max-width: 992px) { 
            .sidebar { display: none; }
            .main { margin-left: 0; }
            .btn-action { margin-bottom: 0.2rem; }
        }
        @media (max-width: 768px) {
            .table-custom th, .table-custom td { font-size: 0.8rem; padding: 0.5rem; }
            .btn-action { font-size: 0.65rem; padding: 0.25rem 0.4rem; }
            .badge-payment { 
                display: block;
                text-align: center;
                padding: 0.5rem;
                margin: 0.2rem 0;
            }
        }
    </style>
</head>
<body>

<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <span>Área do Funcionário</span>
            </div>
        </a>
        <nav>
            <a href="/painel-funcionario" class="nav-link active"><i class="bi bi-grid"></i> Agenda do Dia</a>
            <a href="/funcionario/perfil" class="nav-link"><i class="bi bi-person"></i> Meu Perfil</a>
            <a href="/funcionario/agenda" class="nav-link"><i class="bi bi-calendar-check"></i> Agenda</a>
            <a href="#feedbacksClientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="#modalManutencao" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalManutencao"><i class="bi bi-tools"></i> Manutenção</a>
        </nav>
        <div style="margin-top: auto;">
            <a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <div class="header">
            <div>
                <h1><i class="bi bi-calendar-check me-2"></i>Agenda do Dia</h1>
                <p class="text-muted mb-0">Terça-feira, 14 de Junho de 2026</p>
            </div>
            <span class="badge-role"><i class="bi bi-check-circle me-1"></i>Funcionário Ativo</span>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-calendar3 me-1"></i>Reservas Hoje</div>
                <div class="stat-value">12</div>
                <small class="text-success"><i class="bi bi-arrow-up"></i> 2 confirmadas</small>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-cash-coin me-1"></i>Receita do Dia</div>
                <div class="stat-value">R$ 1.450</div>
                <small class="text-muted">Acumulado</small>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-collection me-1"></i>Quadras Ativas</div>
                <div class="stat-value">3/4</div>
                <small class="text-warning"><i class="bi bi-wrench"></i> 1 em manutenção</small>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-clock me-1"></i>Próximo Check-in</div>
                <div class="stat-value">14:00</div>
                <small class="text-muted">Society Premium</small>
            </div>
        </div>

        <!-- Agenda do Dia -->
        <div class="agenda-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-list-ul me-2"></i>Partidas de Hoje</h4>
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
                            <td><span class="badge-payment badge-paid"><i class="bi bi-check2-circle me-1"></i>Pago (PIX)</span></td>
                            <td>
                                <button class="btn-action btn-report" onclick="abrirManutencaoRapida()">
                                    <i class="bi bi-tools"></i> Manutenção
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">10:00 - 11:30</td>
                            <td>Society Descoberta</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Ana+L&background=random&size=24" class="rounded-circle">
                                    <span>Ana Lima</span>
                                </div>
                            </td>
                            <td><span class="status-dot dot-yellow"></span> Pendente</td>
                            <td>
                                <span class="badge-payment badge-pending" id="pag-status-123">
                                    <i class="bi bi-clock me-1"></i>Pendente<br><small>(Dinheiro)</small>
                                </span>
                            </td>
                            <td>
                                <button class="btn-action btn-pay" onclick="atualizarPagamento('123', this)">
                                    <i class="bi bi-check-circle"></i> Confirmar
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
                            <td><span class="badge-payment badge-paid"><i class="bi bi-check2-circle me-1"></i>Pago (Cartão)</span></td>
                            <td>
                                <button class="btn-action btn-checkin" onclick="checkin(this)">
                                    <i class="bi bi-check-circle"></i> Check-in
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">19:00 - 20:30</td>
                            <td class="text-muted">Society Premium</td>
                            <td class="text-muted">João Silva</td>
                            <td><span class="status-dot" style="background:#CBD5E1;"></span> Agendado</td>
                            <td><span class="badge-payment badge-pending"><i class="bi bi-clock me-1"></i>Pendente (PIX)</span></td>
                            <td>
                                <button type="button" class="btn-action btn-checkin" disabled style="opacity:0.5; cursor:not-allowed;">
                                    <i class="bi bi-hourglass"></i> Aguardando
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Feedbacks dos Clientes -->
        <div class="agenda-card" id="feedbacksClientes">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-chat-square-text me-2"></i>Feedbacks Recebidos</h4>
                <span class="badge bg-secondary"><i class="bi bi-calendar-week me-1"></i>Últimos 7 dias</span>
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
                            <td>
                                <button class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalResponderFeedback"
                                        data-cliente="João Silva"
                                        data-comentario="Gramado impecável e iluminação excelente. Voltaremos semana que vem!">
                                    <i class="bi bi-reply"></i> Responder
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ana Lima</td>
                            <td>Society Descoberta<br><small class="text-muted">10/06</small></td>
                            <td><span class="text-warning"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i></span></td>
                            <td>"Ótima quadra, mas o bebedouro estava sem água no último jogo."</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalResponderFeedback"
                                        data-cliente="Ana Lima"
                                        data-comentario="Ótima quadra, mas o bebedouro estava sem água no último jogo.">
                                    <i class="bi bi-reply"></i> Responder
                                </button>
                            </td>
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
                        <option>Society Descoberta</option>
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
                <button type="button" class="btn btn-primary" onclick="registrarManutencao()">
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
                            <option>Society Descoberta</option>
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
                <button type="button" class="btn btn-primary" onclick="criarReservaManual()">
                    <i class="bi bi-check-circle"></i> Criar Reserva
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Responder Feedback -->
<div class="modal fade" id="modalResponderFeedback" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-reply me-2"></i>Responder Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Cliente</label>
                    <p class="form-control-plaintext fw-semibold" id="feedbackCliente">-</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Comentário Original</label>
                    <div class="p-3 bg-light rounded" id="feedbackComentario">-</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Sua Resposta</label>
                    <textarea class="form-control" id="respostaFeedback" rows="4" placeholder="Digite sua resposta ao cliente..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="enviarRespostaFeedback()">
                    <i class="bi bi-send me-2"></i>Enviar Resposta
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    function checkin(btn) {
        if(confirm('Confirmar chegada do cliente e iniciar o tempo de jogo?')) {
            const row = btn.closest('tr');
            const statusCell = row.cells[3];
            statusCell.innerHTML = '<span class="status-dot dot-green"></span> Em Jogo';
            btn.style.display = 'none';

            const actionsCell = row.cells[5];
            const finishBtn = document.createElement('button');
            finishBtn.className = 'btn-action btn-report';
            finishBtn.innerHTML = '<i class="bi bi-flag"></i> Finalizar';
            finishBtn.onclick = function() {
                statusCell.innerHTML = '<span class="status-dot dot-green"></span> Concluído';
                finishBtn.disabled = true;
                finishBtn.innerHTML = '<i class="bi bi-check2"></i> Finalizado';
                esportecToast('Jogo finalizado. Quadra liberada.', 'success');
            };
            actionsCell.appendChild(finishBtn);
            esportecToast('Chegada confirmada e jogo iniciado.', 'success');
        }
    }

    function atualizarPagamento(id, btn) {
        if(confirm('Confirmar recebimento do pagamento?')) {
            const badge = document.getElementById('pag-status-' + id);
            badge.className = 'badge-payment badge-paid';
            badge.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Pago<br><small>(Confirmado)</small>';
            btn.style.display = 'none';
            esportecToast('Pagamento confirmado.', 'success');
        }
    }

    function abrirManutencaoRapida() {
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalManutencao')).show();
    }

    // Carregar dados no modal de resposta de feedback
    document.getElementById('modalResponderFeedback').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const cliente = button.getAttribute('data-cliente');
        const comentario = button.getAttribute('data-comentario');
        
        document.getElementById('feedbackCliente').textContent = cliente;
        document.getElementById('feedbackComentario').textContent = comentario;
        document.getElementById('respostaFeedback').value = '';
    });

    function enviarRespostaFeedback() {
        const resposta = document.getElementById('respostaFeedback').value.trim();
        if (!resposta) {
            esportecToast('Digite uma resposta antes de enviar.', 'warning');
            return;
        }
        
        bootstrap.Modal.getInstance(document.getElementById('modalResponderFeedback')).hide();
        esportecToast('Resposta enviada ao cliente com sucesso.', 'success');
        
        // Atualiza visualmente o botão na tabela
        setTimeout(() => {
            const btns = document.querySelectorAll('[data-bs-target="#modalResponderFeedback"]');
            btns.forEach(btn => {
                if (btn.getAttribute('data-cliente') === document.getElementById('feedbackCliente').textContent) {
                    btn.innerHTML = '<i class="bi bi-check2"></i> Respondido';
                    btn.className = 'btn btn-sm btn-outline-success';
                    btn.disabled = true;
                }
            });
        }, 300);
    }

    function registrarManutencao() {
        bootstrap.Modal.getInstance(document.getElementById('modalManutencao')).hide();
        esportecToast('Solicitação de manutenção registrada.', 'success');
    }

    function criarReservaManual() {
        bootstrap.Modal.getInstance(document.getElementById('modalReservaManual')).hide();
        esportecToast('Reserva manual criada com sucesso.', 'success');
    }
</script>
</body>
</html>
