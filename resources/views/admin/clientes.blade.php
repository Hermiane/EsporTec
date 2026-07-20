<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestão de Clientes - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #1F5C42; --primary: #2D815D; --primary-soft: #E8F5EE; --muted: #64748B; --line: #E2E8F0; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; }
        .sidebar-brand i { font-size: 1.8rem; }
        .sidebar-brand span { font-size: 0.7rem; opacity: 0.6; display: block; margin-top: -0.2rem; }
        .nav-link { color: rgba(255,255,255,0.74); padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 0.5rem; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-box { padding: 1.5rem; border-radius: 12px; color: #334155; display: flex; align-items: center; gap: 1rem; background: white; border: 1px solid var(--line); border-left: 4px solid var(--primary); box-shadow: 0 2px 8px rgba(15,23,42,0.04); }
        .stat-box.total { border-left-color: var(--primary); }
        .stat-box.birthday { border-left-color: var(--admin-dark); }
        .stat-box.vip { border-left-color: #94A3B8; }
        .stat-icon { font-size: 2rem; color: var(--primary); opacity: 0.9; }
        .stat-value { font-size: 2rem; font-weight: 700; margin: 0.5rem 0; }
        .stat-label { font-size: 0.9rem; color: var(--muted); }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .client-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 1rem; color: var(--primary); background: var(--primary-soft); border: 1px solid rgba(45,129,93,0.2); font-size: 0.9rem; flex-shrink: 0; }
        .badge-vip { background: var(--primary-soft); color: var(--primary); padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; }
        
        .btn-action { 
            padding: 0.4rem 0.7rem; 
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
        .btn-offer { background: var(--primary-soft); color: var(--primary); }
        .btn-offer:hover { background: var(--primary); color: white; }
        .btn-history { background: #F1F5F9; color: #475569; }
        .btn-history:hover { background: var(--primary); color: white; }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-primary-admin:hover { background: var(--admin-dark); }
        
        .actions-cell { display: flex; flex-wrap: wrap; gap: 0.2rem; align-items: center; }
        
        @media (max-width: 1400px) {
            .btn-action { padding: 0.35rem 0.55rem; font-size: 0.7rem; margin: 0.1rem; }
            .table td, .table th { padding: 0.8rem 0.6rem; font-size: 0.9rem; }
            .client-avatar { width: 36px; height: 36px; font-size: 0.85rem; }
        }
        @media (max-width: 1200px) {
            .actions-cell { flex-direction: column; align-items: flex-start; }
            .btn-action { width: 100%; justify-content: flex-start; margin: 0.1rem 0; }
            .badge-vip { font-size: 0.7rem; padding: 0.25rem 0.5rem; }
        }
        @media (max-width: 992px) {
            .layout { display: block; }
            .sidebar { width: 100%; }
            .main { padding: 1rem; }
            .card-custom { overflow-x: auto; }
            .table-responsive { overflow-x: auto; }
            table { min-width: 900px; }
            .filter-bar input, .filter-bar select { width: 100% !important; }
            .actions-cell { flex-direction: row; flex-wrap: wrap; }
            .btn-action { width: auto; }
        }
        @media (max-width: 768px) {
            .table th, .table td { font-size: 0.8rem; padding: 0.5rem; }
            .btn-action { font-size: 0.65rem; padding: 0.25rem 0.4rem; }
            .stat-value { font-size: 1.5rem; }
            .client-info { font-size: 0.85rem; }
            .client-info small { font-size: 0.75rem; }
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
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link active"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>

    <main class="main">
        <div class="header">
            <h1><i class="bi bi-people"></i>Gestão de Clientes</h1>
            <button class="btn-primary-admin" id="btnOfertaMassa"><i class="bi bi-envelope"></i>Enviar Oferta em Massa</button>
        </div>

        <div class="stats-row">
            <div class="stat-box total">
                <i class="bi bi-people stat-icon"></i>
                <div>
                    <div class="stat-value" id="statTotalClientes">-</div>
                    <div class="stat-label">Total de Clientes</div>
                </div>
            </div>
            <div class="stat-box birthday">
                <i class="bi bi-gift stat-icon"></i>
                <div>
                    <div class="stat-value" id="statAniversariantes">-</div>
                    <div class="stat-label">Aniversariantes do Mês</div>
                </div>
            </div>
            <div class="stat-box vip">
                <i class="bi bi-star stat-icon"></i>
                <div>
                    <div class="stat-value" id="statVip">-</div>
                    <div class="stat-label">Clientes VIP</div>
                </div>
            </div>
        </div>

        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Lista de Clientes</h5>
                <input type="search" id="buscarClienteAdmin" placeholder="Buscar cliente..." class="form-control" style="width: 300px; max-width: 100%;">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Reservas</th>
                            <th>Última Visita</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaClientes">
                        <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-hourglass-spin me-2"></i>Carregando clientes...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="modalClienteAdmin" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalClienteTitulo"><i class="bi bi-person me-2"></i>Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalClienteConteudo"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarClienteModal"><i class="bi bi-check-lg me-1"></i>Confirmar ação</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>

    //  INTEGRAÇÃO COM API - ADMIN CLIENTES
    
    const API_BASE = '/api';
    
    // Mock data para fallback
    const MOCK_CLIENTES = [
        { id: 1, nome: 'João Silva', email: 'joao.silva@email.com', telefone: '(11) 99999-9999', cpf: '123.456.789-00', reservas: 24, ultima_visita: '2026-06-12', vip: true, aniversario_mes: false },
        { id: 2, nome: 'Pedro Martins', email: 'pedro.m@email.com', telefone: '(11) 98888-8888', cpf: '987.654.321-00', reservas: 12, ultima_visita: '2026-06-10', vip: false, aniversario_mes: false },
        { id: 3, nome: 'Ana Lima', email: 'ana.lima@email.com', telefone: '(11) 97777-7777', cpf: '456.789.123-00', reservas: 8, ultima_visita: '2026-06-08', vip: false, aniversario_mes: true },
        { id: 4, nome: 'Maria Oliveira', email: 'maria.o@email.com', telefone: '(11) 96666-6666', cpf: '111.222.333-44', reservas: 31, ultima_visita: '2026-06-14', vip: true, aniversario_mes: true },
        { id: 5, nome: 'Carlos Souza', email: 'carlos.s@email.com', telefone: '(11) 95555-5555', cpf: '555.666.777-88', reservas: 5, ultima_visita: '2026-05-20', vip: false, aniversario_mes: false }
    ];

    //  CARREGAR CLIENTES - API: GET /api/admin/clientes
    async function carregarClientes() {
        try {
            const response = await fetch(`${API_BASE}/admin/clientes`);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const clientes = await response.json();
            
            if (!clientes || clientes.length === 0) {
                console.log(' API retornou vazio, usando mock');
                renderizarClientes(MOCK_CLIENTES);
                atualizarStats(MOCK_CLIENTES);
                return;
            }
            
            renderizarClientes(clientes);
            atualizarStats(clientes);
            console.log(' Clientes carregados:', clientes.length);
        } catch (error) {
            console.log(' Erro na API, usando mock:', error.message);
            renderizarClientes(MOCK_CLIENTES);
            atualizarStats(MOCK_CLIENTES);
        }
    }

    function renderizarClientes(clientes) {
        const tbody = document.getElementById('tabelaClientes');
        tbody.innerHTML = '';

        if (!clientes || clientes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">Nenhum cliente encontrado.</td></tr>';
            return;
        }

        clientes.forEach(cliente => {
            const avatarBg = cliente.vip ? '#3B82F6' : '#2D815D';
            const iniciais = getIniciais(cliente.nome);
            const statusBadge = getStatusBadge(cliente);
            const acoes = getAcoesCliente(cliente);

            tbody.innerHTML += `
                <tr data-cliente-id="${cliente.id}">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="client-avatar" style="background:${avatarBg}; color:white;">${iniciais}</div>
                            <div class="client-info">
                                <div class="fw-semibold">${cliente.nome}</div>
                                <small class="text-muted">CPF: ${cliente.cpf || '-'}</small>
                            </div>
                        </div>
                    </td>
                    <td>${cliente.email}</td>
                    <td>${cliente.telefone}</td>
                    <td><span class="fw-bold">${cliente.reservas}</span> reservas</td>
                    <td>${formatarData(cliente.ultima_visita)}</td>
                    <td>${statusBadge}</td>
                    <td class="actions-cell">${acoes}</td>
                </tr>
            `;
        });
    }

    function getIniciais(nome) {
        return nome.split(' ').map(p => p[0]).join('').slice(0, 2).toUpperCase();
    }

    function getStatusBadge(cliente) {
        if (cliente.vip) {
            return `<span class="badge-vip"><i class="bi bi-star"></i>VIP</span>`;
        }
        if (cliente.aniversario_mes) {
            return `<span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-gift"></i>Aniversário</span>`;
        }
        return `<span class="badge bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-person"></i>Regular</span>`;
    }

    function getAcoesCliente(cliente) {
        return `
            <button class="btn-action btn-offer" data-client-action="oferta" data-id="${cliente.id}">
                <i class="bi bi-gift"></i> Enviar oferta
            </button>
            <button class="btn-action btn-history" data-client-action="historico" data-id="${cliente.id}">
                <i class="bi bi-clock-history"></i> Ver histórico
            </button>
        `;
    }

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = dataISO.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    function atualizarStats(clientes) {
        document.getElementById('statTotalClientes').textContent = clientes.length;
        document.getElementById('statAniversariantes').textContent = clientes.filter(c => c.aniversario_mes).length;
        document.getElementById('statVip').textContent = clientes.filter(c => c.vip).length;
    }

    //  BUSCA EM TEMPO REAL
    document.getElementById('buscarClienteAdmin').addEventListener('input', event => {
        const termo = event.target.value.trim().toLowerCase();
        document.querySelectorAll('#tabelaClientes tr[data-cliente-id]').forEach(row => {
            const texto = row.textContent.toLowerCase();
            row.classList.toggle('d-none', termo && !texto.includes(termo));
        });
    });

    //  OFERTA EM MASSA
    document.getElementById('btnOfertaMassa').addEventListener('click', async () => {
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalClienteAdmin'));
        
        document.getElementById('modalClienteTitulo').innerHTML = '<i class="bi bi-envelope me-2"></i>Enviar oferta em massa';
        document.getElementById('modalClienteConteudo').innerHTML = `
            <div class="alert alert-success"><i class="bi bi-megaphone me-2"></i>Campanha preparada para os clientes visíveis na tabela.</div>
            <label class="form-label fw-semibold"><i class="bi bi-chat-square-text me-1"></i>Mensagem da oferta</label>
            <textarea class="form-control" rows="4" id="ofertaMassaMensagem">Olá! A EsporTec preparou uma condição especial para sua próxima reserva. Aproveite esta semana.</textarea>
            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-send me-1"></i>Canal</label>
                    <select class="form-select" id="ofertaMassaCanal">
                        <option value="email">E-mail</option>
                        <option value="notificacao">Notificação do sistema</option>
                        <option value="ambos">Ambos</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-people me-1"></i>Público</label>
                    <select class="form-select" id="ofertaMassaPublico">
                        <option value="visiveis">Clientes visíveis</option>
                        <option value="vip">Clientes VIP</option>
                        <option value="aniversariantes">Aniversariantes</option>
                    </select>
                </div>
            </div>
        `;
        document.getElementById('btnConfirmarClienteModal').innerHTML = '<i class="bi bi-send me-1"></i>Preparar envio';
        document.getElementById('btnConfirmarClienteModal').onclick = async () => {
            const payload = {
                mensagem: document.getElementById('ofertaMassaMensagem').value,
                canal: document.getElementById('ofertaMassaCanal').value,
                publico: document.getElementById('ofertaMassaPublico').value
            };
            
            try {
                const response = await fetch(`${API_BASE}/admin/clientes/oferta-massa`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify(payload)
                });
                if (!response.ok) throw new Error('Erro');
                
                modal.hide();
                esportecToast('Oferta em massa enviada.', 'success');
            } catch (error) {
                console.error('Erro ao enviar oferta:', error);
                modal.hide();
                esportecToast('Oferta em massa preparada (simulado).', 'success');
            }
        };
        modal.show();
    });

    //  AÇÕES INDIVIDUAIS (oferta, histórico)
    document.getElementById('tabelaClientes').addEventListener('click', async event => {
        const button = event.target.closest('[data-client-action]');
        if (!button) return;

        const action = button.dataset.clientAction;
        const id = button.dataset.id;
        const row = button.closest('tr');
        const nome = row.querySelector('.fw-semibold')?.textContent || 'Cliente';
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalClienteAdmin'));

        if (action === 'oferta') {
            document.getElementById('modalClienteTitulo').innerHTML = `<i class="bi bi-gift me-2"></i>Oferta para ${nome}`;
            document.getElementById('modalClienteConteudo').innerHTML = `
                <label class="form-label fw-semibold"><i class="bi bi-chat-square-text me-1"></i>Mensagem personalizada</label>
                <textarea class="form-control" rows="4" id="ofertaMensagem">${nome}, sentimos sua falta na EsporTec. Reserve uma quadra esta semana e aproveite uma condição especial.</textarea>
                <div class="alert alert-info mt-3 mb-0"><i class="bi bi-info-circle me-2"></i>A oferta ficará marcada no relacionamento do cliente.</div>
            `;
            document.getElementById('btnConfirmarClienteModal').innerHTML = '<i class="bi bi-send me-1"></i>Preparar oferta';
            document.getElementById('btnConfirmarClienteModal').onclick = async () => {
                try {
                    const response = await fetch(`${API_BASE}/admin/clientes/${id}/oferta`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                        body: JSON.stringify({ mensagem: document.getElementById('ofertaMensagem').value })
                    });
                    if (!response.ok) throw new Error('Erro');
                    
                    button.innerHTML = '<i class="bi bi-check2"></i> Oferta pronta';
                    button.disabled = true;
                    modal.hide();
                    esportecToast(`Oferta preparada para ${nome}.`, 'success');
                } catch (error) {
                    console.error('Erro ao preparar oferta:', error);
                    button.innerHTML = '<i class="bi bi-check2"></i> Oferta pronta';
                    button.disabled = true;
                    modal.hide();
                    esportecToast(`Oferta preparada para ${nome} (simulado).`, 'success');
                }
            };
            modal.show();
            return;
        }

        if (action === 'historico') {
            try {
                const response = await fetch(`${API_BASE}/admin/clientes/${id}/historico`);
                if (!response.ok) throw new Error('Erro');
                const historico = await response.json();
                preencherModalHistorico(nome, historico);
            } catch (error) {
                console.log(' Usando mock para histórico:', error.message);
                preencherModalHistoricoMock(nome);
            }
            modal.show();
            return;
        }
    });

    function preencherModalHistorico(nome, historico) {
        document.getElementById('modalClienteTitulo').innerHTML = `<i class="bi bi-clock-history me-2"></i>Histórico de ${nome}`;
        
        const reservasHtml = historico.reservas?.slice(0, 5).map(r => `
            <li class="list-group-item d-flex justify-content-between">
                <span>${r.quadra} - ${formatarData(r.data)} ${r.hora_inicio}</span>
                <strong class="text-${r.status === 'confirmada' ? 'success' : 'secondary'}">${r.status}</strong>
            </li>
        `).join('') || '<li class="list-group-item text-muted">Nenhuma reserva encontrada.</li>';

        document.getElementById('modalClienteConteudo').innerHTML = `
            <div class="row g-3">
                <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Reservas</small><strong class="d-block">${historico.total_reservas || 0}</strong></div></div>
                <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Última visita</small><strong class="d-block">${formatarData(historico.ultima_visita)}</strong></div></div>
                <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Status</small><strong class="d-block">${historico.vip ? 'VIP' : 'Regular'}</strong></div></div>
            </div>
            <hr>
            <h6 class="fw-bold"><i class="bi bi-list-ul me-2"></i>Reservas recentes</h6>
            <ul class="list-group">
                ${reservasHtml}
            </ul>
        `;
        document.getElementById('btnConfirmarClienteModal').innerHTML = '<i class="bi bi-bell me-1"></i>Enviar lembrete';
        document.getElementById('btnConfirmarClienteModal').onclick = () => {
            esportecToast(`Lembrete preparado para ${nome}.`, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalClienteAdmin')).hide();
        };
    }

    function preencherModalHistoricoMock(nome) {
        document.getElementById('modalClienteTitulo').innerHTML = `<i class="bi bi-clock-history me-2"></i>Histórico de ${nome}`;
        document.getElementById('modalClienteConteudo').innerHTML = `
            <div class="row g-3">
                <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Reservas</small><strong class="d-block">24</strong></div></div>
                <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Última visita</small><strong class="d-block">12/06/2026</strong></div></div>
                <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Status</small><strong class="d-block">VIP</strong></div></div>
            </div>
            <hr>
            <h6 class="fw-bold"><i class="bi bi-list-ul me-2"></i>Reservas recentes</h6>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between"><span>Society Premium</span><strong class="text-success">Confirmada</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Futsal Arena</span><strong class="text-secondary">Concluída</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Society Descoberta</span><strong class="text-warning">Pagamento pendente</strong></li>
            </ul>
        `;
        document.getElementById('btnConfirmarClienteModal').innerHTML = '<i class="bi bi-bell me-1"></i>Enviar lembrete';
        document.getElementById('btnConfirmarClienteModal').onclick = () => {
            esportecToast(`Lembrete preparado para ${nome}.`, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalClienteAdmin')).hide();
        };
    }

    // Reset modal ao fechar
    document.getElementById('modalClienteAdmin').addEventListener('hidden.bs.modal', () => {
        document.getElementById('btnConfirmarClienteModal').disabled = false;
        // Reabilita botões de oferta que foram desabilitados
        document.querySelectorAll('[data-client-action="oferta"][disabled]').forEach(btn => {
            btn.innerHTML = '<i class="bi bi-gift"></i> Enviar oferta';
            btn.disabled = false;
        });
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarClientes();
    });
</script>
</body>
</html>