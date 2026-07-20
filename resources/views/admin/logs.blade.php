<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Logs - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --bg:#F8FAFC; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:260px; background:var(--dark); padding:1.5rem; flex-shrink:0; }
        .sidebar-brand { color:white; font-size:1.5rem; font-weight:700; text-decoration:none; display:block; margin-bottom:2rem; }
        .nav-link { color:rgba(255,255,255,.75); border-radius:8px; padding:.75rem 1rem; margin-bottom:.35rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 4px 16px rgba(15,23,42,.06); }
        @media (max-width: 992px) { .layout { display:block; } .sidebar { width:100%; } .main { padding:1rem; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/super-admin/dashboard" class="sidebar-brand">EsporTec <small class="opacity-75">Super admin</small></a>
        <nav>
            <a href="/super-admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link active"><i class="bi bi-journal-text"></i> Logs</a>
        </nav>
    </aside>
    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Logs da plataforma</h1>
                <p class="text-muted mb-0">Acesso restrito ao super admin da plataforma EsporTec.</p>
            </div>
            <span class="badge bg-warning text-dark">Super admin da plataforma</span>
        </div>
        <section class="card-soft p-4">
            <div class="row g-3 mb-3">
                <div class="col-md-3"><input type="date" class="form-control" id="dataLog"></div>
                <div class="col-md-3"><select class="form-select" id="tipoLog"><option value="">Todas as ações</option><option>Login</option><option>Reserva</option><option>Pagamento</option><option>Usuário</option><option>Equipe</option></select></div>
                <div class="col-md-4"><input class="form-control" id="buscarLog" placeholder="Buscar usuário ou descrição"></div>
                <div class="col-md-2"><button class="btn btn-success w-100" id="btnFiltrarLogs"><i class="bi bi-search me-1"></i>Filtrar</button></div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Data</th><th>Usuário</th><th>Ação</th><th>Descrição</th><th>IP</th></tr></thead>
                    <tbody id="tabelaLogs">
                        <tr><td colspan="5" class="text-center text-muted py-4"><i class="bi bi-hourglass-spin me-2"></i>Carregando logs...</td></tr>
                    </tbody>
                </table>
            </div>
            <div id="logsEmpty" class="text-center py-5 d-none">
                <i class="bi bi-search fs-1 text-success"></i>
                <h5 class="fw-bold mt-3">Nenhum log encontrado</h5>
                <p class="text-muted mb-0">Tente mudar a data, ação ou termo pesquisado.</p>
            </div>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN LOGS
    
    const API_BASE = '/api';
    
    // Mock data para fallback
    const MOCK_LOGS = [
        { id: 1, data: '2026-06-21', hora: '15:42', usuario: 'Maria Admin', acao: 'Pagamento', descricao: 'Confirmou pagamento da reserva #1235.', ip: '192.168.0.14' },
        { id: 2, data: '2026-06-21', hora: '14:18', usuario: 'João Funcionário', acao: 'Reserva', descricao: 'Alterou horário da reserva #1234.', ip: '192.168.0.22' },
        { id: 3, data: '2026-06-21', hora: '09:10', usuario: 'Plataforma EsporTec', acao: 'Equipe', descricao: 'Inativou funcionário Ana Lima como ação de suporte da plataforma.', ip: '192.168.0.10' },
        { id: 4, data: '2026-06-20', hora: '20:05', usuario: 'Pedro Cliente', acao: 'Login', descricao: 'Acessou a área do cliente.', ip: '189.88.12.40' },
        { id: 5, data: '2026-06-20', hora: '18:30', usuario: 'Ana Lima', acao: 'Reserva', descricao: 'Criou nova reserva para Society Premium.', ip: '189.88.12.40' },
        { id: 6, data: '2026-06-20', hora: '12:00', usuario: 'Sistema', acao: 'Backup', descricao: 'Backup automático concluído com sucesso.', ip: '127.0.0.1' }
    ];

    //  CARREGAR LOGS - API: GET /api/admin/logs
    async function carregarLogs(filtros = {}) {
        try {
            const params = new URLSearchParams();
            if (filtros.data) params.append('data', filtros.data);
            if (filtros.tipo) params.append('tipo', filtros.tipo);
            if (filtros.busca) params.append('busca', filtros.busca);
            
            const url = `${API_BASE}/admin/logs${params.toString() ? '?' + params : ''}`;
            const response = await fetch(url);
            
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            
            const logs = await response.json();
            
            if (!logs || logs.length === 0) {
                console.log(' API retornou vazio, usando mock');
                renderizarLogs(MOCK_LOGS);
                return;
            }
            
            renderizarLogs(logs);
            console.log('Logs carregados:', logs.length);
        } catch (error) {
            console.log(' Erro na API, usando mock:', error.message);
            renderizarLogs(MOCK_LOGS);
        }
    }

    function renderizarLogs(logs) {
        const tbody = document.getElementById('tabelaLogs');
        tbody.innerHTML = '';

        if (!logs || logs.length === 0) {
            document.getElementById('logsEmpty').classList.remove('d-none');
            return;
        }

        document.getElementById('logsEmpty').classList.add('d-none');

        logs.forEach(log => {
            const badgeClass = getBadgeClass(log.acao);
            tbody.innerHTML += `
                <tr data-log-date="${log.data}" data-log-tipo="${log.acao.toLowerCase()}">
                    <td>${formatarData(log.data)} ${log.hora}</td>
                    <td>${log.usuario}</td>
                    <td><span class="badge ${badgeClass}">${log.acao}</span></td>
                    <td>${log.descricao}</td>
                    <td><small class="text-muted">${log.ip}</small></td>
                </tr>
            `;
        });
    }

    function getBadgeClass(acao) {
        const map = {
            'Login': 'bg-secondary',
            'Reserva': 'bg-primary',
            'Pagamento': 'bg-success',
            'Usuário': 'bg-info text-dark',
            'Equipe': 'bg-warning text-dark',
            'Backup': 'bg-secondary',
            'Sistema': 'bg-secondary'
        };
        return map[acao] || 'bg-secondary';
    }

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = dataISO.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    //  FILTRAR LOGS
    function aplicarFiltros() {
        const data = document.getElementById('dataLog').value;
        const tipo = document.getElementById('tipoLog').value.toLowerCase();
        const busca = document.getElementById('buscarLog').value.trim().toLowerCase();
        
        // Se tiver filtros, tenta buscar da API
        if (data || tipo || busca) {
            carregarLogs({ data, tipo: document.getElementById('tipoLog').value, busca });
            return;
        }
        
        // Sem filtros: filtra localmente no mock/API já carregado
        let visiveis = 0;
        document.querySelectorAll('#tabelaLogs tr[data-log-date]').forEach(row => {
            const texto = row.textContent.toLowerCase();
            const bateTipo = !tipo || row.dataset.logTipo === tipo || texto.includes(tipo);
            const bateBusca = !busca || texto.includes(busca);
            const bateData = !data || row.dataset.logDate === data;
            const mostrar = bateTipo && bateBusca && bateData;
            row.classList.toggle('d-none', !mostrar);
            if (mostrar) visiveis += 1;
        });
        document.getElementById('logsEmpty').classList.toggle('d-none', visiveis > 0);
    }

    // Event listeners para filtros
    document.getElementById('btnFiltrarLogs').addEventListener('click', aplicarFiltros);
    document.getElementById('buscarLog').addEventListener('input', aplicarFiltros);
    document.getElementById('tipoLog').addEventListener('change', aplicarFiltros);
    document.getElementById('dataLog').addEventListener('change', aplicarFiltros);

    // Enter no campo de busca
    document.getElementById('buscarLog').addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            event.preventDefault();
            aplicarFiltros();
        }
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarLogs();
    });
</script>
</body>
</html>

