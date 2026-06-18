<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visão Geral - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #0F172A; --primary: #3B82F6; --success: #10B981; --warning: #F59E0B; --danger: #EF4444; --bg: #F8FAFC; }
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
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">ADMIN</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link active"><i class="bi bi-grid"></i> Visão Geral</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/pessoas" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>
    
    <main class="main">
        <div class="header">
            <h1><i class="bi bi-speedometer2 me-2"></i>Visão Geral do Sistema</h1>
            <p class="text-muted">Resumo operacional - Junho 2026</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                <div class="stat-label">Reservas Hoje</div>
                <div class="stat-value">12</div>
                <small class="text-success"><i class="bi bi-arrow-up"></i> 2 confirmadas</small>
            </div>
            <div class="stat-card green">
                <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="stat-label">Receita do Mês</div>
                <div class="stat-value">R$ 4.850</div>
                <small class="text-success"><i class="bi bi-arrow-up"></i> +12% vs mês anterior</small>
            </div>
            <div class="stat-card yellow">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-label">Total de Clientes</div>
                <div class="stat-value">342</div>
                <small class="text-muted">+8 novos esta semana</small>
            </div>
            <div class="stat-card red">
                <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="stat-label">Pendentes</div>
                <div class="stat-value">5</div>
                <small class="text-warning">Aguardando confirmação</small>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="recent-section">
                    <div class="section-title"><i class="bi bi-calendar-event me-2"></i>Próximas Reservas</div>
                    <table class="table table-borderless mb-0">
                        <thead><tr><th>Horário</th><th>Quadra</th><th>Cliente</th><th>Status</th></tr></thead>
                        <tbody>
                            <tr><td>14:00 - 15:30</td><td>Society Premium</td><td>João Silva</td><td><span class="badge bg-success bg-opacity-10 text-success">Confirmada</span></td></tr>
                            <tr><td>16:00 - 17:00</td><td>Futsal Arena</td><td>Pedro Santos</td><td><span class="badge bg-warning bg-opacity-10 text-warning">Pendente</span></td></tr>
                            <tr><td>19:00 - 20:30</td><td>Society Premium</td><td>Grupo F.C. Unidos</td><td><span class="badge bg-success bg-opacity-10 text-success">Confirmada</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="recent-section">
                    <div class="section-title"><i class="bi bi-bell me-2"></i>Atividade Recente</div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background:#DBEAFE; color:#3B82F6;"><i class="bi bi-person-plus"></i></div>
                        <div class="activity-info">
                            <div class="activity-text">Novo cliente cadastrado</div>
                            <div class="activity-time">Maria Oliveira - há 15 min</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background:#D1FAE5; color:#10B981;"><i class="bi bi-check-circle"></i></div>
                        <div class="activity-info">
                            <div class="activity-text">Reserva confirmada</div>
                            <div class="activity-time">João Silva - há 32 min</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background:#FEF3C7; color:#F59E0B;"><i class="bi bi-cash"></i></div>
                        <div class="activity-info">
                            <div class="activity-text">Pagamento recebido</div>
                            <div class="activity-time">R$ 150,00 - há 1 hora</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background:#FEE2E2; color:#EF4444;"><i class="bi bi-tools"></i></div>
                        <div class="activity-info">
                            <div class="activity-text">Manutenção reportada</div>
                            <div class="activity-time">Quadra 2 - há 2 horas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>