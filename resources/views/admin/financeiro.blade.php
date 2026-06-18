<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Financeira - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --admin-dark: #0F172A; --primary: #3B82F6; --success: #10B981; --danger: #EF4444; --warning: #F59E0B; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--admin-dark); margin: 0; }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-box { padding: 1.5rem; border-radius: 12px; color: white; }
        .stat-box.entradas { background: linear-gradient(135deg, var(--success), #34D399); }
        .stat-box.saidas { background: linear-gradient(135deg, var(--danger), #F87171); }
        .stat-box.saldo { background: linear-gradient(135deg, var(--primary), #60A5FA); }
        .stat-box.semana { background: linear-gradient(135deg, var(--warning), #FCD34D); color: #1F2937; }
        .stat-value { font-size: 2rem; font-weight: 700; margin: 0.5rem 0; }
        .stat-label { font-size: 0.9rem; opacity: 0.95; }
        .chart-container { position: relative; height: 300px; margin-top: 1rem; }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-primary-admin:hover { background: #2563EB; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">ADMIN</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-grid"></i> Visão Geral</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link active"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/pessoas" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>
    
    <main class="main">
        <div class="header">
            <div>
                <h1><i class="bi bi-cash-stack me-2"></i>Gestão Financeira</h1>
                <p class="text-muted mb-0">Módulo Financeiro - Entradas vs Saídas</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <input type="month" class="form-control" value="2026-06" style="width: 150px;">
                <button class="btn btn-primary-admin"><i class="bi bi-plus-lg me-2"></i>Nova Despesa</button>
                <span class="badge bg-secondary">Super Admin</span>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-box entradas">
                <div class="stat-label"><i class="bi bi-arrow-down-circle me-2"></i>Entradas (Pagamentos)</div>
                <div class="stat-value">R$ 4.850,00</div>
                <small><i class="bi bi-arrow-up"></i> +12% vs mês anterior</small>
            </div>
            <div class="stat-box saidas">
                <div class="stat-label"><i class="bi bi-arrow-up-circle me-2"></i>Saídas (Despesas)</div>
                <div class="stat-value">R$ 1.240,00</div>
                <small><i class="bi bi-arrow-down"></i> -5% vs mês anterior</small>
            </div>
            <div class="stat-box saldo">
                <div class="stat-label"><i class="bi bi-piggy-bank me-2"></i>Saldo Líquido</div>
                <div class="stat-value">R$ 3.610,00</div>
                <small>Margem: 74%</small>
            </div>
            <div class="stat-box semana">
                <div class="stat-label"><i class="bi bi-trophy me-2"></i>Melhor Semana</div>
                <div class="stat-value">Semana 3</div>
                <small>Maior entrada: R$ 1.600</small>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card-custom">
                    <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart me-2"></i>Entradas vs Saídas por Semana</h5>
                    <div class="chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <h5 class="fw-bold mb-3"><i class="bi bi-pie-chart me-2"></i>Despesas por Categoria</h5>
                    <div class="chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: #3B82F6; width: 12px; height: 12px; border-radius: 50%;"></span>
                            <small>Salários</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: #8B5CF6; width: 12px; height: 12px; border-radius: 50%;"></span>
                            <small>Contas</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: #F59E0B; width: 12px; height: 12px; border-radius: 50%;"></span>
                            <small>Manutenção</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge" style="background: #9CA3AF; width: 12px; height: 12px; border-radius: 50%;"></span>
                            <small>Outros</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Gráfico de Barras - Entradas vs Saídas por Semana
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            datasets: [
                {
                    label: 'Entradas',
                    data: [1200, 800, 1600, 1250],
                    backgroundColor: '#10B981',
                    borderRadius: 6
                },
                {
                    label: 'Saídas',
                    data: [300, 200, 400, 340],
                    backgroundColor: '#EF4444',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { usePointStyle: true, boxWidth: 8 }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#F1F5F9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Gráfico de Pizza - Despesas por Categoria
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Salários', 'Contas', 'Manutenção', 'Outros'],
            datasets: [{
                data: [600, 300, 200, 140],
                backgroundColor: ['#3B82F6', '#8B5CF6', '#F59E0B', '#9CA3AF'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            cutout: '65%'
        }
    });
</script>
</body>
</html>