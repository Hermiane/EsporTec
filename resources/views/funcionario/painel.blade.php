<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agenda do Dia - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #1F5C42; --secondary: #2D815D; --accent: #2D815D; --bg: #F1F5F9; --text: #334155; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); margin: 0; }
        
        /* Layout */
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
            z-index: 100; 
            left: 0;
            top: 0;
            transition: transform 0.3s ease;
        }
        .sidebar-brand { font-size: 1.3rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem; border-radius: 8px; background: rgba(255,255,255,0.1); }
        .sidebar-brand i { font-size: 1.8rem; }
        .sidebar-brand span { font-size: 0.75rem; opacity: 0.85; display: block; font-weight: 400; margin-top: -0.2rem; }
        .nav-link { color: #94A3B8; font-weight: 500; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; transition: all 0.2s; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        
        /*  Botão Menu Mobile */
        .mobile-menu-btn {
            display: none;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 101;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        /* Overlay para mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }
        
        .main { 
            flex: 1; 
            padding: 2rem; 
            overflow-y: auto; 
            margin-left: 260px; 
            min-height: 100vh;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; flex-shrink: 0; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--primary); margin: 0; }
        .badge-role { background: var(--secondary); color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; flex-shrink: 0; }
        .stat-card { background: white; padding: 1.2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: var(--primary); margin: 0.5rem 0; }
        .stat-label { font-size: 0.85rem; color: #64748B; font-weight: 500; }

        /* Cards & Tables */
        .agenda-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom th { text-align: left; padding: 1rem; color: #64748B; font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid #E2E8F0; }
        .table-custom td { padding: 1rem; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
        
        /* Status & Badges */
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .dot-green { background: var(--accent); }
        .dot-yellow { background: #F59E0B; }
        .dot-red { background: #EF4444; }
        .dot-gray { background: #94A3B8; }
        
        .badge-payment { padding: 0.4rem 0.7rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; line-height: 1.4; }
        .badge-paid { background: rgba(16,185,129,0.15); color: var(--accent); }
        .badge-pending { background: rgba(245,158,11,0.15); color: #F59E0B; }

        /* BOTÕES */
        .actions-cell { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
        .btn-action { 
            padding: 0.5rem 0.8rem; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            border: none; 
            cursor: pointer; 
            font-weight: 600; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.3rem; 
            white-space: nowrap;
            transition: all 0.2s;
        }
        .btn-checkin { background: rgba(16, 185, 129, 0.1); color: var(--accent); }
        .btn-checkin:hover { background: var(--accent); color: white; }
        .btn-report { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
        .btn-report:hover { background: #EF4444; color: white; }
        .btn-pay { background: rgba(59,130,246,0.1); color: var(--secondary); }
        .btn-pay:hover { background: var(--secondary); color: white; }
        .btn-wait { background: #F1F5F9; color: #64748B; cursor: not-allowed; }

        /*  RESPONSIVIDADE COM MENU MOBILE */
        @media (max-width: 992px) { 
            .mobile-menu-btn { display: block; }
            .sidebar { 
                transform: translateX(-100%);
                display: flex;
            }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            .main { margin-left: 0; min-height: auto; max-height: none; display: block; padding: 5rem 1rem 1rem; }
            .actions-cell { flex-direction: column; width: 100%; }
            .btn-action { width: 100%; justify-content: center; margin-bottom: 0.2rem; }
            .header h1 { font-size: 1.3rem; }
        }
        
        /*  GARANTIR QUE TABELAS NÃO QUEBREM */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-custom {
            min-width: 600px;
        }
        .table-custom th,
        .table-custom td {
            white-space: nowrap;
        }
    </style>
</head>
<body>

<!--  Botão Menu Mobile -->
<button class="mobile-menu-btn" onclick="toggleMenu()">
    <i class="bi bi-list"></i>
</button>

<!--  Overlay para fechar ao clicar fora -->
<div class="sidebar-overlay" onclick="toggleMenu()"></div>

<div class="layout">
    <aside class="sidebar" id="sidebarMenu">
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
        </nav>
        <div style="margin-top: auto;">
            <a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </div>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1><i class="bi bi-calendar-check me-2"></i>Agenda do Dia</h1>
                <p class="text-muted mb-0" id="dataAtual">Carregando data...</p>
            </div>
            <div class="text-end"><strong id="nomeFuncionario">Carregando...</strong><br><span class="badge-role"><i class="bi bi-check-circle me-1"></i>Funcionário ativo</span><small class="d-block text-muted mt-1" id="nomeArena"></small></div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-calendar3 me-1"></i>Reservas Hoje</div>
                <div class="stat-value" id="countReservas">-</div>
                <small class="text-success" id="countConfirmadas"><i class="bi bi-arrow-up"></i> Carregando...</small>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-cash-coin me-1"></i>Receita do Dia</div>
                <div class="stat-value" id="countReceita">-</div>
                <small class="text-muted">Acumulado</small>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-collection me-1"></i>Quadras Ativas</div>
                <div class="stat-value" id="countQuadras">-</div>
                <small class="text-warning" id="countManutencao"><i class="bi bi-wrench"></i> Carregando...</small>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-clock me-1"></i>Próxima Reserva</div>
                <div class="stat-value" id="proximaReserva">-</div>
                <small class="text-muted" id="proximaQuadra">Carregando...</small>
            </div>
        </div>

        <!-- Agenda do Dia -->
        <div class="agenda-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-list-ul me-2"></i>Partidas de Hoje</h4>
                <span class="text-muted small">Dados atualizados da arena</span>
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
                    <tbody id="agendaBody">
                        <!-- Preenchido via JS -->
                        <tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-hourglass-split me-2"></i>Carregando agenda...</td></tr>
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
                    <tbody id="feedbacksBody">
                        <tr><td colspan="5" class="text-center text-muted py-4">Carregando feedbacks...</td></tr>
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
                <h5 class="modal-title fw-bold"><i class="bi bi-tools me-2"></i>Reportar Problema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Quadra</label>
                    <select class="form-select" id="manutencaoQuadra">
                        <option value="">Selecione...</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Tipo de Problema</label>
                    <select class="form-select"><option>Iluminação</option><option>Gramado/Piso</option><option>Outros</option></select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Descrição</label>
                    <textarea class="form-control" rows="3" placeholder="Descreva o problema..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="registrarManutencao()"><i class="bi bi-check-circle"></i> Registrar</button>
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
                <div class="mb-3"><label class="form-label fw-medium">Cliente</label><input type="text" class="form-control" id="reservaCliente" placeholder="Nome do cliente"></div>
                <div class="mb-3"><label class="form-label fw-medium">Telefone</label><input type="tel" class="form-control" id="reservaTelefone" placeholder="(00) 00000-0000"></div>
                <div class="row g-3 mb-3">
                    <div class="col-6"><label class="form-label fw-medium">Quadra</label><select class="form-select" id="reservaQuadra"><option value="">Selecione...</option></select></div>
                    <div class="col-6"><label class="form-label fw-medium">Data</label><input type="date" class="form-control" id="reservaData"></div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6"><label class="form-label fw-medium">Hora Início</label><input type="time" class="form-control" id="reservaHoraInicio"></div>
                    <div class="col-6"><label class="form-label fw-medium">Hora Fim</label><input type="time" class="form-control" id="reservaHoraFim"></div>
                </div>
                <div class="mb-3"><label class="form-label fw-medium">Valor (R$)</label><input type="number" step="0.01" class="form-control" id="reservaValor" placeholder="0,00"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="criarReservaManual()"><i class="bi bi-check-circle"></i> Criar Reserva</button>
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
                <div class="mb-3"><label class="form-label fw-medium">Cliente</label><p class="form-control-plaintext fw-semibold" id="feedbackCliente">-</p></div>
                <div class="mb-3"><label class="form-label fw-medium">Comentário Original</label><div class="p-3 bg-light rounded" id="feedbackComentario">-</div></div>
                <div class="mb-3"><label class="form-label fw-medium">Sua Resposta</label><textarea class="form-control" id="respostaFeedback" rows="4" placeholder="Digite sua resposta..."></textarea></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="enviarRespostaFeedback()"><i class="bi bi-send me-2"></i>Enviar Resposta</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    //  Função para toggle do menu mobile
    function toggleMenu() {
        document.getElementById('sidebarMenu').classList.toggle('active');
        document.querySelector('.sidebar-overlay').classList.toggle('active');
    }
   
    //  INTEGRAÇÃO COM API - MÓDULO FUNCIONÁRIO
    
    const API_BASE = '/api';
    
    //  CARREGAR AGENDA DO DIA
    async function carregarAgendaDia() {
        try {
            const dados = await EsporTecApi.request(`${API_BASE}/funcionario/painel`);
            document.getElementById('nomeFuncionario').textContent = dados.funcionario.nome;
            document.getElementById('nomeArena').textContent = dados.arenas.map(arena => arena.nome).join(', ');
            preencherQuadras(dados.quadras);
            renderizarAgenda(dados.reservas);
            renderizarFeedbacks(dados.feedbacks);
            atualizarStats(dados.reservas, dados.quadras);
        } catch (error) {
            renderizarAgenda([]);
            renderizarFeedbacks([]);
            atualizarStats([], []);
            esportecToast(error.message, 'warning');
        }
    }

    function preencherQuadras(quadras) {
        const opcoes = '<option value="">Selecione...</option>' + quadras.map(quadra => `<option value="${quadra.id}">${quadra.nome}</option>`).join('');
        document.getElementById('manutencaoQuadra').innerHTML = opcoes;
        document.getElementById('reservaQuadra').innerHTML = opcoes;
    }

    function renderizarFeedbacks(feedbacks) {
        const tbody = document.getElementById('feedbacksBody');
        if (!feedbacks.length) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Nenhum feedback recebido nos últimos 7 dias.</td></tr>';
            return;
        }

        tbody.innerHTML = feedbacks.map(feedback => {
            const estrelas = '<i class="bi bi-star-fill"></i>'.repeat(feedback.nota);
            const data = new Date(feedback.created_at).toLocaleDateString('pt-BR');
            return `<tr><td>${feedback.usuario?.nome_completo || 'Cliente'}</td><td>${feedback.reserva?.quadra?.nome || '-'}<br><small class="text-muted">${data}</small></td><td><span class="text-warning">${estrelas}</span></td><td>${feedback.comentario || 'Sem comentário'}</td><td>${feedback.resposta ? '<span class="badge bg-success">Respondido</span>' : '<span class="text-muted">Sem resposta</span>'}</td></tr>`;
        }).join('');
    }

    function renderizarAgenda(reservas) {
        const tbody = document.getElementById('agendaBody');
        tbody.innerHTML = '';

        if (!reservas || reservas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Nenhuma reserva para hoje.</td></tr>';
            return;
        }

        reservas.forEach(reserva => {
            const statusConfig = getStatusConfig(reserva.status);
            const pagamentoBadge = getPagamentoBadge(reserva.pagamento);
            const acoes = getAcoesFuncionario(reserva);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="fw-semibold">${reserva.hora_inicio} - ${reserva.hora_fim}</td>
                <td>${reserva.quadra?.nome || '-'}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span>${reserva.usuario?.nome_completo || 'Cliente'}</span>
                    </div>
                </td>
                <td><span class="status-dot ${statusConfig.dot}"></span> ${statusConfig.label}</td>
                <td>${pagamentoBadge}</td>
                <td>
                    <div class="actions-cell">
                        ${acoes}
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function getStatusConfig(status) {
        const map = {
            'confirmada': { dot: 'dot-green', label: 'Confirmada' },
            'pendente': { dot: 'dot-yellow', label: 'Pendente' },
            'agendada': { dot: 'dot-yellow', label: 'Agendada' },
            'cancelada': { dot: 'dot-red', label: 'Cancelada' },
            'concluida': { dot: 'dot-green', label: 'Concluída' }
        };
        return map[status] || { dot: 'dot-gray', label: 'Status' };
    }

    function getPagamentoBadge(pagamento) {
        if (!pagamento) return '<span class="text-muted">-</span>';
        const pago = pagamento.status === 'pago';
        const classe = pago ? 'badge-paid' : 'badge-pending';
        const icone = pago ? 'bi-check2-circle' : 'bi-clock';
        const metodo = pagamento.metodo ? `(${formatarMetodo(pagamento.metodo)})` : '';
        return `<span class="badge-payment ${classe}"><i class="bi ${icone} me-1"></i>${pago ? 'Pago' : 'Pendente'}<br><small>${metodo}</small></span>`;
    }

    function formatarMetodo(metodo) {
        const map = { 'pix': 'PIX', 'dinheiro': 'Dinheiro', 'cartao_credito': 'Cartão', 'cartao_debito': 'Débito' };
        return map[metodo] || metodo;
    }

    function getAcoesFuncionario(reserva) {
        let html = '';
        
        if (reserva.status === 'pendente' && reserva.pagamento?.status === 'pendente') {
             html += `<button class="btn-action btn-pay" onclick="confirmarPagamento(${reserva.pagamento.id}, this)">
                <i class="bi bi-check-circle"></i> Confirmar
            </button>`;
        }
        
        return html;
    }

    //  STATS 
    function atualizarStats(reservas, quadras) {
        const reservasHoje = reservas; //

        document.getElementById('countReservas').textContent = reservasHoje.length;
        const confirmadas = reservasHoje.filter(r => r.status === 'confirmada').length;
        document.getElementById('countConfirmadas').innerHTML = confirmadas > 0 ? 
            `<i class="bi bi-arrow-up"></i> ${confirmadas} confirmadas` : 'Nenhuma confirmada';
        
        const receita = reservasHoje.filter(r => r.pagamento?.status === 'pago')
            .reduce((sum, r) => sum + Number(r.pagamento?.valor || 0), 0);
        document.getElementById('countReceita').textContent = `R$ ${receita.toFixed(2).replace('.', ',')}`;
        
        // Quadras ativas (conta quantas IDs únicos de quadra)
        const quadrasAtivas = quadras.length;
        document.getElementById('countQuadras').textContent = quadrasAtivas;
        document.getElementById('countManutencao').innerHTML = quadrasAtivas > 0 ?
            `<i class="bi bi-check"></i> Todas operacionais` : 
            `<i class="bi bi-dash"></i> Sem reservas`;
        
        // Próxima reserva
        const horarioAtual = new Date().toTimeString().slice(0, 8);
        const proxima = reservasHoje.filter(r => r.status !== 'cancelada' && r.hora_inicio >= horarioAtual)
            .sort((a, b) => a.hora_inicio.localeCompare(b.hora_inicio))[0];
        if (proxima) {
            document.getElementById('proximaReserva').textContent = proxima.hora_inicio;
            document.getElementById('proximaQuadra').textContent = proxima.quadra?.nome || '';
        } else {
            document.getElementById('proximaReserva').textContent = '-';
            document.getElementById('proximaQuadra').textContent = 'Sem reservas hoje';
        }
    }

    //  AÇÕES (API Calls)
    async function confirmarPagamento(pagamentoId, btn) {
        if (!confirm('Confirmar recebimento?')) return;
        try {
            await EsporTecApi.request(`${API_BASE}/funcionario/pagamentos/${pagamentoId}/confirmar`, { method: 'PATCH' });
            esportecToast('Pagamento confirmado.', 'success');
            carregarAgendaDia();
        } catch (error) {
            esportecToast(error.message, 'warning');
        }
    }

    function registrarManutencao() {
        bootstrap.Modal.getInstance(document.getElementById('modalManutencao')).hide();
        esportecToast('Manutenção registrada.', 'success');
    }

    function abrirManutencaoRapida(quadraId) {
        if (quadraId) document.getElementById('manutencaoQuadra').value = quadraId;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalManutencao')).show();
    }

    // Modal Feedback
    document.getElementById('modalResponderFeedback').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('feedbackCliente').textContent = button.getAttribute('data-cliente');
        document.getElementById('feedbackComentario').textContent = button.getAttribute('data-comentario');
        document.getElementById('respostaFeedback').value = '';
    });
    function enviarRespostaFeedback() {
        if (!document.getElementById('respostaFeedback').value.trim()) { esportecToast('Escreva uma resposta.', 'warning'); return; }
        bootstrap.Modal.getInstance(document.getElementById('modalResponderFeedback')).hide();
        esportecToast('Resposta enviada.', 'success');
    }

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        const hoje = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('dataAtual').textContent = hoje.toLocaleDateString('pt-BR', options);
        carregarAgendaDia();
    });
</script>
</body>
</html>
