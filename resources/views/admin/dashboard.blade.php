<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visão Geral - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #1F5C42; --primary: #2D815D; --success: #2D815D; --warning: #F9A825; --danger: #D32F2F; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { margin-bottom: 2rem; }
        .header h1 { font-size: 1.8rem; font-weight: 700; margin: 0; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-left: 4px solid; }
        .stat-card.blue { border-left-color: var(--primary); }
        .stat-card.green { border-left-color: var(--success); }
        .stat-card.yellow { border-left-color: var(--warning); }
        .stat-card.red { border-left-color: var(--danger); }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
        .stat-card.blue .stat-icon { background: #DBEAFE; color: var(--primary); }
        .stat-card.green .stat-icon { background: #D1FAE5; color: var(--success); }
        .stat-card.yellow .stat-icon { background: #FEF3C7; color: var(--warning); }
        .stat-card.red .stat-icon { background: #FEE2E2; color: var(--danger); }
        .stat-value { font-size: 2rem; font-weight: 700; margin: 0.5rem 0; }
        .stat-label { color: #64748B; font-weight: 500; }
        .recent-section { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .section-title { font-weight: 600; margin-bottom: 1rem; font-size: 1.1rem; }
        .activity-item { display: flex; align-items: center; padding: 1rem; border-bottom: 1px solid #F1F5F9; }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1.2rem; }
        .activity-info { flex: 1; }
        .activity-text { font-weight: 500; margin-bottom: 0.2rem; }
        .activity-time { font-size: 0.8rem; color: #64748B; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.75;">Admin da arena</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link active"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/logs" class="nav-link"><i class="bi bi-journal-text"></i> Logs</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1><i class="bi bi-speedometer2 me-2"></i>Visão Geral da Arena</h1>
                <p class="text-muted mb-0">Painel do proprietário/gestor - <span id="mesAtual">Junho 2026</span></p>
            </div>
            <div>
                <label class="form-label small text-muted mb-1">Arena ativa</label>
                <select class="form-select" id="arenaAtiva">
                    <option>Carregando arenas...</option>
                </select>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                <div class="stat-label">Reservas Hoje</div>
                <div class="stat-value" id="statReservasHoje">-</div>
                <small class="text-success" id="statReservasDetalhe"><i class="bi bi-arrow-up"></i> Carregando...</small>
            </div>
            <div class="stat-card green">
                <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="stat-label">Receita do Mês</div>
                <div class="stat-value" id="statReceita">-</div>
                <small class="text-success" id="statReceitaDetalhe"><i class="bi bi-arrow-up"></i> Carregando...</small>
            </div>
            <div class="stat-card yellow">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-label">Total de Clientes</div>
                <div class="stat-value" id="statClientes">-</div>
                <small class="text-muted" id="statClientesDetalhe">Carregando...</small>
            </div>
            <div class="stat-card red">
                <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="stat-label">Pendentes</div>
                <div class="stat-value" id="statPendentes">-</div>
                <small class="text-warning" id="statPendentesDetalhe">Carregando...</small>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="recent-section">
                    <div class="section-title"><i class="bi bi-calendar-event me-2"></i>Próximas Reservas</div>
                    <table class="table table-borderless mb-0">
                        <thead><tr><th>Horário</th><th>Quadra</th><th>Cliente</th><th>Status</th></tr></thead>
                        <tbody id="listaProximasReservas">
                            <tr><td colspan="4" class="text-center text-muted py-3"><i class="bi bi-hourglass-spin me-2"></i>Carregando...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="recent-section">
                    <div class="section-title"><i class="bi bi-bell me-2"></i>Atividade Recente</div>
                    <div id="listaAtividadeRecente">
                        <div class="activity-item">
                            <div class="activity-icon" style="background:#F1F5F9; color:#64748B;"><i class="bi bi-hourglass"></i></div>
                            <div class="activity-info">
                                <div class="activity-text">Carregando atividades...</div>
                                <div class="activity-time">Aguarde</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN DASHBOARD
    
    const API_BASE = '/api';
    
    //  CARREGAR DADOS DO DASHBOARD
    async function carregarDashboard(arenaId = null) {
        try {
            const url = arenaId ? `${API_BASE}/admin/dashboard?arena_id=${arenaId}` : `${API_BASE}/admin/dashboard`;
            const dados = await EsporTecApi.request(url);
            renderizarStats(dados.stats);
            renderizarProximasReservas(dados.proximas_reservas);
            renderizarAtividades(dados.atividades);
            preencherArenas(dados.arenas, arenaId);
        } catch (error) {
            renderizarStats({ reservas_hoje: 0, reservas_confirmadas: 0, receita_mes: 0, receita_variacao: null, total_clientes: 0, clientes_novos_semana: 0, pendentes: 0 });
            renderizarProximasReservas([]);
            renderizarAtividades([]);
            esportecToast(error.message, 'warning');
        }
    }

    function preencherArenas(arenas, selecionada) {
        const select = document.getElementById('arenaAtiva');
        const atual = selecionada || select.value;
        select.innerHTML = arenas.length ? arenas.map(arena => `<option value="${arena.id}">${arena.nome}</option>`).join('') : '<option value="">Nenhuma arena vinculada</option>';
        if (atual && [...select.options].some(opcao => opcao.value === String(atual))) select.value = atual;
    }

    function renderizarStats(stats) {
        // Reservas hoje
        document.getElementById('statReservasHoje').textContent = stats.reservas_hoje ?? 0;
        document.getElementById('statReservasDetalhe').textContent = `${stats.reservas_confirmadas ?? 0} confirmada${stats.reservas_confirmadas === 1 ? '' : 's'}`;
        
        // Receita do mês
        document.getElementById('statReceita').textContent = Number(stats.receita_mes || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        if (stats.receita_variacao !== null && stats.receita_variacao !== undefined) {
            const sinal = stats.receita_variacao >= 0 ? '+' : '';
            document.getElementById('statReceitaDetalhe').innerHTML = `<i class="bi bi-arrow-${stats.receita_variacao >= 0 ? 'up' : 'down'}"></i> ${sinal}${stats.receita_variacao}% vs mês anterior`;
        } else document.getElementById('statReceitaDetalhe').textContent = 'Sem comparação no mês anterior';
        
        // Total de clientes
        document.getElementById('statClientes').textContent = stats.total_clientes ?? 0;
        document.getElementById('statClientesDetalhe').textContent = `+${stats.clientes_novos_semana ?? 0} novos esta semana`;
        
        // Pendentes
        document.getElementById('statPendentes').textContent = stats.pendentes ?? 0;
        document.getElementById('statPendentesDetalhe').textContent = stats.pendentes > 0 ? 'Aguardando confirmação' : 'Nenhuma pendência';
    }

    function renderizarProximasReservas(reservas) {
        const tbody = document.getElementById('listaProximasReservas');
        tbody.innerHTML = '';
        
        if (!reservas || reservas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Nenhuma reserva próxima.</td></tr>';
            return;
        }
        
        reservas.slice(0, 5).forEach(reserva => {
            const statusBadge = reserva.status === 'confirmada' ? 
                '<span class="badge bg-success bg-opacity-10 text-success">Confirmada</span>' :
                reserva.status === 'pendente' ?
                '<span class="badge bg-warning bg-opacity-10 text-warning">Pendente</span>' :
                `<span class="badge bg-secondary bg-opacity-10 text-secondary">${reserva.status}</span>`;
            
            tbody.innerHTML += `
                <tr>
                    <td>${reserva.hora_inicio} - ${reserva.hora_fim}</td>
                    <td>${reserva.quadra?.nome || '-'}</td>
                    <td>${reserva.usuario?.nome_completo || '-'}</td>
                    <td>${statusBadge}</td>
                </tr>
            `;
        });
    }

    function renderizarAtividades(atividades) {
        const container = document.getElementById('listaAtividadeRecente');
        container.innerHTML = '';
        
        if (!atividades || atividades.length === 0) {
            container.innerHTML = '<div class="activity-item"><div class="activity-info text-muted">Nenhuma atividade recente.</div></div>';
            return;
        }
        
        atividades.slice(0, 5).forEach(atividade => {
            container.innerHTML += `
                <div class="activity-item">
                    <div class="activity-icon" style="background:${atividade.cor}; color:${atividade.cor_texto || atividade.corTexto};">
                        <i class="${atividade.icone}"></i>
                    </div>
                    <div class="activity-info">
                        <div class="activity-text">${atividade.texto}${atividade.detalhe ? ` - ${atividade.detalhe}` : ''}</div>
                        <div class="activity-time">${atividade.data ? new Date(atividade.data).toLocaleString('pt-BR') : ''}</div>
                    </div>
                </div>
            `;
        });
    }

    //  TROCAR ARENA ATIVA
    document.getElementById('arenaAtiva').addEventListener('change', async event => {
        const arenaId = event.target.value;
        const arenaNome = event.target.options[event.target.selectedIndex].text;
        
        if (!arenaId) return;
        await carregarDashboard(arenaId);
        esportecToast(`Dashboard atualizado para ${arenaNome}.`, 'success');
    });

    // Atualiza mês atual no header
    document.addEventListener('DOMContentLoaded', () => {
        const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        const agora = new Date();
        document.getElementById('mesAtual').textContent = `${meses[agora.getMonth()]} ${agora.getFullYear()}`;
        
        // Carrega dados iniciais
        carregarDashboard();
    });
</script>
</body>
</html>
