<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestão de Agendamentos - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #0F172A; --primary: #3B82F6; --success: #10B981; --danger: #EF4444; --warning: #F59E0B; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; }
        .sidebar-brand i { font-size: 1.8rem; }
        .sidebar-brand span { font-size: 0.7rem; opacity: 0.6; display: block; margin-top: -0.2rem; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--admin-dark); margin: 0; display: flex; align-items: center; gap: 0.5rem; }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-box { padding: 1.2rem; border-radius: 12px; color: white; display: flex; align-items: center; gap: 1rem; }
        .stat-box.total { background: linear-gradient(135deg, var(--primary), #60A5FA); }
        .stat-box.pending { background: linear-gradient(135deg, var(--warning), #FCD34D); color: #1F2937; }
        .stat-box.confirmed { background: linear-gradient(135deg, var(--success), #34D399); }
        .stat-box.cancelled { background: linear-gradient(135deg, var(--danger), #F87171); }
        .stat-value { font-size: 2rem; font-weight: 700; }
        .stat-label { font-size: 0.9rem; opacity: 0.95; }
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom th { text-align: left; padding: 1rem; background: #F1F5F9; color: #64748B; font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid #E2E8F0; }
        .table-custom td { padding: 1rem; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
        .badge-status { padding: 0.35rem 0.7rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; }
        .badge-pendente { background: #FEF3C7; color: #B45309; }
        .badge-confirmada { background: #D1FAE5; color: #065F46; }
        .badge-cancelada { background: #FEE2E2; color: #991B1B; }
        .badge-concluida { background: #DBEAFE; color: #1E40AF; }
        .badge-pago { background: #DBEAFE; color: #1E40AF; }
        
        .btn-action { 
            padding: 0.4rem 0.6rem; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            border: none; 
            cursor: pointer; 
            margin: 0.15rem; 
            font-weight: 600; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.25rem;
            white-space: nowrap;
        }
        .btn-confirm { background: rgba(16,185,129,0.1); color: var(--success); }
        .btn-confirm:hover { background: var(--success); color: white; }
        .btn-cancel { background: rgba(239,68,68,0.1); color: var(--danger); }
        .btn-cancel:hover { background: var(--danger); color: white; }
        .btn-edit { background: rgba(59,130,246,0.1); color: var(--primary); }
        .btn-edit:hover { background: var(--primary); color: white; }
        
        .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .filter-bar input, .filter-bar select { padding: 0.6rem; border: 1px solid #E2E8F0; border-radius: 8px; }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; }
        
        .actions-cell { display: flex; flex-wrap: wrap; gap: 0.2rem; align-items: center; }
        
        @media (max-width: 1400px) {
            .btn-action { padding: 0.35rem 0.5rem; font-size: 0.7rem; margin: 0.1rem; }
            .table-custom td { padding: 0.8rem 0.6rem; font-size: 0.9rem; }
        }
        @media (max-width: 1200px) {
            .actions-cell { flex-direction: column; align-items: flex-start; }
            .btn-action { width: 100%; justify-content: flex-start; margin: 0.1rem 0; }
            .badge-status { font-size: 0.7rem; padding: 0.3rem 0.5rem; }
        }
        @media (max-width: 992px) {
            .layout { display: block; }
            .sidebar { width: 100%; }
            .main { padding: 1rem; }
            .card-custom { overflow-x: auto; }
            .table-custom { min-width: 1100px; }
            .filter-bar input, .filter-bar select { width: 100% !important; }
            .actions-cell { flex-direction: row; flex-wrap: wrap; }
            .btn-action { width: auto; }
        }
        @media (max-width: 768px) {
            .table-custom th, .table-custom td { font-size: 0.8rem; padding: 0.5rem; }
            .btn-action { font-size: 0.65rem; padding: 0.25rem 0.4rem; }
            .stat-value { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <span>Admin da arena</span>
            </div>
        </a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link active"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>
    <main class="main">
        <div class="header">
            <h1><i class="bi bi-calendar-check"></i>Gestão de Agendamentos</h1>
            <button class="btn-primary-admin" data-bs-toggle="modal" data-bs-target="#modalReserva">
                <i class="bi bi-plus-lg"></i>Nova Reserva
            </button>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-box total">
                <i class="bi bi-calendar-event fs-1"></i>
                <div>
                    <div class="stat-value" id="countTotal">-</div>
                    <div class="stat-label">Total do Mês</div>
                </div>
            </div>
            <div class="stat-box pending">
                <i class="bi bi-clock-history fs-1"></i>
                <div>
                    <div class="stat-value" id="countPendentes">-</div>
                    <div class="stat-label">Pendentes</div>
                </div>
            </div>
            <div class="stat-box confirmed">
                <i class="bi bi-check-circle fs-1"></i>
                <div>
                    <div class="stat-value" id="countConfirmadas">-</div>
                    <div class="stat-label">Confirmadas</div>
                </div>
            </div>
            <div class="stat-box cancelled">
                <i class="bi bi-x-circle fs-1"></i>
                <div>
                    <div class="stat-value" id="countCanceladas">-</div>
                    <div class="stat-label">Canceladas</div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filter-bar">
            <input type="date" class="form-control" id="filtroData" style="width: 200px;">
            <select class="form-select" id="filtroQuadra" style="width: 200px;">
                <option value="">Todas as Quadras</option>
            </select>
            <select class="form-select" id="filtroStatus" style="width: 200px;">
                <option value="">Todos os Status</option>
                <option value="pendente">Pendente</option>
                <option value="confirmada">Confirmada</option>
                <option value="cancelada">Cancelada</option>
                <option value="concluida">Concluída</option>
            </select>
            <input type="text" id="filtroCliente" placeholder="Buscar cliente..." class="form-control" style="width: 250px;">
        </div>

        <!-- Tabela -->
        <div class="card-custom">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data/Hora</th>
                        <th>Quadra</th>
                        <th>Cliente</th>
                        <th>Telefone</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Pagamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaAgendamentos">
                    <tr><td colspan="9" class="text-center text-muted py-4"><i class="bi bi-hourglass-spin me-2"></i>Carregando agendamentos...</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Nova Reserva -->
<div class="modal fade" id="modalReserva" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Nova Reserva Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-person me-1"></i>Cliente</label>
                    <input type="text" class="form-control" id="reservaCliente" placeholder="Nome do cliente">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium"><i class="bi bi-grid-3x3-gap me-1"></i>Quadra</label>
                        <select class="form-select" id="reservaQuadra">
                            <option value="">Selecione...</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium"><i class="bi bi-calendar me-1"></i>Data</label>
                        <input type="date" class="form-control" id="reservaData">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium"><i class="bi bi-clock me-1"></i>Hora Início</label>
                        <input type="time" class="form-control" id="reservaHoraInicio">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium"><i class="bi bi-clock me-1"></i>Hora Fim</label>
                        <input type="time" class="form-control" id="reservaHoraFim">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-cash-coin me-1"></i>Valor (R$)</label>
                    <input type="number" step="0.01" class="form-control" id="reservaValor" placeholder="0,00">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarReserva">
                    <i class="bi bi-check-circle"></i> Criar Reserva
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN AGENDAMENTOS
    
    const API_BASE = '/api';
    
    // Mock data para fallback
    const MOCK_AGENDAMENTOS = [
        { id: 1234, data: '2026-06-14', hora_inicio: '14:00', hora_fim: '15:30', status: 'confirmada', quadra: { nome: 'Society Premium' }, usuario: { nome: 'João Silva', telefone: '(11) 99999-9999' }, pagamento: { status: 'pendente', metodo: 'dinheiro', valor: 225.00 } },
        { id: 1235, data: '2026-06-15', hora_inicio: '19:00', hora_fim: '20:00', status: 'pendente', quadra: { nome: 'Futsal Arena' }, usuario: { nome: 'Pedro Santos', telefone: '(11) 98888-8888' }, pagamento: { status: 'pendente', metodo: 'pix', valor: 120.00 } },
        { id: 1236, data: '2026-06-16', hora_inicio: '10:00', hora_fim: '11:00', status: 'concluida', quadra: { nome: 'Beach Tennis #1' }, usuario: { nome: 'Ana Lima', telefone: '(11) 97777-7777' }, pagamento: { status: 'pago', metodo: 'cartao_credito', valor: 100.00 } }
    ];
    
    const MOCK_QUADRAS = [
        { id: 1, nome: 'Futsal Arena' },
        { id: 2, nome: 'Society Premium' },
        { id: 3, nome: 'Beach Tennis #1' }
    ];

    //  CARREGAR AGENDAMENTOS - API: GET /api/admin/agendamentos
    async function carregarAgendamentos() {
        try {
            const response = await fetch(`${API_BASE}/admin/agendamentos`);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const agendamentos = await response.json();
            
            if (!agendamentos || agendamentos.length === 0) {
                renderizarTabela([]);
                atualizarStats([]);
                return;
            }
            
            renderizarTabela(agendamentos);
            atualizarStats(agendamentos);
            console.log(' Agendamentos carregados:', agendamentos.length);
        } catch (error) {
            console.error('Erro ao carregar agendamentos:', error.message);
            renderizarTabela([]);
            atualizarStats([]);
        }
    }

    function renderizarTabela(agendamentos) {
        const tbody = document.getElementById('tabelaAgendamentos');
        tbody.innerHTML = '';

        if (!agendamentos || agendamentos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-4">Nenhum agendamento encontrado.</td></tr>';
            return;
        }

        agendamentos.forEach(agenda => {
            const statusBadge = getStatusBadge(agenda.status);
            const pagamentoBadge = getPagamentoBadge(agenda.pagamento);
            const acoes = getAcoesAgendamento(agenda);

            tbody.innerHTML += `
                <tr data-agenda-id="${agenda.id}">
                    <td>#${agenda.id}</td>
                    <td>${formatarData(agenda.data)}<br><small>${formatarHora(agenda.hora_inicio)} - ${formatarHora(agenda.hora_fim)}</small></td>
                    <td>${agenda.quadra?.nome || '-'}</td>
                    <td>${agenda.usuario?.nome_completo || '-'}</td>
                    <td>${agenda.usuario?.telefone || '-'}</td>
                    <td>R$ ${parseFloat(agenda.pagamento?.valor || 0).toFixed(2).replace('.', ',')}</td>
                    <td>${statusBadge}</td>
                    <td>${pagamentoBadge}</td>
                    <td class="actions-cell">${acoes}</td>
                </tr>
            `;
        });
    }

    function getStatusBadge(status) {
        const map = {
            'pendente': '<span class="badge-status badge-pendente"><i class="bi bi-clock"></i>Pendente</span>',
            'confirmada': '<span class="badge-status badge-confirmada"><i class="bi bi-check-circle"></i>Confirmada</span>',
            'cancelada': '<span class="badge-status badge-cancelada"><i class="bi bi-x-circle"></i>Cancelada</span>',
            'concluida': '<span class="badge-status badge-concluida"><i class="bi bi-check2-circle"></i>Concluída</span>'
        };
        return map[status] || '<span class="badge-status">-</span>';
    }

    function getPagamentoBadge(pagamento) {
        if (!pagamento) return '<span class="badge-status">-</span>';
        const pago = pagamento.status === 'pago';
        const classe = pago ? 'badge-pago' : 'badge-pendente';
        const icone = pago ? 'bi-check2-circle' : 'bi-clock';
        const metodo = pagamento.metodo ? `(${formatarMetodo(pagamento.metodo)})` : '';
        return `<span class="badge-status ${classe}"><i class="bi ${icone}"></i>${pago ? 'Pago' : 'Pendente'} ${metodo}</span>`;
    }

    function formatarMetodo(metodo) {
        const map = { 'pix': 'PIX', 'dinheiro': 'Dinheiro', 'cartao_credito': 'Cartão', 'cartao_debito': 'Débito' };
        return map[metodo] || metodo;
    }

    function getAcoesAgendamento(agenda) {
        let html = '';
        
        // O dono confirma a reserva; o pagamento pode ser feito depois, no local.
        if (agenda.status === 'pendente') {
            html += `<button class="btn-action btn-confirm" data-action="confirmar-reserva" data-id="${agenda.id}"><i class="bi bi-check-circle"></i> Confirmar</button>`;
        }

        const pagamentoNoLocal = ['dinheiro', 'cartao_credito', 'cartao_debito'].includes(agenda.pagamento?.metodo);
        if (agenda.pagamento?.status === 'pendente' && pagamentoNoLocal) {
            html += `<button class="btn-action btn-confirm" data-action="confirmar-pagamento" data-id="${agenda.pagamento.id}"><i class="bi bi-cash-coin"></i> Confirmar pagamento</button>`;
        }
        
        // Ver comprovante (se pago)
        if (agenda.pagamento?.comprovante) {
            html += `<button class="btn-action btn-edit" data-action="ver-comprovante" data-url="${agenda.pagamento.comprovante}"><i class="bi bi-file-earmark-image"></i> Comprovante</button>`;
        }
        
        // Editar (se não concluída/cancelada)
        if (!['concluida', 'cancelada'].includes(agenda.status)) {
            html += `<button class="btn-action btn-edit" data-action="editar-reserva" data-id="${agenda.id}"><i class="bi bi-pencil"></i> Editar</button>`;
        }
        
        // Cancelar (se não concluída/cancelada)
        if (!['concluida', 'cancelada'].includes(agenda.status)) {
            html += `<button class="btn-action btn-cancel" data-action="cancelar-reserva" data-id="${agenda.id}"><i class="bi bi-x-circle"></i> Cancelar</button>`;
        }
        
        // Bloqueado se concluída
        if (agenda.status === 'concluida') {
            html += `<button class="btn-action btn-edit" disabled style="opacity:0.5"><i class="bi bi-lock"></i> Fechada</button>`;
        }
        
        return html || '-';
    }

    function atualizarStats(agendamentos) {
        document.getElementById('countTotal').textContent = agendamentos.length;
        document.getElementById('countPendentes').textContent = agendamentos.filter(a => a.status === 'pendente').length;
        document.getElementById('countConfirmadas').textContent = agendamentos.filter(a => a.status === 'confirmada').length;
        document.getElementById('countCanceladas').textContent = agendamentos.filter(a => a.status === 'cancelada').length;
    }

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = String(dataISO).slice(0, 10).split('-');
        return `${dia}/${mes}/${ano}`;
    }

    function formatarHora(hora) {
        return hora ? String(hora).slice(0, 5) : '-';
    }

    // AÇÕES DOS BOTÕES
    document.getElementById('tabelaAgendamentos').addEventListener('click', async event => {
        const button = event.target.closest('[data-action]');
        if (!button) return;

        const action = button.dataset.action;
        const id = button.dataset.id;

        if (action === 'editar-reserva') {
            // Preenche modal com dados da reserva
            const agenda = MOCK_AGENDAMENTOS.find(a => a.id == id);
            if (agenda) {
                document.getElementById('reservaCliente').value = agenda.usuario?.nome || '';
                document.getElementById('reservaQuadra').value = agenda.quadra?.id || '';
                document.getElementById('reservaData').value = agenda.data;
                document.getElementById('reservaHoraInicio').value = agenda.hora_inicio;
                document.getElementById('reservaHoraFim').value = agenda.hora_fim;
                document.getElementById('reservaValor').value = agenda.pagamento?.valor || '';
            }
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalReserva')).show();
            return;
        }

        if (action === 'confirmar-pagamento') {
            if (!confirm('Confirmar recebimento do pagamento?')) return;
            try {
                await EsporTecApi.request(`${API_BASE}/admin/pagamentos/${id}/confirmar`, { method: 'PATCH' });
                esportecToast('Pagamento confirmado.', 'success');
                await carregarAgendamentos();
            } catch (error) {
                esportecToast(error.message || 'Não foi possível confirmar o pagamento.', 'danger');
            }
            return;
        }

        if (action === 'confirmar-reserva') {
            if (!confirm('Confirmar esta reserva? O pagamento continuará pendente até ser feito.')) return;
            try {
                await EsporTecApi.request(`${API_BASE}/admin/reservas/${id}/confirmar`, { method: 'PATCH' });
                esportecToast('Reserva confirmada. O cliente já pode visualizar a confirmação.', 'success');
                await carregarAgendamentos();
            } catch (error) {
                esportecToast(error.message || 'Não foi possível confirmar a reserva.', 'danger');
            }
            return;
        }

        if (action === 'ver-comprovante') {
            const url = button.dataset.url;
            if (url) window.open(url, '_blank');
            else esportecToast('Comprovante não disponível.', 'warning');
            return;
        }

        if (action === 'cancelar-reserva') {
            if (!confirm('Cancelar esta reserva?\n\nEsta ação não pode ser desfeita.')) return;
            try {
                const response = await fetch(`${API_BASE}/agendamentos/${id}/cancelar`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                });
                if (!response.ok) throw new Error('Erro');
                esportecToast('Reserva cancelada.', 'success');
                carregarAgendamentos();
            } catch (error) {
                // Fallback visual
                const row = button.closest('tr');
                row.querySelector('td:nth-child(7)').innerHTML = '<span class="badge-status badge-cancelada"><i class="bi bi-x-circle"></i>Cancelada</span>';
                row.querySelectorAll('.btn-action').forEach(btn => { btn.disabled = true; btn.style.opacity = '0.5'; });
                esportecToast('Reserva cancelada (simulado).', 'success');
            }
            return;
        }
    });

    //  FILTROS
    function aplicarFiltros() {
        const data = document.getElementById('filtroData').value;
        const quadra = document.getElementById('filtroQuadra').value;
        const status = document.getElementById('filtroStatus').value;
        const cliente = document.getElementById('filtroCliente').value.trim().toLowerCase();

        document.querySelectorAll('#tabelaAgendamentos tr[data-agenda-id]').forEach(row => {
            const texto = row.textContent.toLowerCase();
            const mostrar = 
                (!data || texto.includes(data.split('-').reverse().join('/'))) &&
                (!quadra || texto.includes(quadra)) &&
                (!status || texto.includes(status)) &&
                (!cliente || texto.includes(cliente));
            row.classList.toggle('d-none', !mostrar);
        });
    }

    document.querySelectorAll('#filtroData, #filtroQuadra, #filtroStatus, #filtroCliente').forEach(input => {
        input.addEventListener('input', aplicarFiltros);
        input.addEventListener('change', aplicarFiltros);
    });

    //  CRIAR RESERVA MANUAL - API: POST /api/reservas
    document.getElementById('btnSalvarReserva').addEventListener('click', async () => {
        const payload = {
            usuario_id: 1, // Em produção: pegar do usuário logado
            quadra_id: document.getElementById('reservaQuadra').value,
            data: document.getElementById('reservaData').value,
            hora_inicio: document.getElementById('reservaHoraInicio').value,
            hora_fim: document.getElementById('reservaHoraFim').value,
            valor_total: parseFloat(document.getElementById('reservaValor').value) || 0,
            observacao: 'Reserva manual criada por admin'
        };

        if (!payload.quadra_id || !payload.data || !payload.hora_inicio) {
            esportecToast('Preencha todos os campos obrigatórios.', 'warning');
            return;
        }

        try {
            const response = await fetch(`${API_BASE}/reservas`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify(payload)
            });
            if (!response.ok) throw new Error('Erro');
            
            bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
            esportecToast('Reserva criada.', 'success');
            carregarAgendamentos();
        } catch (error) {
            console.error('Erro ao criar reserva:', error);
            // Fallback visual
            bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
            esportecToast('Reserva criada (simulado).', 'success');
            carregarAgendamentos();
        }
    });

    //  CARREGAR QUADRAS NO SELECT
    async function carregarQuadrasSelect() {
        try {
            const response = await fetch(`${API_BASE}/admin/quadras`);
            if (!response.ok) throw new Error('Erro');
            const quadras = await response.json();
            preencherSelectQuadras(quadras);
        } catch (error) {
            console.log(' Usando mock para quadras:', error.message);
            preencherSelectQuadras(MOCK_QUADRAS);
        }
    }

    function preencherSelectQuadras(quadras) {
        const selects = [document.getElementById('reservaQuadra'), document.getElementById('filtroQuadra')];
        selects.forEach(select => {
            if (!select) return;
            const first = select.querySelector('option[value=""]')?.outerHTML || '<option value="">Selecione...</option>';
            select.innerHTML = first;
            quadras.forEach(q => {
                select.innerHTML += `<option value="${q.id}">${q.nome}</option>`;
            });
        });
    }

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarQuadrasSelect();
        carregarAgendamentos();
    });
</script>
</body>
</html>
